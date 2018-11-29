<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timer extends Model
{
    //
    protected $table = 'timers';
    protected $guarded = [];
    

    public function devices()
    {
    	return $this->belongsToMany('App\Device')->withTimestamps();
    }
}
