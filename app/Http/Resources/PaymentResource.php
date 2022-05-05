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
            'period'        => (int) ($this->period ?? 0),
            'periodName'    => (string) ($this->period_name ?? ''),
            'date'          => (string) ($this->date ?? ''),
            'due'           => (double) ($this->due ?? 0.0),
            'paid'          => (double) ($this->paid ?? 0.0),
            'admissionId'   => (int) ($this->admission_id ?? 0),
            'admission'     => new AdmissionResource($this->whenLoaded('admission')),
            'details'       => PaymentDetailResource::collection($this->whenLoaded('payment_details')),
        ];
    }
}
