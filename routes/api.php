<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route Auth
Route::post('register', 'Api\UserController@register');//register
/**
 * name
 * email
 * password
 * phone_number
 */

Route::post('login', 'Api\UserController@login');//login
/**
 * email
 * password
 */

Route::get('/email/resend', 'Api\VerificationController@resend')->name('verification.resend');//kirim email verivikasi
Route::get('/email/verify/{id}/{hash}', 'Api\VerificationController@verify')->name('verification.verify');//kirim email verivikasi

//route reset password
Route::post('password/email', 'Api\ForgotPasswordController@forgot');//mengirim email reset password
/**
 * email
 */

Route::post('password/reset', 'Api\ForgotPasswordController@reset');
/**
 * email
 * token
 * password
 */

Route::group(['namespace' => 'Api', 'middleware' => 'jwt.verify'], function () {

    // Route User -> Nasabah, Pengurus1, Pengurus2
    Route::get('profile', 'ProfileController@index');//get profile 
    Route::get('profile/{id}', 'ProfileController@index');//get user by id
    Route::post('profile', 'ProfileController@update');//update profile & avatar
    /**
     * phone_number
     * name
     * avatar
     */

    Route::post('ganti', 'ProfileController@change');//change password
    /**
     * password
     * password_change
     */

    // Route penyetoran -> Nasabah
    Route::get('historyPenjemputan', 'PenyetoranController@historyPenjemputan');//history penjemputan sampah
    Route::post('setorDriver/{fee}', 'PenyetoranController@store');//nasabah setor sampah dijemput driver
    /**
     * coba tanya rais...
     */

    Route::post('setor', 'PenyetoranController@store');//nasabah antar sampah sendiri ke gudang
    /**
     * coba tanya rais...
     */

    Route::post('jemput', 'PenyetoranController@jemput');//permintaan jemput sampah oleh driver
    /**
     * image
     * address
     * phone_number
     * description
     */

    // Route Transaksi -> Nasabah
    Route::get('getTabungan', 'TransaksiController@index');//melihat buku tabungan nasabah
    Route::get('getSaldo', 'TransaksiController@show');//cek saldo nasabah
    Route::get('riwayat/tarik', 'TransaksiController@riwayat');//riwayat penarikan saldo
    Route::post('tarikSaldo', 'TransaksiController@tarik');//tarik saldo oleh nasabah
    /**
     * nama
     * rekening (no)
     * nominal
     */

    // Route Gudang sampah -> Nasabah, Pengurus1, Pengurus2
    Route::get('getSampah', 'SampahController@index');//melihat sampah yang ada di gudang
    Route::get('getSampah/{id}', 'SampahController@show');//melihat sampah berdasarkan id jenisnya
    Route::get('getJenis', 'SampahController@getJenis');//melihat jenis sampah

    // Route Penjualan -> Pengurus 2
    Route::get('gudang', 'PenjualanController@index');//untuk melihat kapasitas sampah di gudang
    Route::post('sell', 'PenjualanController@store');//menginput hasil penjualan
    /**
     * jenis_sampah
     * berat
     * harga
     */

    //Route penjemputan -> Pengurus 1
    Route::get('penjemputan/daftar', 'PenjemputanController@index');//melihat permintaan penjemputan
    Route::get('penjemputan/selesai', 'PenjemputanController@selesai');//melihat yang sudah dijemput
    Route::get('penjemputan/penolakan', 'PenjemputanController@penolakan');//melihat yang tidak mau dijemput
    Route::post('penjemputan/penolakan/{penjemputan}', 'PenjemputanController@tolak');//menolak permintaan penjemputan (tandai dibatalkan)
    Route::post('penjemputan/konfirmasi/{penjemputan}', 'PenjemputanController@konfirmasiPenjemputan');//konfirmasi penjemputan (tandai selesai)

    //Route chat -> Nasabah dan Pengurus 1
    Route::get('allmessage', 'ChatController@index');//ambil semua pesan
    Route::get('chat/{id}', 'ChatController@getChat');//buat nge get pesan
    Route::post('chat/{id}', 'ChatController@sendChat');//buat ngirim pesan
    /**
     * message
     */
    Route::delete('chat/{id} ', 'ChatController@destroy');//hapus pesan

});
    