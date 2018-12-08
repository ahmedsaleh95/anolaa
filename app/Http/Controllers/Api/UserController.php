<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use ArrayObject;
use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Renderable;
use Symfony\Component\HttpFoundation\Response as BaseResponse;


use Validator;
use Khsing\World\World;
use Khsing\World\Models\Country;
use App\Mailcode;


// php artisan passport:install

class UserController extends BaseController
{


    /**
     * Register User Data .
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        //
        $obj = new BaseController();
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email|unique:Users', 
            'password' => 'required|min:8',
            'date_of_birth' => 'required|date|date_format:Y-m-d',
            'country_id' => 'required',
            'city_id' => 'required',
            'phone' => 'required|unique:Users|min:12|max:12',
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']); 
        // $user = User::create($input); 
        DB::beginTransaction();
        if ($user = User::create($input)) {
        #AccessToken
        $token = User::grantToken($request);
        #Country and City
            if ($country = Country::where('callingcode', $user->country_id)->first()) {
                $countryName['countryName'] = $country->name;
                if ($city = $country->children()->find($user->city_id)) {
                    $cityName['cityName'] = $city->name;
                    $fullUser = array_merge($user->toArray() , $countryName ,$cityName);
                    try {
                        $random_hash = bin2hex(random_bytes(2));
                        $data = array('code'=>$random_hash);
                        \Mail::send('ahln', $data, function($message) {
                        $message->to(request('email') , request('name'))->subject
                                ('Verfication Code');
                        $message->from('info@anolaa.com','Anolaa');
                          });
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return response()->json(['notes'=> $e->getMessage()] , 400);
                    }
                    if (!Mailcode::create([
                        'email'=>request('email'),
                        'code'=>$random_hash,
                    ])) {
                        # code...
                        return response()->json(['error'=> "Code for verfication not saved"] , 401);
                    }
                    
                    DB::commit();
                    return response()->json([
                        'user'=> $fullUser , 'token'=>json_decode($token->getcontent())]);
                } else {
                    DB::rollBack();
                    return response()->json(['error'=> "no Citries found"] , 401);
                }    
            } else {
                DB::rollBack();
                return response()->json(['error'=> "no Countries found"] , 401);
            }
        } else {
            return response()->json(['error'=> "User not added"] , 401);
        }
    }

    /**
     * Login an Existing User.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        //
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            if ($country = Country::where('callingcode', $user->country_id)->first()) {
                $countryName['countryName'] = $country->name;
                if ($city = $country->children()->find($user->city_id)) {
                    $cityName['cityName'] = $city->name;
                    $fullUser = array_merge($user->toArray() , $countryName ,$cityName);
                    // $success['token'] =  $user->createToken('userLogin')-> accessToken;
                    $token = User::grantToken($request);
                    return response()->json(['token'=>json_decode($token->getcontent()) , "user"=> $fullUser]);
                } else {
                    return response()->json(['error'=> "no Citries found"] , 401);
                }    
            } else {
                return response()->json(['error'=> "no Countries found"] , 401);
            } 
        } 
        else{
            return response()->json(['error'=>'This user not found']); 
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [  
            'email' => 'email|unique:Users', 
            'password' => 'min:8',
            'date_of_birth' => 'date|date_format:Y-m-d',
            'phone' => 'unique:Users|min:12|max:12',
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $user = Auth::user();
        $input = $request->all(); 
        if ($request->has('country_id') && $request->has('city_id')) {
            # code...
            if ($country = Country::where('callingcode', $input['country_id'])->first()) {
                if ($city = $country->children()->find($input['city_id'])) {

                } else {
                    return response()->json(['error'=> "no Citries found"] , 401);
                } 
            }
            else{
                return response()->json(['error'=> "no Countries found"] , 401);
            }
        }
        elseif ($request->has('country_id') && !$request->has('city_id')) {
            # code...
            return response()->json(['error'=> "Must provide a City"], 401);           
        }
        elseif ($request->has('city_id')) {
            # code...
            $country = Country::where('callingcode', $user->country_id)->first();
            if ($city = $country->children()->find($input['city_id'])) {

            } else {
                return response()->json(['error'=> "City not related to Country"] , 401);
            } 
        }
        if ($request->has('password')) {
            # code...
            $input['password'] = bcrypt($input['password']);
        }
        ;
        if ($user->update($input)) {
            # code...
            return response()->json(['data'=> Auth::user()]);
        } else {
            # code...
            return response()->json(['error'=> "Not updated"], 401);
        }        
    }


    /**
     *Return (ALL) Countries -- Cities -- Areas 
    */
    // public function places()
    // {
    //     //
    //     return response()->json(['Countries'=> Country::with('cities.areas')->get()]);
    // }


    /**
        *Return (ALL) Cities of Current country ID
    */
    public function country($id)
    {
        //
        $country = Country::where('callingcode', $id)->get();
        $cities = $country[0]->children();
        return response()->json(['Cities'=> $cities]);
    }

    public function refreshToken(Request $request)
    {
        # code...
        $request->request->add([ 
        'grant_type' => 'refresh_token', 
        'client_id' => '2', 
        'client_secret' => 'w1c9rRX7JQXgUfv03qnVjML65mVA6iNjrmfNIAGp',
        'refresh_token' => $request->refresh_token,
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
