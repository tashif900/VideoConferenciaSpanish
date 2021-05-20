<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    public $timestamps = false;

    public function thematic(){
        return $this->belongsTo('App\Thematic');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function participants()
    {
        return $this->belongsToMany('App\User', 'meeting_user', 'meeting_id', 'user_id');
    }

    public function meeting_session(){
        return $this->hasMany(MeetingSession::class);
    }
}
