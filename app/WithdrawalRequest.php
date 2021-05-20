<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function output()
    {
        return $this->hasMany('App\OutputMovement');
    }
}
