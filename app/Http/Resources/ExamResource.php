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
        $subject_name = "";

        if($this->class->subjects ?? false) {
            foreach($this->class->subjects as $index => $subject) {
                if($index + 1 == (int) substr($this->subject_code, 1)) {
                    $subject_name = $subject->name ?? '';
                }
            }
        }


        return [
            'id'            => (int) ($this->id ?? 0),
            'name'          => (string) ($this->name ?? ''),
            'session'       => (string) ($this->session ?? ''),
            'class_id'      => (int) ($this->class_id ?? 0),
            'class_name'    => (string) ($this->class->name ?? ''),
            'subject_code'  => (string) ($this->subject_code ?? ''),
            'subject_name'  => (string) ($subject_name ?? ''),
            'hour'          => (int) ($this->time_in_minute / 60),
            'minute'        => (int) ($this->time_in_minute % 60),
            'mark'          => (float) ($this->total_mark ?? 0),
            'language_type' => (int) ($this->language_type ?? 0),
            'top_text'      => (string) ($this->top_text ?? ''),
            'bottom_text'   => (string) ($this->bottom_text ?? ''),
        ];
    }
}
