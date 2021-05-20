<?php

use App\Advertisement;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AdvertisementsSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Advertisement::create([
            'vigency' => 1,
            'price' => 0,
            'from' => Carbon::now(),
            'to' => Carbon::now()->addYear(1),
            'title' => 'Disfruta de nuestras clases online',
            'description' => 'y nuestras promociones',
            'type' => 5,
            'user_id' => 1,
            'image' => '/img/001.jpg',
            'status' => 1,
        ]);

        Advertisement::create([
            'vigency' => 1,
            'price' => 0,
            'from' => Carbon::now(),
            'to' => Carbon::now()->addYear(1),
            'title' => 'Disfruta de nuestras clases online',
            'description' => 'y nuestras promociones',
            'type' => 5,
            'user_id' => 1,
            'image' => '/img/002.jpg',
            'status' => 1,
        ]);
        Advertisement::create([
            'vigency' => 1,
            'price' => 0,
            'from' => Carbon::now(),
            'to' => Carbon::now()->addYear(1),
            'title' => 'Disfruta de nuestras clases online',
            'description' => 'y nuestras promociones',
            'type' => 5,
            'user_id' => 1,
            'image' => '/img/003.jpg',
            'status' => 1,
        ]);

        Advertisement::create([
            'vigency' => 1,
            'price' => 0,
            'from' => Carbon::now(),
            'to' => Carbon::now()->addYear(1),
            'title' => 'Disfruta de nuestras clases online',
            'description' => 'y nuestras promociones',
            'type' => 5,
            'user_id' => 1,
            'image' => '/img/004.jpg',
            'status' => 1,
        ]);
    }
}
