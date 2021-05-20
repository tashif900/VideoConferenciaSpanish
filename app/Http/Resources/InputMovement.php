<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InputMovement extends JsonResource
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
            'amount' => $this->amount,
            'description' => $this->description,
            'operation' => $this->number_operation,
            'date' => date('d-m-Y', strtotime($this->created_at))
        ];
    }
}
