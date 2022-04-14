<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NoticeResource extends JsonResource
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
            'id'            => (int) ($this->id),
            'date'          => (string) ($this->date ? $this->date->format('Y-m-d') : ''),
            'formatedDate'  => (string) ($this->date ? $this->date->format('d M Y') : ''),
            'title'         => (string) ($this->title ?? ''),
            'body'          => (string) ($this->body ?? ''),
            'staffId'       => (int) ($this->staff_id ?? 0),
            'staffName'     => (string) ($this->staff->name ?? ''),
            'staff'         => new StaffResource($this->whenLoaded('staff')),
        ];
    }
}
