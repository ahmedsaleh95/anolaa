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
            'start_at' => 'required|date|date_format:Y-m-d H:i|after:'.Carbon::now()
            ->addHours(2),
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 500);          
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
                    // ->getReference()->update([$device->chipId.'/timer' => $dtWithoutMiutes]);
                    ->getReference($device->chipId.'/timer')->set($dtWithoutMiutes);

                } catch (\Exception $e) {
                    return response()->json(['error'=> $e->getMessage()] , 400);
                }
                return response()->json(["data"=> $device->timers]);
            } else {
                # code...
                return response()->json(['error'=> " device Not Found"] , 403);
            }
        } else {
            # code...
            return response()->json(['error'=> "Timer not set"], 403);           
        }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id ,Request $request)
    {
        //
        $user = Auth::user();
        $validator = Validator::make($request->all(), [ 
            'device_id' => 'required',
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 500);          
        }
        if ($device = $user->devices()->first()->find($request->device_id)) {
            # code...
            if ($timer = $device->timers()->find($id)) {
                # code...
                $timer->devices()->detach();
                $timer->delete();
                return response()->json(['data'=> $device->timers]);
            } else {
                # code...
                return response()->json(['error'=> " Timer not found "] , 403);
            }
        } else {
            # code...
            return response()->json(['error'=> " Device Not Found"] , 403);
        }      
    }
}
