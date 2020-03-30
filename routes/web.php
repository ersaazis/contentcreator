<?php

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

Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => ['web', \ersaazis\cb\middlewares\CBBackend::class], 'prefix' => cb()->getAdminPath()], function () {
    Route::get('/getproject/{id}','AdminPekerjaanController@getproject');
    Route::post('/pekerjaan_admin/konfirmasi','AdminPekerjaanAdminController@konfirmasi');
    Route::post('/penarikan_uang/penarikan','AdminPenarikanUangController@penarikan');
    
});