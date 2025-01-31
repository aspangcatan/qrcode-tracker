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
Route::get('/tv', [\App\Http\Controllers\ApplicationController::class, 'tv'])->name('tv');

Route::post('/authenticate', [\App\Http\Controllers\ApplicationController::class, 'authenticate'])->name('authenticate')->middleware('throttle:10,1');
Route::get('/logout', [\App\Http\Controllers\ApplicationController::class, 'logout'])->name('logout');
Route::get('/qrcode-details', [\App\Http\Controllers\ApplicationController::class, 'displayQrcodeDetails'])->middleware('throttle:10,1');
Route::get('/tickets/tv', [\App\Http\Controllers\ApplicationController::class, 'getTicketsTv'])->name('getTicketsTv');
#FORMS
Route::get('/partial-form', [\App\Http\Controllers\ApplicationController::class, 'partialForm'])->name('partialForm');

Route::get('/tickets/truncate', [\App\Http\Controllers\ApplicationController::class, 'truncateTicket'])->name('truncateTicket');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home',[\App\Http\Controllers\ApplicationController::class,'home'])->name('home');
    Route::get('/get_certificates', [\App\Http\Controllers\ApplicationController::class, 'getCertificates'])->name('getCertificates');
    Route::post('/password/update', [\App\Http\Controllers\ApplicationController::class, 'changePassword'])->name('changePassword');
    Route::post('/store_certificate', [\App\Http\Controllers\ApplicationController::class, 'storeCertificate'])->name('storeCertificate');
    Route::put('/tag_certificate', [\App\Http\Controllers\ApplicationController::class, 'tagCertificate'])->name('tagCertificate');
    Route::put('/tag_as_complete', [\App\Http\Controllers\ApplicationController::class, 'tagAsComplete'])->name('tagAsComplete');
    Route::delete('/delete_certificate', [\App\Http\Controllers\ApplicationController::class, 'cancelCertificate'])->name('cancelCertificate');
    #QUEUING
    Route::post('/queuing/store', [\App\Http\Controllers\ApplicationController::class, 'storeTicket'])->name('storeTicket');
    Route::post('/session/store', [\App\Http\Controllers\ApplicationController::class, 'storeSession'])->name('storeSession');
    #PREVIEWS
    Route::get('/print-preview', [\App\Http\Controllers\ApplicationController::class, 'printPreview'])->name('printPreview');
    Route::get('/generate_report', [\App\Http\Controllers\ApplicationController::class, 'generateReport'])->name('generateReport');
    Route::get('/generate_table_report', [\App\Http\Controllers\ApplicationController::class, 'generateTableReport'])->name('generateTableReport');

    Route::get('/receivers', [\App\Http\Controllers\ApplicationController::class, 'receiver'])->name('getReceivers');
    Route::get('/doctors', [\App\Http\Controllers\ApplicationController::class, 'doctors'])->name('getDoctors');
});

