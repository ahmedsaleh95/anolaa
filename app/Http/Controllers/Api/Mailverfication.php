<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mailcode;
use Validator;


class Mailverfication extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [ 
            'email' => 'required|email|unique:Users', 
            'code' => 'required|unique:mailcodes', 
        ]);
        // here make select from DB for code by email 
       $data = Mailcode::where([
            ['email', '=' ,$request->email] , 
            ['code', '=' ,$request->code]
        ])->get();
        if(count($data) > 0)
        {
            return response()->json(['error'=> "verified");
        }
        else{
            return response()->json(['error'=> "Not verified" , 401);
        }
        #don not forgt to send mail in register endpoint
    }
}
