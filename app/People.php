<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    public $timestamps = false;

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function country(){
        return $this->belongsTo('App\Country');
    }

    public function document_type(){
        return $this->belongsTo('App\DocumentType');
    }

    public function u_create(){
        return $this->belongsTo('App\User');
    }

    public function u_update(){
        return $this->belongsTo('App\User');
    }

    public function deal()
    {
        return $this->belongsTo('App\Deal');
    }
}
