<?php

namespace App\Http\Resources;

use Alkoumi\LaravelHijriDate\Hijri;
use App\Models\HijriMonth;
use Illuminate\Http\Resources\Json\JsonResource;

class SimpleNoticeResource extends JsonResource
{
    public static $months = null;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $months = self::$months ?? HijriMonth::get();

        self::$months = $months;

        $month = $months->where('id', Hijri::Date('m', $this->date))->first()->bengali ?? Hijri::Date('m', $this->date);

        $formated_date = $this->date 
            ? Hijri::Date('d', $this->date) . ' - ' . $month . ' - ' . Hijri::Date('Y', $this->date) 
            : '';

        return [
            'id'            => (int) ($this->id),
            'date'          => (string) ($this->date ? $this->date->format('Y-m-d') : ''),
            'formatedDate'  => (string) ($formated_date ?? ''),
            'title'         => (string) ($this->title ?? ''),
            'body'          => (string) ($this->body ?? ''),
            'staffId'       => (int) ($this->staff_id ?? 0),
            'staffName'     => (string) ($this->staff->name ?? ''),
        ];
    }
}
