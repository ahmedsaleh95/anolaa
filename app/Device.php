<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    //
    protected $guarded = [];
        //
    #get user of device
    public function user()
    {
        return $this->belongsToMany('App\User');
    }
}
