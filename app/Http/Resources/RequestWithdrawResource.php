<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestWithdrawResource extends JsonResource
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
            'date' => date('d-m-Y', strtotime($this->request_date)),
            'amount' => number_format($this->amount, 2, '.', ','),
            'period' => $this->output[0]->period,
            'state' => $this->state == 1 ? 'Pendiente' : ($this->state == 2 ? 'Completado' : ($this->state == 3 ? 'Declinado' : '-'))
        ];
    }
}
