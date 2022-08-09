<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SimpleStudentResource extends JsonResource
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
            'id'                    => (int) $this->id,
            'name'                  => (string) ($this->name ?? ''),
            'registration'          => (string) ($this->registration ?? ''),
            'currentAdmissionId'    => (int) ($this->current_admission->id ?? 0),
            'currentClassName'      => (string) ($this->current_admission->class->name ?? ''),
            'currentClassRoll'      => (int) ($this->current_admission->roll ?? ''),
        ];
    }
}
