<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    public $timestamps = false;

    public function interest_users(){
        return $this->belongsToMany('App\User');
    }
}
