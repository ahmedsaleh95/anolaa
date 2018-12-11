<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\User;
use App\Device;
use App\Schedule;
use Carbon\Carbon;
use Validator;


class ScheduleController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id ,Request $request)
    {
        //
        $validator = Validator::make($request->all(), [ 
            'start_at' => 'required|date|date_format:Y-m-d H:i|before:end_at|after:today',
            'end_at' => 'required|date|date_format:Y-m-d H:i|after:start_at',
            'weekly' => 'required',
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 500);          
        }
        $input = $request->all();
        $input['weekly'] = ($input['weekly'] == "true") ? 1 : 0 ;
        # save timer in DB and set it to device
        DB::beginTransaction();
        if ($schedule = Schedule::create($input)) {
            # code...
            $user = Auth::user();
            if ($device = $user->devices()->find($id)) {
                # code...
                $schedule->devices()->attach($id);
                #add 2 hours to time
                $dt_start= Carbon::parse($schedule->start_at, 'Europe/Paris')
                ->addHour(1)
                ->toDateTimeString();
                $dt_start_WithoutMiutes = substr($dt_start , 0 , strlen($dt_start) - 3);
                $dt_end= Carbon::parse($schedule->end_at, 'Europe/Paris')
                ->addHour(1)
                ->toDateTimeString();
                $dt_end_WithoutMiutes = substr($dt_end , 0 , strlen($dt_end) - 3);
                # send it through FB to arduino 
                $fbdb = Device::firebaseRef();
                try {
                    $newPost1 = $fbdb
                    // ->getReference()->update([
                    //     $device->chipId.'/scheduleStart' => $dt_start_WithoutMiutes
                    // ]);
                    ->getReference($device->chipId.'/scheduleStart')->set($dt_start_WithoutMiutes);
                    $newPost2 = $fbdb
                    // ->getReference()->update([
                    //     $device->chipId.'/scheduleEnd' => $dt_end_WithoutMiutes
                    // ]);
                    ->getReference($device->chipId.'/scheduleEnd')->set($dt_end_WithoutMiutes);
                } catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json(['error'=> $e->getMessage()] , 400);
                }
                DB::commit();
                return response()->json(["data"=> $device->schedules]);
            } else {
                # code...
                DB::rollBack();
                return response()->json(['error'=> "Device Not Found"] , 403);
            }
        } else {
            # code...
            return response()->json(['error'=> "schedule not set"], 403);           
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
            if ($schedule = $device->schedules()->find($id)) {
                # code...
                $schedule->devices()->detach();
                $schedule->delete();
                return response()->json(['data'=> $device->schedules]);
            } else {
                # code...
                return response()->json(['error'=> " schedule not found "] , 403);
            }
        } else {
            # code...
            return response()->json(['error'=> " Device Not Found"] , 403);
        }      
    }

}
