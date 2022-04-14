<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'id'    => (int) ($this->id ?? 0),
            'key'   => (string) ($this->key ?? ''),
            'name'  => (string) ($this->name ?? ''),
            'value' => (string) ($this->value ?? ''),
        ];
    }
}
