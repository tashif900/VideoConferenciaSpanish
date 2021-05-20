<?php

use App\Path;
use Illuminate\Database\Seeder;

class PathSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Path::create([
            'name' => '#',
            'description' => 'Predeterminada',
            'state' => 1
        ]);

        Path::create([
            'name' => '/search?thematic=1',
            'description' => 'Medicina',
            'state' => 1
        ]);
        Path::create([
            'name' => '/search?thematic=2',
            'description' => 'Educación',
            'state' => 1
        ]);
        Path::create([
            'name' => '/search?thematic=3',
            'description' => 'Derecho',
            'state' => 1
        ]);
        Path::create([
            'name' => '/search?thematic=4',
            'description' => 'Fitnes',
            'state' => 1
        ]);
        Path::create([
            'name' => '/register-teacher',
            'description' => 'Registro Profesionales',
            'state' => 1
        ]);

        Path::create([
            'name' => '/register-v',
            'description' => 'Registro Alumnos',
            'state' => 1
        ]);

        Path::create([
            'name' => '/nosotros',
            'description' => 'Nosotros',
            'state' => 1
        ]);

        Path::create([
            'name' => '/politica-privacidad',
            'description' => 'Políticas',
            'state' => 1
        ]);

        Path::create([
            'name' => '/terminos-condiciones',
            'description' => 'Términos y condiciones',
            'state' => 1
        ]);

        Path::create([
            'name' => '/preguntas-frecuentes',
            'description' => 'Preguntas frecuentes',
            'state' => 1
        ]);
    }
}
