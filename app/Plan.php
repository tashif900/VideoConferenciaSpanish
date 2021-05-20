<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    //
    protected $table = "plans";
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function  plans_user(){
        return $this->hasMany(PlanUser::class);
    }

}
