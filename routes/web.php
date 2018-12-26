<?php


use App\Events\StatusLiked;
use Illuminate\Support\Str;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;

use Khsing\World\World;
use Khsing\World\Models\Country;
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
	$request = Request::create('https://google.com', 'GET');
    return app()->handle($request);
        // return $response;
    return 'hello laravel';
});

Route::post('/fire','api\UserController@fire');


Route::get('/light', function () {
    return view("light");
});


Route::get('t',function ($value='true')
{
	# code...
	$retVal = ($value == "true") ? 1 : 0 ;
	return Carbon::now();
	return $retVal;
});

Route::get('s',function ()
{
	# code...
	Mail::send('anolaa',  ['hello'=>'no'] ,function($message) {
            $message->to('ahmedsaleh_95@yahoo.com' , "anaa")->subject
                    ('Verfication Code');
            $message->from('info@anolaa.com','Anolaa');
              });

});
