<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //
        # country has many cities
    // 
    public function cities()
    {
        return $this->hasMany('App\City');
    }

    //
    #get user of country
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
