<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlataformPrice extends Model
{
    protected $table = 'platform_prices';

    public function thematic()
    {
        return $this->hasOne('App\Thematic');
    }
}
