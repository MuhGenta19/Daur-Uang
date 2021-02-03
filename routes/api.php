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
    Route::get('profile', 'ProfileController@index'); 
    Route::get('profile/{id}', 'ProfileController@index');
    Route::post('profile/update', 'ProfileController@update');
    /**
     * phone_number
     * name
     * avatar
     */

    Route::post('password/change', 'ProfileController@change');
    /**
     * password
     * password_change
     */

    // Route penyetoran -> Nasabah
    Route::get('penjemputan/history', 'PenyetoranController@historyPenjemputan');
    Route::post('setorDriver/{fee}', 'PenyetoranController@store');//nasabah setor sampah dijemput driver
    Route::post('setor', 'PenyetoranController@store');//nasabah antar sampah sendiri ke gudang
    Route::post('jemput', 'PenyetoranController@jemput');
    /**
     * image
     * address
     * phone_number
     * description
     */

    // Route Transaksi -> Nasabah
    Route::get('tabungan', 'TransaksiController@index');
    Route::get('ceksaldo', 'TransaksiController@show');
    Route::get('penarikan/riwayat', 'TransaksiController@riwayat');
    Route::post('tarikSaldo', 'TransaksiController@tarik');
    /**
     * nama
     * rekening (no)
     * nominal
     */

    // Route Gudang sampah -> Nasabah, Pengurus1, Pengurus2
    Route::get('sampah', 'SampahController@index');
    Route::get('sampah/{id}', 'SampahController@show');
    Route::get('jenis', 'SampahController@getJenis');

    // Route Penjualan -> Pengurus 2
    Route::get('gudang', 'PenjualanController@index');
    Route::post('sell', 'PenjualanController@store');//menginput hasil penjualan
    /**
     * jenis_sampah
     * berat
     * harga
     */

    //Route penjemputan -> Pengurus 1
    Route::get('jemput/permintaan', 'PenjemputanController@index');
    Route::get('jemput/selesai', 'PenjemputanController@selesai');
    Route::get('jemput/penolakan', 'PenjemputanController@penolakan');
    Route::post('jemput/tolak/{penjemputan}', 'PenjemputanController@tolak');
    Route::post('jemput/konfirmasi/{penjemputan}', 'PenjemputanController@konfirmasiPenjemputan');

    //Route chat -> Nasabah dan Pengurus 1
    Route::get('messages', 'ChatController@index');
    Route::get('chat/{id}', 'ChatController@getChat');
    Route::post('chat/{id}', 'ChatController@sendChat');
    /**
     * message
     */
    Route::delete('chat/{id} ', 'ChatController@destroy');

});
    