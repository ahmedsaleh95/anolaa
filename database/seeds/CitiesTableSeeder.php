<?php

use Illuminate\Database\Seeder;
use App\City;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $cities = [
        	['city'=> 'Cairo' , 'country_id'=> 1 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

            ['city'=> 'Alexandria' , 'country_id'=> 1 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

            ['city'=> 'Giza' , 'country_id'=> 1 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

            ['city'=> 'Qalyubia' , 'country_id'=> 1 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

            ['city'=> 'Suez' , 'country_id'=> 1 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

            ['city'=> 'Gharbia' , 'country_id'=> 1 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

            ['city'=> 'Fayoum' , 'country_id'=> 1 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

            ['city'=> 'Ismailia' , 'country_id'=> 1 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

            ['city'=> 'Damietta' , 'country_id'=> 1 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

            ['city'=> 'Luxor' , 'country_id'=> 1 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

            ['city'=> 'Sohag' , 'country_id'=> 1 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

            ['city'=> 'Hurghada' , 'country_id'=> 1 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

            ['city'=> 'Banha' , 'country_id'=> 1 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

            ['city'=> 'Kafr al-Sheikh' , 'country_id'=> 1 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

            ['city'=> 'Marsa Matruh' , 'country_id'=> 1 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

            ['city'=> 'Kafr el-Dawwar' , 'country_id'=> 1 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

            ['city'=> 'Mansoura' , 'country_id'=> 1 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

            ['city'=> 'Aswan' , 'country_id'=> 1 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

            ['city'=> 'Minya' , 'country_id'=> 1 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

            ['city'=> 'Beni Suef' , 'country_id'=> 1 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

            ['city'=> 'Qena' , 'country_id'=> 1 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

            ['city'=> 'Shibin El Kom' , 'country_id'=> 1 , 'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')]

        ];
        City::insert($cities);
    }
}
