<?php

use App\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/countries.json");
        $data = json_decode($json);


        foreach ($data as $obj){
            $country = new Country();
            $country->name = $obj->name_es;
            $country->name_en= $obj->name_en;
            $country->dial_code= $obj->dial_code;
            $country->code = $obj->code;
            $country->state=1;
            $country->save();
        }
    }
}
