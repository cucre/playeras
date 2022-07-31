<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate([
        	'email' => 'admin@playeras'
        ],[
        	'name'       => 'Administrador',
        	'password'   => '12345',
        ]);
    }
}
