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
Route::get('/partial-form', [\App\Http\Controllers\ApplicationController::class, 'partialForm'])->name('partialForm');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home',[\App\Http\Controllers\ApplicationController::class,'home'])->name('home');
    Route::post('/password/update', [\App\Http\Controllers\ApplicationController::class, 'changePassword'])->name('changePassword');
    Route::get('/print-preview', [\App\Http\Controllers\ApplicationController::class, 'printPreview'])->name('printPreview');

    Route::patch('/password', [\App\Http\Controllers\ApplicationController::class, 'changePassword'])->name('password.update');

    Route::get('/certificates', [\App\Http\Controllers\ApplicationController::class, 'getCertificates'])->name('certificates.index');
    Route::post('/certificates', [\App\Http\Controllers\ApplicationController::class, 'storeCertificateResource'])->name('certificates.store');
    Route::get('/certificates/{certificate}', [\App\Http\Controllers\ApplicationController::class, 'showCertificate'])->name('certificates.show');
    Route::match(['put', 'patch'], '/certificates/{certificate}', [\App\Http\Controllers\ApplicationController::class, 'updateCertificateResource'])->name('certificates.update');
    Route::delete('/certificates/{certificate}', [\App\Http\Controllers\ApplicationController::class, 'destroyCertificate'])->name('certificates.destroy');
    Route::patch('/certificates/{certificate}/status', [\App\Http\Controllers\ApplicationController::class, 'updateCertificateStatus'])->name('certificates.status');
    Route::patch('/certificates/{certificate}/complete', [\App\Http\Controllers\ApplicationController::class, 'completeCertificate'])->name('certificates.complete');
    Route::get('/certificates/{certificate}/preview', [\App\Http\Controllers\ApplicationController::class, 'previewCertificate'])->name('certificates.preview');

    Route::get('/reports/certificates', [\App\Http\Controllers\ApplicationController::class, 'generateTableReport'])->name('reports.certificates.index');
    Route::get('/reports/certificates/export', [\App\Http\Controllers\ApplicationController::class, 'generateReport'])->name('reports.certificates.export');

    Route::get('/lookups/receivers', [\App\Http\Controllers\ApplicationController::class, 'receiver'])->name('lookups.receivers');
    Route::get('/lookups/doctors', [\App\Http\Controllers\ApplicationController::class, 'doctors'])->name('lookups.doctors');
    Route::get('/dashboard/counts', [\App\Http\Controllers\ApplicationController::class, 'dashboardCount'])->name('dashboard.counts');

    Route::post('/queue/tickets', [\App\Http\Controllers\ApplicationController::class, 'storeTicket'])->name('queue.tickets.store');
    Route::put('/queue/session', [\App\Http\Controllers\ApplicationController::class, 'storeSession'])->name('queue.session.store');
    Route::get('/queue/tickets/tv', [\App\Http\Controllers\ApplicationController::class, 'getTicketsTv'])->name('queue.tickets.tv');
    Route::delete('/queue/tickets', [\App\Http\Controllers\ApplicationController::class, 'truncateTicket'])->name('queue.tickets.truncate');
});
