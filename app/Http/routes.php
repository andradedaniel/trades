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

Route::auth();
Auth::loginUsingId(2, true);

Route::get('/', 'HomeController@index');
Route::get('/trades/{id?}', 'TradeController@index');

//Route::get('/home', 'HomeController@index');

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/trades/ativo/{ativoId}', function ($ativoId) {
    return "pagina com a lista dos trades do ativo ". $ativoId;
});

Route::get('/register', function () {
    //echo bcrypt('123456');
    return "Nao é possivel realizar o registro";
});