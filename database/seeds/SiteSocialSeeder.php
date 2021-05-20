<?php

use App\SiteSocialNetwork;
use Illuminate\Database\Seeder;

class SiteSocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SiteSocialNetwork::create([
            'name' => 'instagram',
            'link' => 'https://www.instagram.com/',
            'state' => 1
        ]);
        SiteSocialNetwork::create([
            'name' => 'facebook',
            'link' => 'https://www.facebook.com/',
            'state' => 1
        ]);
        SiteSocialNetwork::create([
            'name' => 'twitter',
            'link' => 'https://www.twitter.com/',
            'state' => 1
        ]);
        SiteSocialNetwork::create([
            'name' => 'youtube',
            'link' => 'https://www.youtube.com/',
            'state' => 1
        ]);
    }
}
