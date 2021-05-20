<?php

namespace App\Http\Resources;

use Jenssegers\Date\Date;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'icon' => $this->type == '1' ? 'fa-money-bill-wave' : '',
            'message' => $this->message,
            'time' => Date::createFromTimeStamp(strtotime($this->created_at))->diffForHumans()
        ];
    }
}
