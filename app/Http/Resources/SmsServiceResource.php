<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SmsServiceResource extends JsonResource
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
            "id"            => (int) ($this->id ?? 0),
            "title"         => (string) ($this->title ?? ''),
            "body"          => (string) ($this->body ?? ''),
            "sender"        => (string) ($this->sender ?? ''),
            "receivers"     => (array) ($this->receivers ?? []),
            "status"        => (int) ($this->status ?? 0),
            "status_text"   => (string) ($this->status_text ?? ''),
            'created_by'    => (int) ($this->created_by ?? 0),
            'date'          => (string) ($this->date ?? '-'),
        ];
    }
}
