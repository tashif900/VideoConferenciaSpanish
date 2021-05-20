<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function PricesAdvertisements (){
        return $this->belongsTo(PricesAdvertisements::class, 'prices_advertisement_id');
    }

    public function Path (){
        return $this->belongsTo(Path::class);
    }

    public function  cclass (){
        return $this->belongsTo(Cclass::class, 'class_id');
    }

    public function course (){
        return $this->belongsTo(Course::class, 'course_id');
    }
}
