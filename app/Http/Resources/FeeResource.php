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
            'id'            => $this->id,
            'name'          => (string) ($this->name ?? ''),
            'period'        => (int) ($this->period ?? 0),
            'periodName'    => (string) ($this->period_name ?? ''),
            'amount'        => (double) ($this->amount ?? 0),
            'classId'       => (int) ($this->class_id ?? 0),
            'className'     => (string) ($this->class->name ?? ''),
        ];;
    }
}
