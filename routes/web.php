<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/logout', [\App\Http\Controllers\ApplicationController::class, 'logout'])->name('logout');
Route::get('qrcode-details', [\App\Http\Controllers\ApplicationController::class, 'displayQrcodeDetails'])->middleware('throttle:10,1');
#FORMS
Route::get('/partial-form', [\App\Http\Controllers\ApplicationController::class, 'partialForm'])->name('partialForm');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home',[\App\Http\Controllers\ApplicationController::class,'home'])->name('home');

    Route::post('/password/update', [\App\Http\Controllers\ApplicationController::class, 'changePassword'])->name('changePassword');

    Route::get('/get_certificates', [\App\Http\Controllers\ApplicationController::class, 'getCertificates'])->name('getCertificates');
    Route::post('/store_certificate', [\App\Http\Controllers\ApplicationController::class, 'storeCertificate'])->name('storeCertificate');
    Route::put('/tag_certificate', [\App\Http\Controllers\ApplicationController::class, 'tagCertificate'])->name('tagCertificate');
    Route::delete('/delete_certificate', [\App\Http\Controllers\ApplicationController::class, 'deleteCertificate'])->name('deleteCertificate');

    #PREVIEWS
    Route::get('/print-preview', [\App\Http\Controllers\ApplicationController::class, 'printPreview'])->name('printPreview');

    Route::get('/generate_report', [\App\Http\Controllers\ApplicationController::class, 'generateReport'])->name('generateReport');


});

