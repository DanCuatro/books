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
Route::get('/libros', 'BookController@index');

Route::put('/libros/actualizar', 'BookController@update');

Route::post('/libros/guardar', 'BookController@store');

Route::delete('/libros/borrar/{id}', 'BookController@destroy');

Route::get('/libros/buscar', 'BookController@show');
