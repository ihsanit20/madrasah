<?php

namespace App\Models;

use App\Traits\BloodGroup;
use App\Traits\Gender;
use App\Traits\Resident;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdmissionForm extends Model
{
    use HasFactory, SoftDeletes, BloodGroup, Gender, Resident;

    const COOKIE_KEY_FORM_ID = '_ADMISSION_FORM_ID_';

    const FORCE_PREVIOUS_SESSION = "44-45";
    const FORCE_CURRENT_SESSION = "45-46";

    protected $guarded = [];

    protected $casts = [
        'fathers_info'              => 'json',
        'mothers_info'              => 'json',
        'guardian_info'             => 'json',

        'present_address_info'      => 'json',
        'permanent_address_info'    => 'json',

        'previous_info'             => 'json',

        'is_same_address'           => 'bool',
    ];

    protected $appends = [
        'gender_text',
        'blood_group_text',
        'resident_text',
        'application_date',
    ];

    public function getApplicationDateAttribute()
    {
        return $this->created_at
            ? $this->created_at->format('Y-m-d')
            : "";
    }

    public function choice_class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
