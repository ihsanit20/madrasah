<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EducationalQualificationResource extends JsonResource
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
            "exam_name"         => (string) ($this->exam_name),
            "year"              => (string) ($this->year),
            "institute_name"    => (string) ($this->institute_name),
            "board"             => (string) ($this->board),
            "result"            => (string) ($this->result),
        ];
    }
}
