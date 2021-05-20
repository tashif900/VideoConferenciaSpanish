<?php

use App\People;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Elias Rodriguez',
            'email' => 'eliasrj16@gmail.com',
            'password' => Hash::make('123456789'),
            'state' => 1
        ]);

        $people = People::create([
           'description' => 'Una persona genial',
            'user_id' => $user->id
        ]);

        $user->assignRole('Administrador');
    }
}
