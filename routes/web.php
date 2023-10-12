<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

Route::get('/', [\App\Http\Controllers\ApplicationController::class, 'index'])->name('login');
Route::post('/authenticate', [\App\Http\Controllers\ApplicationController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', function () {
    Auth::logout();
    Session::flush();
    return redirect()->route('login');
})->name('logout');


Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', function () {
        if (session('access_rights') == 'MEDICAL')
            return view('home');
        else
            return view('hemb');
    });

    Route::post('/password/update', [\App\Http\Controllers\ApplicationController::class, 'changePassword'])->name('changePassword');

    Route::post('/store_certificate', [\App\Http\Controllers\ApplicationController::class, 'storeCertificate'])->name('storeCertificate');
    Route::delete('/delete_certificate', [\App\Http\Controllers\ApplicationController::class, 'deleteCertificate'])->name('deleteCertificate');
    Route::get('/get_certificates', [\App\Http\Controllers\ApplicationController::class, 'getCertificates'])->name('getCertificates');

    Route::get('/generate-qrcode', [\App\Http\Controllers\ApplicationController::class, 'generateQrCode'])->name('generateQrCode');
    Route::get('/get_qr', [\App\Http\Controllers\ApplicationController::class, 'getQrList'])->name('getQrList');


    #FORMS
    Route::get('/form-original', function () {
        return view('forms.medico_legal');
    });
});

