<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Device;

class userController extends Controller
{

    public function test(Request $re)
    {
    	// $dev = Device::find(1);
    	// echo $dev->uid;
    echo "1";
    }
    ////////////////////////////////////////////////////
    ///////////////////////////////////////////////////
    ///////////////////////////////////////////////////

        public function test1(Request $re)
    {
    	$dev = Device::find(1);
        $dev->uid = $re->btn;
        $dev->save();
        if ($re->btn == 1) {
        	$img = "images/pic_bulbon.gif";
        } elseif ($re->btn == 0){
        	$img = "images/pic_bulboff.gif";
        }
        
		return view('welcome')->with('img', $img);
    }

}
