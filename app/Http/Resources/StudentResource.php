<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // $current_admission = $this->current_admission()->first();
        // $latest_payments = $current_admission ? $current_admission->payments()->latest()->get() : [];

        $default_image = $this->gender == 1
            ? '/images/staff-male-default.png'
            : '/images/staff-female-default.jpg';

        return [
            'id'                    => (int) $this->id,
            'name'                  => (string) ($this->name ?? ''),
            'registration'          => (string) ($this->registration ?? ''),
            'dateOfBirth'           => (string) ($this->date_of_birth ? $this->date_of_birth->format('Y-m-d') : ''),
            'dateOfBirthWithFormat' => (string) ($this->date_of_birth ? $this->date_of_birth->format('d-m-Y') : ''),
            'gender'                => (string) ($this->gender ?? ''),
            'bloodGroup'            => (string) ($this->blood_group ?? ''),
            'bloodGroupText'        => (string) ($this->blood_group_text ?? ''),
            'genderText'            => (string) ($this->genderText ?? ''),
            'birthCertificate'      => (string) ($this->birth_certificate ?? ''),
            'fatherInfoId'          => (int) ($this->father_info_id ?? 0),
            'fatherInfo'            => new GuardianResource($this->whenLoaded('father_info')),
            'motherInfoId'          => (int) ($this->mother_info_id ?? 0),
            'motherInfo'            => new GuardianResource($this->whenLoaded('mother_info')),
            'guardianInfoId'        => (int) ($this->guardian_info_id ?? 0),
            'guardianInfo'          => new GuardianResource($this->whenLoaded('guardian_info')),
            'guardianType'          => (int) ($this->guardian_type ?? 3),
            'presentAddressId'      => (int) ($this->present_address_id ?? 0),
            'presentAddress'        => new AddressResource($this->whenLoaded('present_address')),
            'permanentAddressId'    => (int) ($this->permanent_address_id ?? 0),
            'permanentAddress'      => new AddressResource($this->whenLoaded('permanent_address')),
            'isSameAddress'         => (boolean) ($this->is_same_address ?? 0),
            'resident'              => (int) ($this->resident ?? 0),
            'residentText'          => (string) ($this->resident_text ?? ''),
            'admissions'            => AdmissionResource::collection($this->whenLoaded('admissions')),
            'currentAdmission'      => new AdmissionResource($this->whenLoaded('current_admission')),
            'currentAdmissionId'    => (int) ($this->current_admission->id ?? 0),
            'currentClassName'      => (string) ($this->current_admission->class->name ?? ''),
            'currentClassRoll'      => (int) ($this->current_admission->roll ?? ''),
            'paidPurpose'           => (array) ($this->payment_purpose ?? []),
            'duePurposeId'          => (int) ($this->due_purpose_id ?? 0),
            'due'                   => (double) ($this->due ?? 0),
            // 'paidPurpose'           => (array) ($latest_payments ? $latest_payments->pluck('purpose')->toArray() : []),
            // 'duePurposeId'          => (int) ($latest_payments ? $latest_payments->first()->purpose : 0),
            // 'due'                   => (double) ($latest_payments ? $latest_payments->first()->due : 0),
            'imageUrl'              => (string) ($this->image->url ?? $default_image),
            // 'imageUrl'              => $this->when($this->whenLoaded('image', 1, 0), fn () => (string) $this->image->url ?? ''),
            'seatNumber'            => (string) ($this->seat_no ?? ''),
        ];

    }
}
