<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'register' => false,
]);

Route::get('/', function () {
    return view('welcome');
});

Route::fallback(function () {
    return view('errors.404');
});

Route::group(['namespace' => 'Web', 'middleware' => ['user.web']], function () {

    // Route Dashboard      -> Admin, Bendahara
    Route::get('/home', 'HomeController@index')->name('home');

    // Route Karyawan       -> Admin
    Route::get('/karyawan', 'KaryawanController@index')->name('karyawan.index');        
    Route::get('/karyawan/{id}', 'KaryawanController@show')->name('karyawan.show');     
    Route::post('/karyawan/store', 'KaryawanController@store')->name('karyawan.store'); 
    Route::put('/karyawan/update/{id}', 'KaryawanController@update');                   
    Route::delete('/karyawan/delete/{id}', 'KaryawanController@destroy');               

    //Route Naasabah        -> Admin
    Route::get('nasabah', 'UserController@index')->name('nasabah.index');                    
    Route::get('nasabah-blacklist', 'UserController@blacklist')->name('nasabah.blacklist');  
    Route::get('nasabah/tabungan/{id}', 'UserController@tabungan');                          
    Route::post('nasabah/store', 'UserController@store')->name('nasabah.store');            
    Route::post('nasabah/blacklist/{id}', 'UserController@softDelete');                     
    Route::post('nasabah/restore/{id}', 'UserController@restore');                          
    Route::post('nasabah/delete/{id}', 'UserController@delete');                           

    // Route Sampah         -> Admin
    Route::get('sampah', 'SampahController@getSampah')->name('sampah.index');            
    Route::get('sampah/{id}', 'SampahController@show');                                   
    Route::post('sampah', 'SampahController@store')->name('sampah.store');               
    Route::put('sampah/{id}/update', 'SampahController@update');                        
    Route::delete('sampah/{id}', 'SampahController@destroy');

    // Gudang
    Route::get('gudang', 'SampahController@getGudang')->name('gudang.index');             

    //Route keuangan bank   -> Admin, Bendahara
    Route::get('keuangan', 'KeuanganController@index')->name('keuangan.index');       

    //Route penyetoran      -> Admin, Bendahara
    Route::get('penyetoran', 'BendaharaController@penyetoran')->name('bendahara.penyetoran'); 

    // Route Penjualan      -> Andmin, Bendahara
    Route::get('penjualan', 'BendaharaController@penjualan')->name('bendahara.penjualan');  

    //Route Penarikan       -> Bendahara
    Route::get('penarikan-tunai', 'KeuanganController@getPenarikan')->name('keuangan.penarikan');            
    Route::get('penarikan-permintaan', 'KeuanganController@getPermintaan')->name('keuangan.permintaan');     
    Route::post('penarikan/tunai/store', 'KeuanganController@penarikan')->name('keuangan.tarik');            
    Route::post('penarikan/konfirmasi/{id}', 'KeuanganController@konfirmasi');
    Route::post('penarikan/tolak/{id}', 'KeuanganController@tolak');

    // Route ajax
    Route::get('alert', 'HomeController@alert');
});
