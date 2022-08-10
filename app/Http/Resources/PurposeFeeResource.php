<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurposeFeeResource extends JsonResource
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
            "class_id"      => (int) ($this->class_id ?? ''),
            "class_name"    => (string) ($this->class->name ?? ''),
            "purpose_id"    => (int) ($this->purpose_id ?? ''),
            "amount"        => (double) ($this->amount ?? ''),
        ];
    }
}
