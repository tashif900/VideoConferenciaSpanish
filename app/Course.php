<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public $timestamps = false;

    protected $appends = [
        'averageRating'
    ];

    public function thematic(){
        return $this->belongsTo('App\Thematic');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function course_classes(){
        return $this->hasMany('App\CourseClass');
    }

    public function participants()
    {
        return $this->belongsTo('App\User');
    }

    public function participantes()
    {
        return $this->belongsToMany('App\User', 'course_user', 'course_id', 'user_id');
    }

    public function classes()
    {
        return $this->hasMany('App\Cclass');
    }

    public function subtopic(){
        return $this->belongsTo('App\SubTopic');
    }

    public function rating()
    {
        return $this->hasMany('App\UserRating');
    }

    function getAverageRatingAttribute(){
        return round($this->rating()->avg('rating'),1);
    }

    public function advertimesents(){
        return $this->hasMany(Advertisement::class);
    }
}
