<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'subtotal'      => (double) ($this->subtotal ?? 0.0),
            'discount'      => (double) ($this->discount ?? 0.0),
            'due'           => (double) ($this->due ?? 0.0),
            'paid'          => (double) ($this->paid ?? 0.0),
            'admissionId'   => (int) ($this->admission_id ?? 0),
            'admission'     => new AdmissionResource($this->whenLoaded('admission')),
            'fees'          => FeeResource::collection($this->whenLoaded('fees')),
        ];
    }
}
