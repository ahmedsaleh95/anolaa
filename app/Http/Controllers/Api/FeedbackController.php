<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;


use App\User;
use App\Feedback;

class FeedbackController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $user = Auth::user();
        $validator = Validator::make($request->all(), ['message' => 'required']);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        return response()->json(['message'=> $user->messages()->save(Feedback::create($request->all()))], 200);
    }
}
