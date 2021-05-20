<?php

namespace App\Http\Resources;

use Jenssegers\Date\Date;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'message' => $this->message,
            'user' => $this->user_id,
            'hour' => Date::createFromFormat('Y-m-d H:i:s', $this->created_at)->diffForHumans(),
            'photo' => $this->user->photo,
            'name' => $this->user->name,
        ];
    }
}
