<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Path extends Model
{
    public $timestamps = false;


    public function Avertisements (){
        return $this->hasMany(Advertisement::class);
    }
}
