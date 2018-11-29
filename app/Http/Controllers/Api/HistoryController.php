<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Device;
use App\Timer;
use App\Schedule;


class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        $user = Auth::user();
        if ($device = $user->devices()->find($id)) {
            # code...
            $timers = $device->timers()->orderBy('start_at', 'desc')->get();
            $schedules = $device->schedules()->orderBy('start_at', 'desc')->get();
            if ((count($timers) > 0 && count($schedules) > 0) ||(count($timers) > 0 || count($schedules) > 0)) {
                # code...
                foreach ($timers as $timer) {
                    # code...
                    $type['type'] = "timer";
                    $status['status'] = ($timer->completed == 1) ? "completed" : "upcoming" ;
                    $from['from'] =[
                        'date'=> substr($timer->start_at , 0 , strlen($timer->start_at) - 3),
                        'time'=> substr($timer->start_at , 11 , strlen($timer->start_at)),
                    ];
                    $timerData []= array_merge($type , $status , $from , $timer->toArray());
                }
                foreach ($schedules as $Schedule) {
                    # code...
                    $type['type'] = "Schedule";
                    $status['status'] = ($timer->completed == 1) ? "completed" : "upcoming" ;
                    $from['from'] =[
                        'date'=> substr($Schedule->start_at , 0 , strlen($Schedule->start_at) - 3),
                        'time'=> substr($Schedule->start_at , 11 , strlen($Schedule->start_at)),
                    ];
                    $to['to'] =[
                        'date'=> substr($Schedule->end_at , 0 , strlen($Schedule->end_at) - 3),
                        'time'=> substr($Schedule->end_at , 11 , strlen($Schedule->end_at)),
                    ];
                    $ScheduleData []= array_merge($type , $status , $from , $Schedule->toArray());
                }
                $data = array_merge($timerData , $ScheduleData);
                return response()->json(['data'=> $data]);
            } else {
                # code...
                return response()->json(['error'=> "No Timers or schedules Found"] , 401);
            }
        } else {
            # code...
            return response()->json(['error'=> "Not Found"] , 401);
        }
    }
}
