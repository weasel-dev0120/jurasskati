<?php

namespace App\Http\Controllers;

use App\PaymentGateways\Medoro\MedoroGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use TypiCMS\Modules\Flats\Models\Flat;
use TypiCMS\Modules\Flats\Models\FlatReserveInfo;
use App\Helpers\EcommerceHelper;
use App\Helpers\EcommerceSOAPHelper;
use Redirect;
use Carbon\Carbon;

class ReserveController extends Controller
{

    public function reserve(Request $request) {
        $data = $request->all();
        \Session::put('flatID', $data['id']);     
        
        return true;
    }


    public function submit(Request $request) {

        $flatId = $request->input('flat_no');        
        $current_timestamp = Carbon::now()->timestamp;
        $flat = Flat::where('number', $flatId)->first();        
        $flatPrice = $flat->price;
        $flatInfo = new FlatReserveInfo();
        $flatInfo->name = $request->input('name');;
        $flatInfo->last_name = $request->input('last_name');
        $flatInfo->email = $request->input('email');
        $flatInfo->company_name = $request->input('company_name');
        $flatInfo->phone = $request->input('phone');
        $flatInfo->payment_method = 'credit_card';
        $flatInfo->amount = 1500;
        $flatInfo->status = "pending";
        $flatInfo->payment_id="";
        $flatInfo->order_id=$current_timestamp;
        $flatInfo->flat_id=$flatId; 
        $flatInfo->code = $request->input('code');
	$fi=  $flatInfo->save();
        $orderId  = $flatInfo->number;
        
        $flatNo = $flat->number;
        $name = $flatInfo->name;
        $square = $flat->total_area;
        $totalPrice = $flat->price;
        $floor = $flat->floor;

        $medoroGateway = new MedoroGateway();
        try {

            $formData = $medoroGateway->initiatePayment(1500 *100, $current_timestamp);

        } catch (\Exception $e) {


		Log::error($e->getMessage());
    		return $e->getMessage();
	}



        return view('payment_medoro',[
            "action"=>$formData["action"],
            "fields"=>$formData["fields"],
            "flatPrice"=>$flatPrice
        ]);

    }
    
    public function medoroCallback(Request $request)
    {
        $medoroGateway = new MedoroGateway();
        $data = $medoroGateway->getPaymentStatus($request);
        $order = $data->Order;
        $Card = $data->Card;
        $payment = $data->Payment;
        $payment_id= $payment->ID;
        $pi= $payment_id +0;
        $orderId = $order->ID;
        
	$flatInfo = FlatReserveInfo::where('order_id', $orderId)->first();
        if($flatInfo){
            $email = $flatInfo->email;           
            $flatInfo->status = "paid";
            $flatInfo->payment_id =$pi;
            $flatInfo->save();            

            $flatId = $flatInfo->flat_id;
            $flat = Flat::where('number', $flatId)->first();
            if ($flat){

                $flat->availability = '1';
                $flat->save();                
                
            }
            $this->sendEmail($email,$flatInfo,$flat);

        }


        return view('payment_success',['data'=>$data]);
    }   
    
    
    public function sendEmail($email,$flatInfo,$flat)
    {
    
    	$flatNo = $flat->number;
        $name = $flatInfo->name;
        $sqare = $flat->total_area;
        $totalPrice = $flat->price;
        $floor = $flat->floor;
        $useremail = $flatInfo->email;
        $code = $flatInfo->code;
        $company = $flatInfo->company_name;
        
        $floorNumber = $flat->floor;
        
        
	$imgPath = "images/floorplans/a{$floorNumber}.svg";
	$class = "floorplan a{$floorNumber}";
	
	$floorPlan = "
	    <a href='https://jurasskati.lv/{$imgPath}' target='_blank'>
	        stāva plāns
	    </a>\n";
	    
        $body = "
		<html>
		<body style='font-family: Arial, sans-serif; color: #333;'>
		    <p>Sveiki {$name},</p>

		    <p>Esam saņēmuši Jūsu pirmsrezervāciju par dzīvokli <strong>{$flatNo}</strong>. Dubultu prospekts 101, LV-2008, Jūrmala.<br>
		    Tālāk ir detalizēta informācija:</p>

		    <h3>Dzīvokļa informācija:</h3>
		    <ul>	    	

			<li><strong>Vārds:</strong> {$sqare} m²</li>
		        <li><strong>E-pasts:</strong> {$useremail} </li>
		        <li><strong>Personas/reģistrācijas kods:</strong> {$flatNo}</li>
		        <li><strong>Uzņēmuma nosaukums:</strong> {$company}</li>
		        <li><strong>Reģistrācijas kods:</strong> {$code}</li>
		        <li><strong>Platība:</strong> {$sqare} m²</li>
		        <li><strong>Dzīvokļa kopējā cena:</strong> {$totalPrice} €</li>
		        <li><strong>Rezervācijas maksa:</strong> 1500,00 € (saņemta)</li>
		        <li><strong>Stāvs:</strong> {$floor}</li>
		    </ul>

		    <p>Šim e-pastam ir pievienoti pielikumi: 
		        <a href='https://jurasskati.lv/storage/files/d101-contract.pdf' target='_blank'>Distances līgums</a>, {$floorPlan}.
		    </p>

		    <p>Mēs ar Jums sazināsimies tuvākajā laikā, lai turpinātu rezervācijas procesu un noslēgtu rezervācijas līgumu. Ja Jums ir kādi jautājumi vai nepieciešama papildu informācija, lūdzu, sazinieties ar savu kontaktpersonu saistībā ar šo rezervāciju:</p>

		    <h3>Kontaktpersona:</h3>
		    <p>
		        Edgars Grinbergs<br>
		        <a href='tel:+37122109109'>+371 22109109</a><br>
		        <a href='mailto:edgars@incity.lv'>edgars@incity.lv</a>
		    </p>

		    <p>Paldies, ka izvēlējāties <strong>Jūras Skati</strong>!</p>
		</body>
		</html>
	    ";	
	
	Mail::send([], [], function ($message) use ($email, $body) {
		$message->to($email)
			->cc('info@jurasskati.lv')
			->subject('Jūsu dzīvoklis ir veiksmīgi rezervēts')
			->html($body, 'text/html');
	});
    }

    public function callbackfail()
    {
        return view('payment_fail');
    }   
    


}
