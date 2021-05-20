<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentAccountUser extends Model
{
    public $timestamps = false;

    public function document_account(){
        return $this->belongsTo('App\DocumentAccount');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

}
