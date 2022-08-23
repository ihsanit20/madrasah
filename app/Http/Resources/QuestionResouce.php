<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResouce extends JsonResource
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
            'title'         => (string) ($this->title ?? ''),
            'body'          => (string) ($this->body ?? ''),
            'mark'          => (float) ($this->mark ?? 0),
        ];
    }
}
