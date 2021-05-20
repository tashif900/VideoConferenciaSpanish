<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PricesAdvertisements extends Model
{
    //
    protected $table = "prices_advertisements";

    public function Advertisements (){
        return $this->hasMany(Advertisement::class);
    }
}
