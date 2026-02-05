<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\ReserveController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::any('/submit-contact-form', 
    [ContactFormController::class, 'submit']
)->name('submit_contact_form');


Route::any('/reserveflat', 
   [ReserveController::class, 'reserve']
)->name('reserveflat');

Route::any('/submit-reserve-form', 
    [ReserveController::class, 'submit']
)->name('submit_reserve_form');

Route::post('/payment/callback', [ReserveController::class, 'callback'])->name('payment.callback');
Route::post('/payment/callback/medoro', [ReserveController::class, 'medoroCallback'])->name('payment.callback.medoro');
Route::post('/payment/success', [ReserveController::class, 'callback'])->name('payment.success');
Route::post('/payment/fail', [ReserveController::class, 'callbackfail'])->name('payment.fail');

