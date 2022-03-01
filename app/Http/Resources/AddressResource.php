<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'        => (int) $this->id,
            'value'     => (string) ($this->value ?? ''),
            'areaId'    => (int) ($this->area_id ?? 0),
            'area'      => new AreaResource($this->whenLoaded('area')),
        ];
    }
}
