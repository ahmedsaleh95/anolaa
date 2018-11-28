<?php

use Illuminate\Database\Seeder;
use App\Device;
use Webpatser\Uuid\Uuid;

class DeviceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // $str = str_random(10);
        // $devices = [
        // 	['name'=> 'Device1' , 'description'=> 'office' , 'chipId'=> bcrypt($str) ,
        // 	'qrcode'=> $str.'.png' , 'user_id'=> 0 , 
        // 	'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')]
        // 	        ];

        // Device::insert($devices);

     //    $device1 = str_random(10);
	    // QrCode::size(600)->generate($device1 , 'Device1.png');   
     //    Device::create([
     //    	'name'=> 'Device1' , 'description'=> 'office' , 'chipId'=> $device1 , 'qrcode'=> 'Device1' , 'user_id'=> 0 
     //    ]);


        for ($i=1; $i < 4; $i++) {
            // $device1 = str_random(10);
            // $device1 = Uuid::generate()->string;
            $device1 = uniqid(str_random(4));
            QrCode::size(400)->generate($device1 , 'public/qrcodes/Device'.$i.'.svg');   
            Device::create(['name'=> 'Device'.$i , 'chipId'=> $device1]);
        }

    }
}
