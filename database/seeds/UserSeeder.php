<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
           'name' => 'Martín Abad',
           'email' => 'abad@gmail.com',
           'password' => bcrypt('12345678'),
        ])->assignRole('Admin');

        User::create([
            'name' => 'Pablo vega',
            'email' => 'vega@gmail.com',
            'password' => bcrypt('12345678'),
        ])->assignRole('Nutricion');
        
        User::create([
            'name' => 'Lautaro Martinez',
            'email' => 'zalazar@gmail.com',
            'password' => bcrypt('12345678'),
        ])->assignRole('Relevamiento');;
    }
}
