<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdmissionResource extends JsonResource
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
            'roll'          => (int) ($this->roll ?? 0),
            'studentId'     => (int) ($this->student_id ?? ''),
            'studentName'   => (string) ($this->student->name ?? ''),
            'classId'       => (int) ($this->class_id ?? ''),
            'className'     => (string) ($this->class->name ?? ''),
            'year'          => (int) ($this->year ?? 0),
            'resident'      => (boolean) ($this->resident ?? 0),
        ];
    }
}
