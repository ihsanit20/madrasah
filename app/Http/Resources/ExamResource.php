<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
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
            'id'            => (int) ($this->id ?? 0),
            'name'          => (string) ($this->name ?? ''),
            'arabic'        => (string) ($this->arabic ?? ''),
            'english'       => (string) ($this->english ?? ''),
            'session'       => (string) ($this->session ?? ''),
            'classes'       => ClassesResource::collection($this->whenLoaded('classes')),
        ];
    }
}
