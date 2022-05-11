<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassFeeResource extends JsonResource
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
            'id'        => (int) $this->id,
            'classId'   => (int) ($this->class_id ?? 0),
            'feeId'     => (int) ($this->fee_id ?? 0),
            'fee'       => new FeeResource($this->whenLoaded('fee') ?? 0),
            'package'   => (Array) (json_decode($this->package) ?? []),
            'amount'    => (double) ($this->amount ?? 0),
            'name'      => (string) ($this->fee->name ?? ''),
            'period'    => (int) ($this->fee->period ?? 0),
        ];
    }
}
