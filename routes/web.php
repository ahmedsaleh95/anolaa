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

Route::post('/fire','api\UserController@fire');


Route::get('/light', function () {
    return view("light");
});

Route::get('/time',function ()
{
	$c = Carbon::now();
	return $c->addHour(2);
});
