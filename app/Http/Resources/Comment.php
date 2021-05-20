<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Comment extends JsonResource
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
            'comment' => $this->comment,
            'created' => Carbon::parse($this->created_at)->diffForHumans(),
            'user' => $this->user->name,
            'photo' => $this->user->photo,
            'user_id' => $this->user_id,
            'where' => $this->donde
        ];
    }
}
