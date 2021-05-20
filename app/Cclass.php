<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cclass extends Model
{
    public $timestamps = false;
    protected $table = 'classes';

    protected $appends = [
        'averageRating'
    ];

    public function subtopic()
    {
        return $this->belongsTo('App\SubTopic');
    }

    public function instructor()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function participants()
    {
        return $this->belongsTo('App\User');
    }

    public function participantes()
    {
        return $this->belongsToMany('App\User', 'class_user', 'class_id', 'user_id');
    }
    public function participantesCount()
    {
        return $this->belongsToMany('App\User', 'class_user', 'class_id', 'user_id')->selectRaw('count(class_user.class_id) as aggregate')->groupBy('class_user.class_id');
    }

    public function rating()
    {
        return $this->hasMany('App\UserRating', 'class_id');
    }

    function getAverageRatingAttribute(){
        return round($this->rating()->avg('rating'),1);
    }

    public function resources()
    {
        return $this->hasMany('App\Resource', 'class_id');
    }

    public function advertisements(){
        return $this->hasMany(Advertisement::class);
    }
}
