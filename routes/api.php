<?php

use Illuminate\Http\Request;

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

Route::namespace("API")->group(function () {
	Route::prefix('espj')->namespace("eSPJ")->group(function () {
		Route::prefix('st')->group(function () {
			Route::get("data","stAPIController@data");
			Route::get("{id}","stAPIController@detail");
		});
		Route::prefix('sp2d')->group(function () {
			Route::get("data","sp2dAPIController@data");
			Route::get("{id}","sp2dAPIController@detail");
		});
		Route::prefix('spj')->group(function () {
			Route::get("data","spjAPIController@data");
		});
	});
});
