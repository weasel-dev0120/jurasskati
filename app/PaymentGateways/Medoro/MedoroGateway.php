<?php

namespace App\PaymentGateways\Medoro;

use Illuminate\Support\Facades\Storage;

class MedoroGateway
{



    public function initiatePayment($amount,$orderId)
    {
    
    	try {

  		$ecom = new MedoroEcommerce(array(
            	'merchant_id'	=> env('MEDORO_MERCHANT_ID','3713526'),
            	'gateway_key'	=> env('MEDORO_GATEWAY_KEY_PATH','gatewayKey.pem'),
            	'merchant_key'	=> env('MEDORO_PRIV_KEY_PATH','merchantkey.pem'),
            	'key_index'	=> env('MEDORO_KEY_INDEX','1')
        	));
        	$form = new EcommerceFORM($ecom);

        	$fields = $form->getRequest(array(
            		'AutoDeposit' => 'true', // PHP serializes boolean values incorrectly, so send this as string
            		'Payment' => array(
                	'Mode' => 5
            	),
            	'Order' => array(
                	'ID' 			=> $orderId,
                	'Amount'		=> $amount*1, // In minor units, thus 100 equals 1.00 EUR
                	'Currency'		=> 'EUR',
                	'Description'	=> 'Flat Booking'
            	),
            	'Notification' => 'Flat Booking'
        	), array(
            	'Callback' 		=>env('APP_URL') .'payment/callback/medoro',
            	'ErrorCallback'		=> env('APP_URL') .'payment/fail'
        	));
        	
        	$action = env('MEDORO_API_URL');

        	return array(
            	'action' => $action,
            	'fields' => $fields
        	);

	} catch (\Exception $e) {
	
		\Log::error($e->getMessage());
    		return $e->getMessage();
	}


	
    }
    
    public function getPaymentStatus($request)
    {
        $ecom = new MedoroEcommerce(array(
		'merchant_id'	=> env('MEDORO_MERCHANT_ID'),
	    	'gateway_key'	=> env('MEDORO_GATEWAY_KEY_PATH'),
	    	'merchant_key'	=> env('MEDORO_PRIV_KEY_PATH'),
	    	'key_index'	=> env('MEDORO_KEY_INDEX')
        ));
        $form = new EcommerceFORM($ecom);
        $response = $form->getResponse($request->all());
        return $response;
    }
}
