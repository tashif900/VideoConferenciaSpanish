<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InputMovement extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function paymentGateway()
    {
        return $this->belongsTo('App\PaymentGateway');
    }
}
