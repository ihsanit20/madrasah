<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
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

        return [
            'id'                => (int) $this->id,
            'name'              => (string) ($this->name ?? ''),
            'phone'             => (string) ($this->phone ?? ''),
            'alternative_phone' => (string) ($this->alternative_phone ?? ''),
            'designationId'     => (int) ($this->current_appointment->designation_id ?? 0),
            'designationTitle'  => (string) ($this->current_appointment->designation->name ?? ''),
            // 'designation'       => new DesignationResource($this->whenLoaded('designation')),
            'allowDeletion'     => (boolean) (true),
            'imageUrl'          => (string) ($this->image->url ?? ''),
            'signatureUrl'      => (string) ($this->signature->url ?? ''),
            'paid_salaries'     => (object) ($this->salaries ?? []),
            'default_salaries'  => (array) ($this->current_appointment->default_salaries ?? []),
            'due'               => (int) ($this->due ?? 0),
            'due_purpose_id'    => (int) ($this->due_purpose_id ?? 0),

            'gender'            => (string) ($this->gender ?? ''),
            'genderText'        => (string) ($this->genderText ?? ''),
            'bloodGroup'        => (string) ($this->blood_group ?? ''),
            'bloodGroupText'    => (string) ($this->blood_group_text ?? ''),
            'nid'               => (string) ($this->nid ?? ''),

            'fathers_info'      => (object) ($this->fathers_info ?? $father_mother_empty_info),
            'mothers_info'      => (object) ($this->mothers_info ?? $father_mother_empty_info),
            'reference_info'    => (object) ($this->reference_info ?? $reference_empty_info),
            
            'present_address_id'        => (int) ($this->present_address_id ?? 0),
            'present_address_info'      => new AddressResource($this->whenLoaded('present_address')),
            'permanent_address_id'      => (int) ($this->permanent_address_id ?? 0),
            'permanent_address_info'    => new AddressResource($this->whenLoaded('permanent_address')),
            'is_same_address'           => (boolean) ($this->is_same_address ?? 0),

            'joining_date'              => (string) ($this->joining_date ? $this->joining_date->format('Y-m-d') : ''),
            'joining_date_with_format'  => (string) ($this->joining_date ? $this->joining_date->format('d-m-Y') : ''),

            'date_of_birth'             => (string) ($this->date_of_birth ? $this->date_of_birth->format('Y-m-d') : ''),
            'date_of_birth_with_format' => (string) ($this->date_of_birth ? $this->date_of_birth->format('d-m-Y') : ''),

            'educational_qualifications' => EducationalQualificationResource::collection($this->whenLoaded('educational_qualifications')),
        ];
    }

}
