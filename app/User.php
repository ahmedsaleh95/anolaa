<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens , Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'date_of_birth', 'country_id', 'city_id', 'area_id', 'phone', 'profile_photo_url' 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    # user has many devices
    // 
    public function devices()
    {
        return $this->hasMany('App\Device');
    }

    //
    #GET COUNTRY OF USER
    public function country()
    {
        return $this->belongsToMany('App\Country');
    }

        //
    #GET CITY OF USER
    public function city()
    {
        return $this->belongsToMany('App\City');
    }


        # user has many devices
    // 
    public function messages()
    {
        return $this->hasMany('App\Feedback');
    }
}
