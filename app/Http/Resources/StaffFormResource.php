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
        $father_mother_empty_info = [
            "name"  => "",
            "phone" => "",
        ];

        $reference_empty_info = [
            "name"      => "",
            "phone"     => "",
            "relation"  => "",
            "address"   => "",
        ];

        $address_empty_info = [
            "division"  => "",
            "district"  => "",
            "area"      => "",
            "postoffice"=> "",
            "address"   => ""
        ];

        $previous_experience_empty = [
            "institute_name"    => "",
            "designation"       => "",
            "period"            => "",
        ];

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
            
            'fathers_info'      => (object) ($this->fathers_info ?? $father_mother_empty_info),
            'mothers_info'      => (object) ($this->mothers_info ?? $father_mother_empty_info),
            'reference_info'    => (object) ($this->reference_info ?? $reference_empty_info),
            
            'present_address_info'          => (object) ($this->present_address_info ?? $address_empty_info),
            'permanent_address_info'        => (object) ($this->permanent_address_info ?? $address_empty_info),
            'is_same_address'               => (boolean) ($this->is_same_address ?? false),

            'educational_qualifications'    => (array) ($this->educational_qualifications ?? []),
            
            'previous_experience'           => (object) ($this->previous_experience ?? $previous_experience_empty),
            
            'designation_id'        => (int) ($this->designation_id ?? 0),
            'designation_title'     => (string) ($this->designation->name ?? ""),
            'expected_salary'       => (double) ($this->expected_salary ?? 0),
            
            'date_of_birth'             => (string) ($this->date_of_birth ? $this->date_of_birth->format('Y-m-d') : ''),
            'date_of_birth_with_format' => (string) ($this->date_of_birth ? $this->date_of_birth->format('d-m-Y') : ''),

            'status'                    => (int) ($this->status ?? 0),
        ];
    }

}
