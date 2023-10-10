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
Route::get('/qrcode-details', [\App\Http\Controllers\ApplicationController::class, 'displayQrcodeDetails'])->middleware('throttle:5,1');
Route::get('/qrcode-hemb-details', [\App\Http\Controllers\ApplicationController::class, 'displayQrHembcodeDetails'])->middleware('throttle:10,1');
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

    Route::get('/generate-qrcode', [\App\Http\Controllers\ApplicationController::class, 'generateQrCode'])->name('generateQrCode');
    Route::get('/get_qr', [\App\Http\Controllers\ApplicationController::class, 'getQrList'])->name('getQrList');
    Route::post('/store_qr', [\App\Http\Controllers\ApplicationController::class, 'storeQr'])->name('storeQr');
    Route::delete('/delete_qr', [\App\Http\Controllers\ApplicationController::class, 'deleteQr'])->name('deleteQr');

    /////////////////////////
    ///
    Route::get('/generate-hemb-qrcode', [\App\Http\Controllers\ApplicationController::class, 'generateQrHembCode'])->name('generateQrHembCode');
    Route::get('/get_qr_hemb', [\App\Http\Controllers\ApplicationController::class, 'getQrHembList'])->name('getQrHembList');
    Route::post('/store_qr_hemb', [\App\Http\Controllers\ApplicationController::class, 'storeQrHemb'])->name('storeQrHemb');
    Route::delete('/delete_qr_hemb', [\App\Http\Controllers\ApplicationController::class, 'deleteQrHemb'])->name('deleteQrHemb');

});

