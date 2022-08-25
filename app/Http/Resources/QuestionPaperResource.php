<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionPaperResource extends JsonResource
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
            'exam'          => new ExamResource($this->whenLoaded('exam')),
            'class_id'      => (int) ($this->class_id ?? 0),
            'class'         => new ClassesResource($this->whenLoaded('class')),
            'subject_code'  => (int) ($this->subject_code ?? 0),
            'hour'          => (int) ($this->time_in_minute / 60 ?? 0),
            'minute'        => (int) ($this->time_in_minute % 60 ?? 0),
            'language_type' => (int) ($this->language_type ?? 1),
            'mark'          => (float) ($this->mark ?? 0),
            'book_name'     => (string) ($this->book_name ?? ''),
            'top_text'      => (string) ($this->top_text ?? ''),
            'bottom_text'   => (string) ($this->bottom_text ?? ''),
            'questions'     => QuestionResouce::collection($this->whenLoaded('questions')),
        ];
    }
}
