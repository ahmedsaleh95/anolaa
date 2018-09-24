<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
        //
    #GET COUNTRY OF city
    public function country()
    {
        return $this->belongsToMany('App\Country');
    }

	# country has many cities
    // 
    public function areas()
    {
        return $this->hasMany('App\Area');
    }

    #get user of CITY
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
