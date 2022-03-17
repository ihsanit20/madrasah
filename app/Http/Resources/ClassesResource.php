<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassesResource extends JsonResource
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
            'id'            => $this->id,
            'name'          => (string) ($this->name ?? ''),
            'code'          => (string) ($this->code ?? ''),
            'description'   => (string) ($this->description ?? ''),
            'totalSubject'  => (int) ($this->total_subject ?? 0),
            'totalFee'      => (int) ($this->total_fee ?? 0),
            'subjects'      => SubjectResource::collection($this->whenLoaded('subjects')),
            'fees'          => FeeResource::collection($this->whenLoaded('fees')),
        ];
    }
}
