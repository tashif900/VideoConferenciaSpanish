<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethodUser extends Model
{
    public $timestamps = false;

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function payment_method(){
        return $this->belongsTo('App\PaymentMethod');
    }

}
