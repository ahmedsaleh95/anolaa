<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Device;
use App\Schedule;
use Carbon\Carbon;

class ScheduleController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        # save timer in DB and set it to device
        $Schedule = Schedule::create(["alert"=> $request->time]);
        $user = Auth::user();
        // $device = $user->devices()->find($request->id);
        $device = $user->devices()->find($id);
        // $timer->devices()->attach($device->id);
        $Schedule->devices()->attach($id);
        #add 2 hours to time
        $dt= Carbon::parse($Schedule->alert, 'Europe/Paris')->addHour(1)->toDateTimeString();
        $dtWithoutMiutes = substr($dt , 0 , strlen($dt) - 3);
        # send it through FB to arduino 
        $fbdb = Device::firebaseRef();
        $newPost = $fbdb
        ->getReference()->update([$device->chipId.'/timer' => $dtWithoutMiutes]);
        return response()->json(["data"=> $dtWithoutMiutes]);
    }

}
