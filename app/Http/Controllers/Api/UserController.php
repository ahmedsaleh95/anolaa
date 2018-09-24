<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Country;
use App\City;
use App\Area;
use Illuminate\Support\Facades\Auth; 
use Validator;
// php artisan passport:install

class UserController extends BaseController
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required|min:6',
            'date_of_birth' => 'required|date|date_format:Y-m-d',
            'country_id' => 'required',
            'city_id' => 'required',
            'area_id' => 'required',
            'phone' => 'required|max:11|regex:/(01)[0-9]{9}/',

        ]);
        if ($validator->fails()) { 
                    return response()->json(['error'=>$validator->errors()], 401);            
                }
        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['name'] =  $user->name;
        return response()->json(['user'=> $user , 'token'=>$success['token']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        //
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['token'=>$success['token'] , "user"=> $user]); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
        *Return (ALL) Countries
    */
    public function countries()
    {
        //
        return response()->json(['Countries'=> Country::all()]);
    }

    /**
        *Return (ALL) Cities of Current country ID
    */
    public function country($id)
    {
        //
        return response()->json(['Cities'=> Country::find($id)->cities]);
    }

    /**
        *Return (ALL) Areas of Current city ID
    */
    public function city($id)
    {
        //
        return response()->json(['Areas'=> City::find($id)->areas]);
    }

}
