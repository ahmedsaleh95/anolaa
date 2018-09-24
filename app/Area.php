<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    //
    #get user of REGION
    public function users()
    {
        return $this->hasMany('App\User');
    }

	 #GET CITY OF REGION
    public function country()
    {
        return $this->belongsToMany('App\City');
    }
}
