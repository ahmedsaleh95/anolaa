<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    //
    protected $guarded = [];
    
    public function devices()
    {
    	return $this->belongsToMany('App\Device')->withTimestamps();
    }
}
