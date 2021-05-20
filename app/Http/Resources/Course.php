<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Course extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type_course == 1 ? 'Grabado' : 'Online',
            'type_course' => $this->type_course,
            'number_class' => $this->number_class,
            'start_date' => $this->date_start,
            'start' => date('d-m-Y', strtotime($this->date_start)),
            'participants' => $this->participantes->count(),
            'canCreateClass' => $this->classes->count() < $this->number_class ? true : false,
            'subTopic' => $this->subtopic_id,
            'photo' => $this->photo,
            'price' => $this->price,
            'averageRating' => $this->averageRating,
            'instructor' => $this->user->name,
            'instructor_course' => $this->user,
            'classes' => $this->classes
        ];
    }
}
