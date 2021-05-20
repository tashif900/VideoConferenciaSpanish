<?php

use Illuminate\Database\Seeder;
use App\Page;

class informationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Page::create([
            'name' => 'Nosotros',
            'slug' => 'nosotros',
            'body' => '<p>nosotros</p>',
        ]);
        Page::create([
            'name' => 'Politica de Privacidad',
            'slug' => 'politicas',
            'body' => '<p>Politica de Privacidad</p>',
        ]);
        Page::create([
            'name' => 'Términos y Condiciones',
            'slug' => 'terminos',
            'body' => '<p>Términos y Condiciones</p>',
        ]);
        Page::create([
            'name' => 'Preguntas Frecuentes',
            'slug' => 'preguntas',
            'body' => '<p>Preguntas Frecuentes</p>',
        ]);

    }
}
