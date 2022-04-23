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
            'id'            => (int) $this->id,
            'value'         => (string) ($this->value ?? ''),
            'postoffice'    => (string) ($this->postoffice ?? ''),
            'areaId'        => (int) ($this->area_id ?? 0),
            'areaName'      => (string) ($this->area->name ?? ''),
            'districtName'  => (string) ($this->area->district->name ?? ''),
            'divisionName'  => (string) ($this->area->district->division->name ?? ''),
            'area'          => new AreaResource($this->whenLoaded('area')),
        ];
    }
}
