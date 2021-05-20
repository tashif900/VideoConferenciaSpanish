<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubTopic extends Model
{
    protected $table = 'subtopics';

    public function thematic()
    {
        return $this->belongsTo('App\Thematic');
    }
    public function courses (){
        return $this->hasMany(Course::class, 'subtopic_id');
    }

    public function cclass(){
        return $this->hasMany(Cclass::class, 'subtopic_id');
    }
}
