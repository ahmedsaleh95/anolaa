<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Kreait\Firebase;
 
use Kreait\Firebase\Factory;
 
use Kreait\Firebase\ServiceAccount;
 
use Kreait\Firebase\Database;

class Device extends Model
{
    //
    protected $guarded = [];
        //
    #get user of device
    public function user()
    {
        return $this->belongsTo('App\User');
    }


    public static function firebaseRef()
    {
    	//
	$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/Http/Controllers/Api/real-time-notiy-a7456b46fe12.json');

	$firebase = (new Factory)
	 
	->withServiceAccount($serviceAccount)
	 
	->withDatabaseUri('https://real-time-notiy.firebaseio.com/')
	 
	->create();
	 
	$database = $firebase->getDatabase();

	return $database;

    }

    public function timers()
    {
        return $this->belongsToMany(Timer::class);
    }


    public function schedules()
    {
        return $this->belongsToMany(Schedule::class);
    }
}
