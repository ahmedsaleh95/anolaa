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
            'code' => 'required', 
        ]);
        // here make select from DB for code by email 
       $data = Mailcode::where([
            ['email', '=' ,$request->email] , 
            ['code', '=' ,$request->code]
        ])->get();
       // return $data;
        if(count($data) > 0)
        {
            $data->first()->delete();
            return response()->json(['data'=> "verified"]);
        }
        else{
            return response()->json(['error'=> "Not verified"] , 401);
        }
    }


    public function send_mail(Request $request)
    {
        # code...
        $validator = Validator::make($request->all(), [ 
            'email' => 'required|email|unique:Users', 
        ]);
         try {
            // $random_hash = bin2hex(random_bytes(2));
            $random_hash = str_pad(rand(0, pow(10, 4)-1), 4, '0', STR_PAD_LEFT);
            $data = array('code'=>$random_hash);
            \Mail::send('ahln', $data, function($message) {
            $message->to(request('email') , "")->subject
                    ('Verfication Code');
            $message->from('info@anolaa.com','Anolaa');
              });
        } catch (\Exception $e) {
            // DB::rollBack();
            return response()->json(['error'=> $e->getMessage()] , 400);
        }
        if (!Mailcode::create([
            'email'=>request('email'),
            'code'=>$random_hash,
        ])) {
            # code...
            return response()->json(['error'=> "Code for verfication not saved"] , 401);
        }
        return response()->json(['data'=> "mail sent"]);

    }
}
