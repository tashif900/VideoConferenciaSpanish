<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstructorMovement extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function cclass()
    {
        return $this->belongsTo('App\Cclass', 'class_id');
    }

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function meeting()
    {
        return $this->belongsTo('App\Meeting');
    }
}
