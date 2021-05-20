<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialNetwork extends Model
{
    public $timestamps = false;

    public function social_network_users(){
        return $this->hasMany('App\SocialNetworkUser');
    }
}
