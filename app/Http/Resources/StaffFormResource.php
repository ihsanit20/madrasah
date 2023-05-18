<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StaffFormResource extends JsonResource
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
            'name'              => (string) ($this->name ?? ''),

            'phone'             => (string) ($this->phone ?? ''),
            'alternative_phone' => (string) ($this->alternative_phone ?? ''),

            'nid'               => (string) ($this->nid ?? ''),

            'gender'            => (string) ($this->gender ?? ''),
            'gender_text'       => (string) ($this->genderText ?? ''),

            'blood_group'       => (string) ($this->blood_group ?? ''),
            'blood_group_text'  => (string) ($this->blood_group_text ?? ''),
            
            'fathers_info'      => (object) ($this->fathers_info ?? []),
            'mothers_info'      => (object) ($this->mothers_info ?? []),
            'reference_info'    => (object) ($this->reference_info ?? []),
            
            'present_address_info'          => (object) ($this->present_address_info ?? []),
            'permanent_address_info'        => (object) ($this->permanent_address_info ?? []),
            'is_same_address'               => (boolean) ($this->is_same_address ?? false),
            'educational_qualifications'    => (object) ($this->educational_qualifications ?? []),
            
            
            'designation_id'        => (int) ($this->designation_id ?? 0),
            'designation_title'     => (string) ($this->designation->name ?? ""),
            'previous_experience'   => (string) ($this->previous_experience ?? ''),
            'expected_salary'       => (double) ($this->expected_salary ?? 0),
            
            'date_of_birth'             => (string) ($this->date_of_birth ? $this->date_of_birth->format('Y-m-d') : ''),
            'date_of_birth_with_format' => (string) ($this->date_of_birth ? $this->date_of_birth->format('d-m-Y') : ''),

            'status'                    => (int) ($this->status ?? 0),
        ];
    }

}
