<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Device;

use Carbon\Carbon;


class ArduinoController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function timerTurn(Request $request)
    {
    	if ($device = Device::whereRaw('chipId = ?' , $request->qrcode)->first()) {
    		$timers = $device->timers()->where('completed' , '=' , 0)->orderBy('start_at', 'asc')->take(2)->get();
    		// dd($timers);
    		if (count($timers) > 1) {
    			# code... set timer to empty string in firebase and update 
    			$timers->first()->update(['completed' => 1]);
    			$dt= Carbon::parse($timers->last()->start_at, 'Europe/Paris')
                ->addHour(1)
                ->toDateTimeString();
                $dtWithoutMiutes = substr($dt , 0 , strlen($dt) - 3);
                # send it through FB to arduino 
                $fbdb = Device::firebaseRef();
                try {
                    $newPost = $fbdb
                    ->getReference($device->chipId.'/timer')->set($dtWithoutMiutes);

                } catch (\Exception $e) {
                    return response()->json(['error'=> $e->getMessage()] , 400);
                }
    		} else {
    			# code...
    			$timers->first()->update(['completed' => 1]);
    		}
        return response()->json(["ststus"=> "Timer ".$timers->first()->start_at." Successfully"]);
        } else {
            return response()->json(['error'=> "Cannot find this device"] , 500);
        }
    }
}
