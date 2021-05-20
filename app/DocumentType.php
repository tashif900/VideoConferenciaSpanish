<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    public $timestamps = false;

    public function people(){
        return $this->hasMany('App\People');
    }


}
