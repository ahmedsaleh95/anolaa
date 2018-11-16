<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Device;
use App\Timer;
use Carbon\Carbon;


class TimerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        # save timer in DB and set it to device
        $timer = Timer::create(["alert"=> $request->time]);
        $user = Auth::user();
        $device = $user->devices()->find($request->id);
        $timer->devices()->attach($device->id);
        #add 2 hours to time
        $dt= Carbon::parse($timer->alert, 'Europe/Paris')->addHour(2)->toDateTimeString();
        $dtWithoutMiutes = substr($dt , 0 , strlen($dt) - 3);
        # send it through FB to arduino 
        $fbdb = Device::firebaseRef();
        $newPost = $fbdb
        ->getReference()->update([$device->chipId.'/timer' => $dtWithoutMiutes]);
        return response()->json(["data"=> $dtWithoutMiutes]);
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
}
