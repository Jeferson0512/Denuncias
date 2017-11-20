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

Route::get('/', function () {
    return view('welcome');
});
*/


Route::group(['prefix'=>'denuncias/r1'], function(){
    
    //Route::post('login', 'Auth\ApiController@login');
    //Route::get('usuario','Auth\ApiController@index');
    //route::post('create','Auth\ApiController@store');
    Route::resource('registro','RegistroController');
    Route::post('user_login', 'UsuarioController@login');
    Route::post('user_register', 'UsuarioController@store');
    Route::get('user_listado', 'UsuarioController@index');
});
