<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurposeResource extends JsonResource
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
            "id"            => (int) ($this->id),
            "title"         => (string) ($this->title ?? ''),
            "purpose_fees"  => PurposeFeeResource::collection($this->whenLoaded('purpose_fees')),
        ];
    }
}
