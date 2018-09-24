<?php

use Illuminate\Database\Seeder;
use App\Area;


class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $areas = [
        	['area'=> 'El Mandara' , 'city_id'=> 2 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

        	['area'=> 'El Mansheya' , 'city_id'=> 2 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

        	['area'=> 'El Max,' , 'city_id'=> 2 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

        	['area'=> 'El Qabary' , 'city_id'=> 2 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

        	['area'=> 'El Saraya' , 'city_id'=> 2 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

        	['area'=> 'El Soyof' , 'city_id'=> 2 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

        	['area'=> 'Fleming' , 'city_id'=> 2 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

        	['area'=> 'Gianaclis' , 'city_id'=> 2 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

        	['area'=> 'Glim' , 'city_id'=> 2 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

        	['area'=> 'Hadara' , 'city_id'=> 2 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

        	['area'=> 'Kafr Abdu' , 'city_id'=> 2 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

        	['area'=> 'Karmoz' , 'city_id'=> 2 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

        	['area'=> 'Kom El Deka' , 'city_id'=> 2 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

        	['area'=> 'Louran' , 'city_id'=> 2 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

        	['area'=> 'Mahatet El Raml' , 'city_id'=> 2 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

        	['area'=> 'Miami' , 'city_id'=> 2 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

        	['area'=> 'Moharam Bek' , 'city_id'=> 2 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

        	['area'=> 'Montaza' , 'city_id'=> 2 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

        	['area'=> 'Roshdy' , 'city_id'=> 2 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')]

        ];
        Area::insert($areas);
    }
}
