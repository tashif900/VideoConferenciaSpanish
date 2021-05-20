<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialNetworkUser extends Model
{
    public $timestamps = false;

    public function social_network(){
        return $this->belongsTo('App\SocialNetwork');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
