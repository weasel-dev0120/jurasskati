<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Log;

class ContactFormController extends Controller
{
    public function submit(Request $request) {
        try {
            //\Debugbar::disable();
            //app('debugbar')->disable();
            $input = $request->validate([
                'name' => 'required',
                'email' => 'email|required',
                'message' => 'required',
            ]);
            $to = 'info@jurasskati.lv';
            Mail::to($to)->send(new ContactFormMail($input));
            return response('ok');
        } catch (\Exception $e) {
            Log::error(
                "Exception sending contact from email:\n\n" . $e->getMessage());
            return response('exception');
        }
        return response('undefined');
    }
}
