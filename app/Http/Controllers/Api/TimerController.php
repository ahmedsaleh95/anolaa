<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Device;
use App\Timer;
use Carbon\Carbon;
use Validator;



class TimerController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create($id ,Request $request)
    {
        //
        $validator = Validator::make($request->all(), [ 
            'start_at' => 'required|date|date_format:Y-m-d H:i:s',
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);          
        }
        # save timer in DB and set it to device
        if ($timer = Timer::create($request->all())) {
            # code...
            $user = Auth::user();
            if ($device = $user->devices()->find($id)) {
                # code...
                $timer->devices()->attach($id);
                #add 2 hours to time
                $dt= Carbon::parse($timer->start_at, 'Europe/Paris')
                ->addHour(1)
                ->toDateTimeString();
                $dtWithoutMiutes = substr($dt , 0 , strlen($dt) - 3);
                # send it through FB to arduino 
                $fbdb = Device::firebaseRef();
                try {
                    $newPost = $fbdb
                    ->getReference()->update([$device->chipId.'/timer' => $dtWithoutMiutes]);
                } catch (\Exception $e) {
                    return response()->json(['error'=> $e->getMessage()] , 401);
                }
                return response()->json(["data"=> $device->timers]);
            } else {
                # code...
                return response()->json(['error'=> "Not Found"] , 401);
            }
        } else {
            # code...
            return response()->json(['error'=> "Timer not set"], 401);           
        }        
    }
}
