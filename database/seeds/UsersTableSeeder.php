<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // User::create(['name' => 'asz' , 'email'=> 'asz@gmail.com', 'password'=> bcrypt('asz') , 'date_of_birth'=> date("Y-m-d"), 'country_id'=> 1, 'city_id'=> 2, 'area_id'=> 3, 'phone'=> '01113094733']);
    }
}
