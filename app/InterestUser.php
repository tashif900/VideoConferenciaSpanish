<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InterestUser extends Model
{
    public $timestamps = false;

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function interest(){
        return $this->belongsTo('App\Interest');
    }
}
