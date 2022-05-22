<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentDetailResource extends JsonResource
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
            "title"         => (string) ($this->title ?? ''),
            "amount"        => (double) ($this->amount ?? 0),
            "concession"    => (double) ($this->concession ?? 0),
            "paymentId"     => (int) ($this->payment_id ?? 0),
        ];
    }
}
