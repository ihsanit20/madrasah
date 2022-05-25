<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
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
            'id'            => (int) ($this->id),
            'amount'        => (double) ($this->amount ?? 0),
            'staffId'       => (int) ($this->staff_id ?? 0),
            'staffName'     => (string) ($this->staff->name ?? ''),
            'categoryId'    => (int) ($this->category_id ?? 0),
            'categoryName'  => (string) ($this->category->name ?? ''),
            'date'          => (string) ($this->date ?? ''),
        ];
    }
}
