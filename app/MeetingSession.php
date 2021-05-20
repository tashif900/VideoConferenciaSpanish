<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MeetingSession extends Model
{
    public function meeting (){
        return $this->belongsTo(Meeting::class);
    }
}
