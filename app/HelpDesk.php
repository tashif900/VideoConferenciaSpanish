<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HelpDesk extends Model
{
    public function parent (){
        return $this->belongsTo(HelpDesk::class);
    }
    public function helpdesks(){
        return $this->hasMany(HelpDesk::class, 'parent_id');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
}
