<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
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
            'book'      => (string) ($this->book ?? ''),
            'code'      => (string) ($this->code ?? ''),
            'classId'   => (int) ($this->class_id ?? 0),
            'className' => (string) ($this->class->name ?? ''),
        ];
    }
}
