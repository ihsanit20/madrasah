<?php

namespace App\Http\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use PhpParser\Node\Expr\Cast\Object_;

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
            'id'                => (int) $this->id,
            'roll'              => (int) ($this->roll ?? 0),
            'studentId'         => (int) ($this->student_id ?? ''),
            'status'            => (int) ($this->status ?? 0),
            'studentName'       => (string) ($this->student->name ?? ''),
            'student'           => new StudentResource($this->whenLoaded('student')),
            'classId'           => (int) ($this->class_id ?? ''),
            'class'             => new ClassesResource($this->class),
            'className'         => (string) ($this->class->name ?? ''),
            'session'           => (int) ($this->year ?? 0),
            'previousSchool'    => (string) ($this->previous_school ?? ''),
            'previousClass'     => (string) ($this->previous_class ?? ''),
            'previousRoll'      => (string) ($this->previous_roll ?? ''),
            'previousResult'    => (string) ($this->previous_result ?? ''),
            'verifications'     => (object) ($this->verifications ?? []),
            'admissionTestMark' => (string) ($this->admission_test_mark ?? ''),
            'concessions'       => (array) (json_decode($this->concessions ?? '', 1)),
            'verifiedBy'        => (string) ($this->verified_by_admin->name ?? ''),
            'dateOfApplication' => (string) ($this->created_at ? $this->created_at->format('d-m-Y') : ''),
        ];
    }
}
