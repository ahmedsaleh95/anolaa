<?php


use App\Events\StatusLiked;
use Illuminate\Support\Str;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;
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
	// return QrCode::size(600)->generate(bcrypt('hello'));
	// if(Hash::check('hello' , bcrypt('hello')))
	// {
	// 	return "yes"; 
	// }
	// else
	// {
	// 	return "no";
	// }
	// return (String) Str::uuid();
	// return str_random(20);
	    QrCode::size(600)->generate('a43I43sv09' , '/Device/Device1.svg');   

});


Route::post('/fire','api\UserController@fire');


Route::get('/light', function () {
    return view("light");
});


Route::get('uuid',function ()
{
	return Uuid::generate()->string;
});

Route::get('/time',function ()
{
	return date("h:i:sa");
	// return Carbon::now();
});
