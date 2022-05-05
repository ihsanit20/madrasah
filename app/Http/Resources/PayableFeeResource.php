<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PayableFeeResource extends JsonResource
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
            "id"            => (int) ($this->id),
            "period"        => (int) ($this->period ?? 0),
            "concession"    => (double) ($this->concession ?? 0),
            "payableAmount" => (double) ($this->payable_amount ?? 0),
            "amount"        => (double) ($this->amount ?? 0),
            "feeName"       => (string) ($this->fee_name ?? ''),
            "feeId"         => (int) ($this->fee_id ?? 0),
            "fee"           => new FeeResource($this->whenLoaded('fee')),
            "admissionId"   => (int) ($this->admission_id ?? 0),
            "admission"     => new AdmissionResource($this->whenLoaded('admission')),
        ];
    }
}
