<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentAccount extends Model
{
    public $timestamps = false;

    public function document_account_users(){
        return $this->hasMany('App\DocumentAccountUser');
    }
}
