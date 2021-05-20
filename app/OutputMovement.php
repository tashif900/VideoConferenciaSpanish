<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OutputMovement extends Model
{
    public function withdrawalRequest()
    {
        return $this->belongsTo('App\WithdrawalRequest');
    }
}
