<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FeeResource extends JsonResource
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
            'name'          => (string) ($this->name ?? ''),
            'period'        => (int) ($this->period ?? 0),
            'periodName'    => (string) ($this->period_name ?? ''),
            // 'months'        => (array) ($this->months ?? 0),
        ];
    }
}
