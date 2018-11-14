<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timer extends Model
{
    //
    protected $fillable = ['alert', 'alertAfter' , 'created_at', 'updated_at'];
    protected $table = 'timers';


    public function devices()
    {
    	return $this->belongsToMany('App\Device')->withTimestamps();
    }
}
