<?php

use App\Deal;
use Illuminate\Database\Seeder;

class DealsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Deal::create([
            'deal' => 'Dr.',
        ]);
        Deal::create([
            'deal' => 'Sr.',
        ]);
        Deal::create([
            'deal' => 'Sra.',
        ]);
        Deal::create([
            'deal' => 'Srta.',
        ]);
        Deal::create([
            'deal' => 'Lic.',
        ]);
        Deal::create([
            'deal' => 'Ing.',
        ]);
    }
}
