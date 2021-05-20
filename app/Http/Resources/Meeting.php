<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Meeting extends JsonResource
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
            'hour' => date('H:m', strtotime($this->hour_start)),
            'date' => date('d-m-Y', strtotime($this->hour_start)),
            'datej' => date('j-n-Y', strtotime($this->hour_start)),
            'room' => $this->room_id,
            'anfitrion' => $this->user_id == auth()->user()->id ? 'Anfitrion' : 'Invitado',
            'code' => $this->code,
            'type' => $this->type_meeting == 1 ? 'Individual' : 'Múltiple'
        ];
    }
}
