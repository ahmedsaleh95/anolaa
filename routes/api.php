<?php

use Illuminate\Http\Request;
use Carbon\Carbon;
use pragmaRX\Countries\package\Countries;


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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->get('/index', 'Api\DeviceController@index');
Route::middleware('auth:api')->get('/show/{id}', 'Api\DeviceController@show');
Route::middleware('auth:api')->delete('/destroy/{id}', 'Api\DeviceController@destroy');
Route::middleware('auth:api')->post('/update/{id}', 'Api\DeviceController@update');
Route::middleware('auth:api')->post('/create', 'Api\DeviceController@create');

Route::middleware('auth:api')->post('/qrcode', 'Api\DeviceController@checkqrcode');
Route::middleware('auth:api')->post('/control/{device}', 'Api\DeviceController@controldevice');
Route::middleware('auth:api')->post('/timer/create', 'Api\TimerController@create');




// Route::get('places', 'Api\UserController@places');
Route::get('countries', 'Api\UserController@countries');
Route::get('country/{id}', 'Api\UserController@country');
Route::get('city/{id}', 'Api\UserController@city');

Route::get('mm', function ()
{
	$countries = new Countries();
	echo $countries->where('cca2','IT')->first()->hydrateCurrencies()->currencies->EUR->coins->frequent->first();
});





Route::post('login', 'Api\UserController@login');
Route::post('register', 'Api\UserController@register');

Route::middleware('auth:api')->post('/feedback/create', 'Api\FeedbackController@create');





