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
            'total'         => (double) ($this->total ?? 0.0),
            'purpose'       => (int) ($this->purpose ?? 0),
            'purposeText'   => (string) ($this->purpose->title ?? ($this->purpose_text ?? "")),
            'date'          => (string) ($this->date ?? ''),
            'due'           => (double) ($this->due ?? 0.0),
            'paid'          => (double) ($this->paid ?? 0.0),
            'admissionId'   => (int) ($this->admission_id ?? 0),
            'admission'     => new AdmissionResource($this->whenLoaded('admission')),
            'details'       => PaymentDetailResource::collection($this->whenLoaded('payment_details')),
            'collectorName' => (string) ($this->collector->name ?? ''),
        ];
    }
}
