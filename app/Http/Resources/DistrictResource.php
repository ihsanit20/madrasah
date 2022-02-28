<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DistrictResource extends JsonResource
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
            'name'          => (string) ($this->name ?? ''),
            'divisionId'    => (int) ($this->division_id ?? 0),
            'divisionName'  => (string) ($this->division->name ?? ''),
            'areas'         => AreaResource::collection($this->whenLoaded('areas')),
        ];
    }
}
