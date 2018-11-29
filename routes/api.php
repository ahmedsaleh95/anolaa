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

//-----------
# Device
//-----------
Route::middleware('auth:api')->get('/index', 'Api\DeviceController@index');
Route::middleware('auth:api')->get('/show/{id}', 'Api\DeviceController@show');
Route::middleware('auth:api')->delete('/destroy/{id}', 'Api\DeviceController@destroy');
Route::middleware('auth:api')->post('/update/{id}', 'Api\DeviceController@update');
Route::middleware('auth:api')->post('/create', 'Api\DeviceController@create');

Route::middleware('auth:api')->post('/qrcode', 'Api\DeviceController@checkqrcode');
Route::middleware('auth:api')->post('/control/{device}', 'Api\DeviceController@controldevice');
//---------
# Timer
//---------
Route::middleware('auth:api')->post('/timer/create/{id}', 'Api\TimerController@create');


//---------
# schedule
//---------
Route::middleware('auth:api')->post('/schedule/create/{id}', 'Api\ScheduleController@create');

//------------
#History
//------------
Route::middleware('auth:api')->get('/viewAll/{id}', 'Api\HistoryController@index');

//---------
# User
//---------
Route::get('country/{id}', 'Api\UserController@country');
//login and register
Route::post('login', 'Api\UserController@login');
Route::post('register', 'Api\UserController@register');
//edit profile
Route::middleware('auth:api')->post('/user/update', 'Api\UserController@update');
//---------------------------
# feedback related to user
//---------------------------
Route::middleware('auth:api')->post('/feedback/create', 'Api\FeedbackController@create');





