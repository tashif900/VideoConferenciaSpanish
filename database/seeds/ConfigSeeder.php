<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        DB::table('countries')->insert([
            'name'  => 'Perú',
            'state' => 1,
        ]);

        DB::table('countries')->insert([
            'name'  => 'Colombia',
            'state' => 1,
        ]);

        DB::table('countries')->insert([
            'name'  => 'Ecuador',
            'state' => 1,
        ]);

        DB::table('countries')->insert([
            'name'  => 'Brazil',
            'state' => 1,
        ]);

        DB::table('countries')->insert([
            'name'  => 'Chile',
            'state' => 1,
        ]);

        DB::table('countries')->insert([
            'name'  => 'Argentina',
            'state' => 1,
        ]);*/

        DB::table('document_types')->insert([
            'description'  => 'DNI',
            'state' => 1,
        ]);

        DB::table('document_types')->insert([
            'description'  => 'Pasaporte',
            'state' => 1,
        ]);

        DB::table('document_types')->insert([
            'description'  => 'Carnet De Extranjeria',
            'state' => 1,
        ]);

        DB::table('document_types')->insert([
            'description'  => 'Otro',
            'state' => 1,
        ]);

        Role::create([
            'name' => 'Administrador'
        ]);

        Role::create([
            'name' => 'Profesor'
        ]);

        Role::create([
            'name' => 'Alumno'
        ]);

        /*DB::table('interests')->insert([
            'name'  => 'Musica',
            'state' => 1,
        ]);

        DB::table('interests')->insert([
            'name'  => 'Literatura',
            'state' => 1,
        ]);

        DB::table('interests')->insert([
            'name'  => 'Quimica',
            'state' => 1,
        ]);

        DB::table('interests')->insert([
            'name'  => 'Fisica',
            'state' => 1,
        ]);

        DB::table('interests')->insert([
            'name'  => 'Astronomía',
            'state' => 1,
        ]);*/

        DB::table('payment_methods')->insert([
            'name'  => 'Paypal',
            'type' => 1,
            'image' => '/img/paypal.png',
            'state' => 1,
        ]);
        DB::table('payment_methods')->insert([
            'name'  => 'Tarjeta de Credito',
            'type' => 2,
            'image' => '/img/card.png',
            'state' => 1,
        ]);

        DB::table('payment_methods')->insert([
            'name'  => 'CLABE',
            'state' => 1,
        ]);

        DB::table('document_accounts')->insert([
            'name'  => 'Cedula Frontal',
            'state' => 1,
        ]);

        DB::table('document_accounts')->insert([
            'name'  => 'Cedula Posterior',
            'state' => 1,
        ]);

        DB::table('document_accounts')->insert([
            'name'  => 'Diploma Frontal',
            'state' => 1,
        ]);

        DB::table('document_accounts')->insert([
            'name'  => 'Diploma Posterior',
            'state' => 1,
        ]);

        DB::table('institution_types')->insert([
            'description'  => 'Universidad',
            'state' => 1,
        ]);

        DB::table('institution_types')->insert([
            'description'  => 'Instituto',
            'state' => 1,
        ]);
    }
}
