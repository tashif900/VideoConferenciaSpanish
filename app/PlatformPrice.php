<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlatformPrice extends Model
{
    public function thematic()
    {
        return $this->belongsTo('App\Thematic');
    }
}
