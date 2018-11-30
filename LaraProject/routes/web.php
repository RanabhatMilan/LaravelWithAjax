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
    return view('');
});


Route::get('/','UserInfoController@show');
Route::post('userinfo/storedata','UserInfoController@storedata')->name('userinfo.storedata');
Route::get('/userinfo/removedata','UserInfoController@removedata')->name('userinfo.removedata');

Route::get('/userinfo/multidelete','MultipleDeleteController@multidelete')->name('userinfo.multidelete');


Route::get('showdata/search_action','LiveSearchController@search_action')->name('showdata.search_action');


Route::get('showdata/pdf','PdfController@pdf');




