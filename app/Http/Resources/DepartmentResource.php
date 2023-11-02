<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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
            "name"          => (string) ($this->name ?? ''),
            "description"   => (string) ($this->description ?? ''),
            "is_active"     => (bool) ($this->is_active ?? false),

            "academic_sessions" => $this->whenLoaded('academic_sessions'),
        ];
    }
}
