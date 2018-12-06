<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use QrCode;
use Illuminate\Support\Facades\Storage;
use File;

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
        $devices = $user->devices;
        return response()->json(['devices'=>$devices]);       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $validator = Validator::make($request->all(), ['name' => 'required']);
        if ($validator->fails()) { 
            return response()->json(['notes'=>$validator->errors()], 500);            
        }
        $user = Auth::user();
        $device1 = uniqid(str_random(4));
        QrCode::size(400)->generate($device1 , '../public/qrcodes/'.$device1.'.svg');
        $data = ["name"=> $request->name , "chipId"=> $device1];
        if ($device = Device::create($data)) {
            # code...
            $user->devices()->save($device);
        } else {
            # code...
            return response()->json(['notes'=> "Device Not Added"] , 500);
        }
        return response()->json(['devices'=> $user->devices]);
    }


    /**
     * Check Code Sent From User and Set User for nodemcu.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkqrcode(Request $request)
    {
        //
        $validator = Validator::make($request->all(), ['qrcode' => 'required']);
        if ($validator->fails()) { 
            return response()->json(['notes'=>$validator->errors()], 500);            
            }
        $user = Auth::user();
        if ($device = Device::whereRaw('chipId = ?' , $request->qrcode)->first()) {
        $fbdb = Device::firebaseRef();
        try {
            $newStatus = $fbdb
            ->getReference($device->chipId.'/status')->set("");
            $newTimer = $fbdb
            ->getReference($device->chipId.'/timer')->set("");
            $newSchedulerStart = $fbdb
            ->getReference($device->chipId.'/scheduleStart')->set("");
            $newSchedulerEnd = $fbdb
            ->getReference($device->chipId.'/scheduleEnd')->set(""); 
        } catch (\Exception $e) {
            return response()->json(['notes'=> $e->getMessage()] , 400);
        }
        $user->devices()->save($device);
        return response()->json(['device'=> $user->devices]);
        } else {
            return response()->json(['notes'=> "Cannot find this device"] , 403);
        }
    }

    /**
     * Check Code Sent From User and Set User for nodemcu.
     *
     * @return \Illuminate\Http\Response
     */
    public function controldevice($id , Request $request)
    {
        //
        $validator = Validator::make($request->all(), ['status' => 'required']);
        if ($validator->fails()) { 
            return response()->json(['notes'=>$validator->errors()], 500);            
        }
        $user = Auth::user();
        if ($device = $user->devices()->find($id)) {
            # code...
            $fbdb = Device::firebaseRef();
            try {
            $newPost = $fbdb
            // ->getReference()->update([$device->chipId.'/status' =>  $request->status]);
            ->getReference($device->chipId.'/status')->set($request->status);

            $device->update($request->all());
            } catch (\Exception $e) {
                return response()->json(['notes'=> $e->getMessage()] , 400);
            }
            return response()->json(['Status'=> $user->devices()->find($id)]);
        } else {
            # code...
            return response()->json(['notes'=> "Device Not Found"] , 403);
        }
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
        if ($device = $user->devices()->find($id)) {
            # code...
            return response()->json(['device'=> $device]);
        } else {
            # code...
            return response()->json(['notes'=> "Have no access to this resource or not Found"] , 403);
        }
        
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
        $validator = Validator::make($request->all(), ['name' => 'required']);
        if ($validator->fails()) { 
            return response()->json(['notes'=>$validator->errors()], 500);            
        }
         $user = Auth::user();
         if ($device = $user->devices()->find($id)) {
            # code...
            $device->update($request->all());
            return response()->json(['device'=> $user->devices]);
        } else {
            # code...
            return response()->json(['error'=> "Invalid Device or Not Found"] , 403);
        }
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
        if ($device = $user->devices()->find($id)) {
            # code...
            File::delete('qrcodes/'.$device->chipId.'.svg');
            $device->delete();
            return response()->json(['device'=> $user->devices]);
        } else {
            # code...
            return response()->json(['notes'=> " Have no access to that device or Not Found"] , 403);
        }        
    }
}
