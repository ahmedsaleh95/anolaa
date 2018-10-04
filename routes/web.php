<?php


use App\Events\StatusLiked;
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
    return 'hello laravel';
});

Route::get('qr',function(){
	// return view('qr');
	return QrCode::size(600)->generate('hello');
});


Route::post('/fire','api\UserController@fire');


Route::get('/light', function () {
    return view("light");
});

