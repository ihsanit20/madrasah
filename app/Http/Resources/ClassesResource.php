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
            'id'        => $this->id,
            'name'      => (string) ($this->name ?? ''),
            'code'      => (string) ($this->code ?? ''),
            'subjects'  => SubjectResource::collection($this->subjects),
            'fees'      => FeeResource::collection($this->fees),
        ];
    }
}
