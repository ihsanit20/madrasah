<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResultResource extends JsonResource
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
            'exam_id'       => (int) ($this->exam_id ?? 0),
            'exam'          => (object) ($this->whenLoaded('exam') ?? []),
            'class_id'      => (int) ($this->class_id ?? 0),
            'class'         => (object) ($this->whenLoaded('class') ?? []),
            'subject_code'  => (int) ($this->subject_code ?? 0),
            'subject'       => (object) ($this->subject ? $this->subject : []),
            'marks'         => (array) ($this->marks ?? []),
        ];
    }
}
