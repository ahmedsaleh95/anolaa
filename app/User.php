<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Route;

use ArrayObject;
use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Renderable;
use Symfony\Component\HttpFoundation\Response as BaseResponse;


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

    public static function grantToken( Request $request)
    {
        # code...
        $request->request->add([ 
        'grant_type' => 'password', 
        'client_id' => '2', 
        'client_secret' => 'w1c9rRX7JQXgUfv03qnVjML65mVA6iNjrmfNIAGp', 
        'username' => $request->email,
        'password' => $request->password, 
        'scope' => null 
        ]);
     // $proxy = Request::create( 'oauth/token', 'POST' );
     $tokenRequest = Request::create(
            env('APP_URL').'/oauth/token',
            'post'
        );
    // $request = Request::create('/oauth/token', 'POST', $data);
    // app()->handle($request);
        $response = Route::dispatch($tokenRequest);
        return $response;
        // return  ["d"=> json_decode($response->getContent()) ,"data"=> $u];
    }
}
