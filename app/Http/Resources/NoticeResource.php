<?php

namespace App\Http\Resources;

use Alkoumi\LaravelHijriDate\Hijri;
use App\Models\HijriMonth;
use Illuminate\Http\Resources\Json\JsonResource;

class NoticeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $months = HijriMonth::get();

        $formated_date = $this->date ? Hijri::Date('d', $this->date) . ' - ' . (HijriMonth::find(Hijri::Date('m', $this->date))->bengali ?? Hijri::Date('m', $this->date)) . ' - ' . Hijri::Date('Y', $this->date) : '';

        return [
            'id'            => (int) ($this->id),
            'date'          => (string) ($this->date ? $this->date->format('Y-m-d') : ''),
            'formatedDate'  => (string) ($formated_date ?? ''),
            'title'         => (string) ($this->title ?? ''),
            'body'          => (string) ($this->body ?? ''),
            'staffId'       => (int) ($this->staff_id ?? 0),
            'staffName'     => (string) ($this->staff->name ?? ''),
            'staff'         => new StaffResource($this->whenLoaded('staff')),
        ];
    }
}
