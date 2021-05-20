<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
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
            'item' => $this->cclass != null ? 'Clase ' . $this->cclass->name : ($this->course != null ? 'Curso ' .  $this->course->name : ($this->meeting != null ? 'Sesión ' .  $this->meeting->name : '-')),
            'mount' => number_format($this->total, 2, '.',','),
            'participants' => $this->cclass != null ? $this->cclass->participantes->count() : ($this->course != null ? $this->course->participantes->count() : ($this->meeting != null ? $this->meeting->participants->count() : '-')),
        ];
    }
}
