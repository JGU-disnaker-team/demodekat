<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Data\WorkerController;

Route::get('/', [App\Http\Controllers\FrontendController::class, 'index']);
Route::get('/layanan', [App\Http\Controllers\FrontendController::class, 'layanan']);
Route::get('/layanan/{id}', [App\Http\Controllers\FrontendController::class, 'layanan_detail']);
Route::get('/tentang', [App\Http\Controllers\FrontendController::class, 'tentang']);
Route::get('/kontak', [App\Http\Controllers\FrontendController::class, 'kontak']);
Route::post('/send_kontak', [App\Http\Controllers\FrontendController::class, 'send_kontak']);

Auth::routes(['verify' => true]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/profil', [App\Http\Controllers\HomeController::class, 'profil'])->name('profil');
    Route::post('/update_profil', [App\Http\Controllers\HomeController::class, 'update_profil'])->name('update_profil');
    Route::get('/pesan/{id}', [App\Http\Controllers\HomeController::class, 'pesan'])->name('pesan');
    Route::post('/send_order', [App\Http\Controllers\HomeController::class, 'send_order'])->name('send_order');
    Route::resource('/data/slider', App\Http\Controllers\Data\SliderController::class)->middleware('role:superadmin');
    Route::resource('/data/kategori', App\Http\Controllers\Data\KategoriController::class)->middleware('role:superadmin');
    Route::resource('/data/bank', App\Http\Controllers\Data\BankController::class)->middleware('role:superadmin');
    Route::resource('/data/testimoni', App\Http\Controllers\Data\TestimoniController::class)->middleware('role:superadmin');
    Route::resource('/data/layanan', App\Http\Controllers\Data\LayananController::class)->middleware('role:superadmin');
    Route::put('/data/worker/{id}', [WorkerController::class, 'update'])->name('worker.update');
    Route::get('/data/kontak', [App\Http\Controllers\HomeController::class, 'kontak']);
    Route::resource('/data/member', App\Http\Controllers\Data\MemberController::class)->middleware('role:superadmin');
    Route::resource('/data/worker', App\Http\Controllers\Data\WorkerController::class)->middleware('role:superadmin');
    Route::resource('/data/admin', App\Http\Controllers\Data\AdminController::class)->middleware('role:superadmin');

    Route::get('/data/order/{id}/success_order', [App\Http\Controllers\Data\OrderController::class,'success_order']);
    Route::get('/data/order/{id}/konfirmasi', [App\Http\Controllers\Data\OrderController::class,'konfirmasi']);
    Route::post('/data/order/{id}/send_konfirmasi', [App\Http\Controllers\Data\OrderController::class,'send_konfirmasi']);
    Route::get('/data/order/{id}/bayar_diterima', [App\Http\Controllers\Data\OrderController::class,'bayar_diterima']);
    Route::get('/data/order/{id}/bayar_ditolak', [App\Http\Controllers\Data\OrderController::class,'bayar_ditolak']);
    Route::get('/data/order/{id}/terima_pekerjaan', [App\Http\Controllers\Data\OrderController::class,'terima_pekerjaan']);
    Route::get('/data/order/{id}/selesai_pekerjaan', [App\Http\Controllers\Data\OrderController::class,'selesai_pekerjaan']);
    Route::resource('/data/order', App\Http\Controllers\Data\OrderController::class);

    Route::get('/data/withdraw/{id}/diproses', [App\Http\Controllers\Data\WithdrawController::class,'diproses'])->middleware('role:superadmin');
    Route::get('/data/withdraw/{id}/selesai', [App\Http\Controllers\Data\WithdrawController::class,'selesai'])->middleware('role:superadmin');
    Route::get('/data/withdraw/{id}/ditolak', [App\Http\Controllers\Data\WithdrawController::class,'tolak'])->middleware('role:superadmin');
    Route::resource('/data/withdraw', App\Http\Controllers\Data\WithdrawController::class)->middleware('role:superadmin|worker');
});
