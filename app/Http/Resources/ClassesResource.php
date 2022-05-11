<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassesResource extends JsonResource
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
            'name'          => (string) ($this->name ?? ''),
            'code'          => (string) ($this->code ?? ''),
            'description'   => (string) ($this->description ?? ''),
            'staffId'       => (int) ($this->staff_id ?? 0),
            'teacherId'     => (int) ($this->staff_id ?? 0),
            'teacherName'   => (string) ($this->teacher->name ?? ''),
            'totalSubject'  => (int) ($this->total_subject ?? 0),
            'totalFee'      => (int) ($this->total_fee ?? 0),
            'totalStudent'  => (int) ($this->total_student ?? 0),
            'subjects'      => SubjectResource::collection($this->whenLoaded('subjects')),
            'fees'          => FeeResource::collection($this->whenLoaded('fees')),
            'classFees'     => ClassFeeResource::collection($this->whenLoaded('class_fees')),
        ];
    }
}
