<?php

use Illuminate\Database\Seeder;
use App\Country;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // Country::create(['country'=> 'Ethiopia']);
        $countries = [
        	['country'=> 'Egypt' , 
        	'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

        	['country'=> 'Nigeria' , 
        	'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

        	['country'=> 'Tanzania' , 
        	'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

        	['country'=> 'Kenya' , 
        	'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')],

        	['country'=> 'Sudan' , 
        	'created_at'=>date('Y-m-d H:i:s') , 'updated_at'=> date('Y-m-d H:i:s')]
        ];
        Country::insert($countries);
    }
}
