<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentIndexResource extends JsonResource
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
            'id'            => (int) $this->id,
            'paid'          => (double) ($this->paid ?? 0.0),
            'total'         => (double) ($this->total ?? 0.0),
            'date'          => (string) ($this->date ?? ''),
            'due'           => (double) ($this->due ?? 0.0),
            'admission'     => ($this->whenLoaded('admission') ?? collect([]))->toArray(),
        ];
    }
}
