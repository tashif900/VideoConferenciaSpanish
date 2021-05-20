<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseClass extends Model
{
    public $timestamps = false;

    public function course_class(){
        return $this->belongsTo('App\CourseClass');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function thematic(){
        return $this->belongsTo('App\Thematic');
    }

}
