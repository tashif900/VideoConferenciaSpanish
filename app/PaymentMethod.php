<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    public $timestamps = false;

    public function payment_method_users(){
        return $this->hasMany('App\PaymentMethodUser');
    }

}
