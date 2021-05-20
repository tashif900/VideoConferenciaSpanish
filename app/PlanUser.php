<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanUser extends Model
{
    protected $table = "plan_user";

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function Plan(){
        return $this->belongsTo(Plan::class);
    }
}
