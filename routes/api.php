<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//auth
Route::post('register', 'Api\UserController@register');//register (udah)
Route::post('login', 'Api\UserController@login');//login (udah)

Route::get('/email/resend', 'Api\VerificationController@resend')->name('verification.resend');//kirim email verivikasi (belom)
Route::get('/email/verify/{id}/{hash}', 'Api\VerificationController@verify')->name('verification.verify');//kirim email verivikasi (belom)

//forgot password
Route::post('password/email', 'Api\ForgotPasswordController@forgot');//mengirim email reset password 
Route::post('password/reset', 'Api\ForgotPasswordController@reset');//forgot password

Route::group(['namespace' => 'Api', 'middleware' => 'jwt.verify'], function () {
    
    // Route User -> Nasabah, Pengurus1, Pengurus2
    Route::get('profile', 'ProfileController@index')->middleware('verified');//menampilkan profil user yang sedang login (udah)
    Route::get('profile/{id}', 'ProfileController@show')->middleware('verified');//get user by id (udah)
    Route::patch('profile', 'ProfileController@update')->middleware('verified');//update profile (udah)
    Route::patch('ganti', 'ProfileController@change');//change password (udah)

    // Route penyetoran -> Nasabah
    Route::get('historyPenjemputan', 'PenyetoranController@historyPenjemputan');//History penjemputan sampah
    Route::post('setorDriver/{fee}', 'PenyetoranController@store');//Nasabah Setor Sampah Dijemput Driver
    Route::post('setor', 'PenyetoranController@store');//Nasabah Antar Sampah ke gudang
    Route::post('jemput', 'PenyetoranController@jemput');//permintaan jemput sampah oleh driver

    // Route Transaksi -> Nasabah
    Route::get('getTabungan', 'TransaksiController@index');//melihat buku tabungan nasabah
    Route::get('getSaldo', 'TransaksiController@show');//cek saldo nasabah
    Route::get('riwayat/tarik', 'TransaksiController@riwayat');//riwayat penarikan saldo
    Route::post('tarikSaldo', 'TransaksiController@tarik');//tarik saldo nasabah oleh nasabah

    // Route Gudang sampah -> Nasabah, Pengurus1, Pengurus2
    Route::get('getSampah', 'SampahController@index');// Melihat Sampah Yang ada di gudang
    Route::get('getSampah/{id}', 'SampahController@show');// Melihat Sampah berdasarkan id jenisnya
    Route::get('getJenis', 'SampahController@getJenis');// Melihat Jenis Sampah

    // Route Penjualan -> Pengurus 2
    Route::get('gudang', 'PenjualanController@index');//melihat kapasitas sampah di gudang
    Route::post('sell', 'PenjualanController@store');//menginput hasil penjualan

    //Route penjemputan -> Pengurus 1
    Route::get('penjemputan/daftar', 'PenjemputanController@index');//melihat permintaan penjemputan
    Route::get('penjemputan/selesai', 'PenjemputanController@selesai');//melihat yang sudah dijemput
    Route::get('penjemputan/penolakan', 'PenjemputanController@penolakan');//melihat yang tidak mau dijemput
    Route::post('penjemputan/penolakan/{penjemputan}', 'PenjemputanController@tolak');//menolak permintaan penjemputan
    Route::post('penjemputan/konfirmasi/{penjemputan}', 'PenjemputanController@konfirmasiPenjemputan');//konfirmasi penjemputan

    //Route chat -> Nasabah dan Pengurus 1
    Route::get('allmessage', 'ChatController@index');//ambil semua pesan
    Route::get('chat/{id}', 'ChatController@getChat');//buat nge get pesan
    Route::post('chat/{id}', 'ChatController@sendChat');//buat ngirim pesan
    Route::delete('chat/{id} ', 'ChatController@destroy');//hapus pesan
});