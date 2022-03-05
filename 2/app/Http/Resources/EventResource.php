<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'date' => $this->date,
            'time' => $this->time,
            'location' => $this->location,
            'thumbnail' => $this->when($this->thumbnail, function() {
                if(filter_var($this->thumbnail, FILTER_VALIDATE_URL)) {
                    return $this->thumbnail;
                } else {
                    return asset($this->thumbnail);
                }
            }),
        ];
    }
}
