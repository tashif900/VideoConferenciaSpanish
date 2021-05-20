<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReport extends Model
{
    //
    public function u_reported_user(){
        return $this->belongsTo('App\User', 'reported_user');
    }
    public function u_user_report(){
        return $this->belongsTo('App\User', 'user_report');
    }
}
