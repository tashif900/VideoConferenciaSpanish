<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'img' => $this->image,
            'from' => date('d-m-Y', strtotime($this->from)),
            'to' => date('d-m-Y', strtotime($this->to)),
            'vigency' => $this->vigency,
            'status' => $this->status,
        ];
    }
}
