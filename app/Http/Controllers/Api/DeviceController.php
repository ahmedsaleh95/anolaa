<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Device;
// use Eloquent;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = Auth::user();
        return response()->json(['devices'=>$user->devices], 200);  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
         // Eloquent::unguard();
        $user = Auth::user();
        return response()->json(['device added'=> $user->devices()->save(Device::create($request->all()))], 200);
    }


    /**
     * Check Code Sent From User and Set User for nodemcu.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkqrcode(Request $request)
    {
        //
        $user = Auth::user();
        $device = Device::whereRaw('chipid = ?' , $request->qrcode)->get();
        $fbdb = Device::firebaseRef();
        $newStatus = $fbdb
        ->getReference($device[0]->chipId.'/status')->set("");
        $newTimer = $fbdb
        ->getReference($device[0]->chipId.'/timer')->set("");
        $user->devices()->save($device[0]);
        return response()->json(['device'=> "yes"]);
    }

    /**
     * Check Code Sent From User and Set User for nodemcu.
     *
     * @return \Illuminate\Http\Response
     */
    public function controldevice($id , Request $request)
    {
        //
        $device = Device::find($id);
        $fbdb = Device::firebaseRef();
        $newPost = $fbdb
        ->getReference()->update(['LEDStatus' =>  (int)$value]);
        return response()->json(['Status'=> $value]);
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
        $user = Auth::user();
        return response()->json(['device'=> $user->devices()->find($id)], 200);
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
         $user = Auth::user();
         $device = $user->devices()->find($id);
        return response()->json(['device updated'=> $device->update($request->all())], 200);
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
        $user = Auth::user();
        return response()->json(['device deleted'=> $user->devices()->find($id)->delete()], 200);
    }



    public function twoLedTest()
    {
        $dev = Device::find(1);
        echo $dev->status;
    }

    public function set2ledValues(Request $request)
    {
        $dev = Device::find(1);
        $dev->status = $request->value;
        $dev->save();
        return response()->json(['done']);
    }
}
