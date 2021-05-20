<?php

namespace App\Http\Resources;

use App\Path;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $type = $this->type;
        $link = "#";
        if ($type == 1) $link =  '/perfil-publico/' . $this->user_id;
        if ($type == 2) $link = '/preview/course/' . $this->course_id;
        if ($type == 3) $link = '/preview/class/' . $this->class_id;
        if ($type ==5) {
            if ($this->path_id != null){
                $link = $this->path['name'];
            }
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image,
            'image_movil' => $this->image_movil,
            'link' => $link
            /*'link' => $this->type == 1 ? '/perfil-publico/' . $this->user_id
                : ($this->type == 2 ? '/preview/course/' . $this->course_id
                    : ($this->type == 3 ? '/preview/class/' . $this->class_id : '#' )
                )*/
        ];
    }
}
