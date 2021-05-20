<?php

use Illuminate\Database\Seeder;
use App\PricesAdvertisements;

class PricesAdvertisementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        PricesAdvertisements::create([
            'description' => '7 dias',
            'time' => '7',
            'mount' => '20',
            'state' => 1
        ]);
        PricesAdvertisements::create([
            'description' => '15 dias',
            'time' => '15',
            'mount' => '30',
            'state' => 1
        ]);
        PricesAdvertisements::create([
            'description' => '1 mes',
            'time' => '30',
            'mount' => '80',
            'state' => 1
        ]);
    }
}
