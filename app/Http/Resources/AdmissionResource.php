<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdmissionResource extends JsonResource
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
            'roll'          => (int) ($this->roll ?? 0),
            'studentName'   => (string) ($this->student->name ?? ''),
            'className'     => (string) ($this->class->name ?? ''),
            'year'          => (int) ($this->year ?? 0),
        ];
    }
}
