<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('device.search');
});*/

Route::group(['middleware'=>['web']], function () {
    Route::get('/search',[
        'uses'=>'DeviceController@getSearch',
        'as'=>'search'
    ]);

    Route::post('/searchdevice',[
        'uses'=>'DeviceController@postSearch',
        'as'=>'searchdevice'
    ]);

});


Route::group(['middleware'=>['api']], function () {
    Route::get('/devices',[
    	'uses'=>'DeviceController@devices',
    	'as'=>'devices'
    ]);
});
