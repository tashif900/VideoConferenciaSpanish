<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $appends = [
        'donde',
    ];

    public function meeting()
    {
        return $this->belongsTo('App\Meeting');
    }

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function clase()
    {
        return $this->belongsTo('App\Cclass');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getDondeAttribute()
    {
        if ($this->meeting_id != null) {
            return 'Sesión';
        } else if ($this->class_id != null) {
            return 'Clase';
        } else if ($this->course_id != null) {
            return 'Curso';
        }

        return '-';
    }
}
