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
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create($id ,Request $request)
    {
        //
        # save timer in DB and set it to device
        $timer = Timer::create(["alert"=> $request->time]);
        $user = Auth::user();
        // $device = $user->devices()->find($request->id);
        $device = $user->devices()->find($id);
        // $timer->devices()->attach($device->id);
        $timer->devices()->attach($id);
        #add 2 hours to time
        $dt= Carbon::parse($timer->alert, 'Europe/Paris')->addHour(1)->toDateTimeString();
        $dtWithoutMiutes = substr($dt , 0 , strlen($dt) - 3);
        # send it through FB to arduino 
        $fbdb = Device::firebaseRef();
        $newPost = $fbdb
        ->getReference()->update([$device->chipId.'/timer' => $dtWithoutMiutes]);
        return response()->json(["data"=> $dtWithoutMiutes]);
    }



    /**
     * View timer and schedule history.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function veiwall($id)
    {
        //
        $device = Device::find($id);
        $timers = $device->timers()->orderBy('alert', 'desc')->get();
        $t = [];
        $s = [];
        foreach ($timers as $time) {
            $t [] = ['type'=>'timer',
            'status'=>'upcoming',
            'from'=>[
                'date'=>substr($time->alert , 0 ,-9),
                'time'=>'10:00 AM'
            ],
            'to'=>[
                'date'=>substr($time->alert , 0 ,-9),
                'time'=>'11:00 AM'
                ]
            ];
            //
            $s [] = ['type'=>'schedule',
            'status'=>'completed',
            'from'=>[
                'date'=>substr($time->alert , 0 ,-9),
                'time'=>'10:00 AM'
            ],
            'to'=>[
                'date'=>substr($time->alert , 0 ,-9),
                'time'=>'11:00 AM'
                ]
            ];
        }
        $m = array_merge($t , $s);

        return response()->json(["data"=> $m]);
    }
}
