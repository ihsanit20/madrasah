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
            'class_id'      => (int) ($this->class_id ?? 0),
            'subject_code'  => (int) ($this->subject_code ?? 0),
            'book_name'     => (string) ($this->book_name ?? ''),
            'speaking_mark' => (double) ($this->speaking_mark ?? 0),
            'writing_mark'  => (double) ($this->writing_mark ?? 0),
            'total_mark'    => (double) (($this->speaking_mark ?? 0) + ($this->writing_mark ?? 0)),
        ];
    }
}
