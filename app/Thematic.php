<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thematic extends Model
{
    public $timestamps = false;

    public function subtopics()
    {
        return $this->hasMany('App\SubTopic');
    }

    /*public function courses(){
        return $this->hasMany('App\Course', 'id');
    }

    public function course_classes(){
        return $this->hasMany('App\CourseClass');
    }*/

    public function courses()
    {
        return $this->hasManyThrough(
            'App\Course',
            'App\SubTopic',
            'thematic_id',
            'subtopic_id',
            'id',
            'id'
        );
    }
    public function cclass()
    {
        return $this->hasManyThrough(
            'App\Cclass',
            'App\SubTopic',
            'thematic_id',
            'subtopic_id',
            'id',
            'id'
        );
    }

    public function meetings(){
        return $this->hasMany('App\Meeting');
    }

    public function plataform_price()
    {
        return $this->hasOne('App\PlataformPrice');
    }

    public function teachers (){
        return $this->hasMany(User::class);
    }
}
