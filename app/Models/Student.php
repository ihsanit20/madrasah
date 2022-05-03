<?php

namespace App\Models;

use App\Traits\BloodGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes, BloodGroup;

    protected $guarded = [];

    protected $appends = [
        'gender_text',
        'guardian_type',
        'current_admission',
    ];
    
    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public static $gender_array = [
        1 => 'Male',
        2 => 'Female',
    ];

    public static $resident_array = [
        1 => 'আবাসিক',
        2 => 'অনাবাসিক',
        3 => 'ডে-কেয়ার',
    ];

    public static function getGenderArrayData()
    {
        return self::$gender_array;
    }

    public static function getResidentArrayData()
    {
        return self::$resident_array;
    }

    public function getGenderTextAttribute()
    {
        return self::getGenderArrayData()[$this->gender] ?? '';
    }

    public function getResidentTextAttribute()
    {
        return self::getResidentArrayData()[$this->resident] ?? '';
    }

    public function getGuardianTypeAttribute()
    {
        if($this->father_info_id == $this->guardian_info_id) {
            return 1;
        }

        if($this->mother_info_id == $this->guardian_info_id) {
            return 2;
        }

        return 3;
    }

    public function getIsSameAddressAttribute()
    {
        return (boolean) ($this->present_address_id == $this->permanent_address_id);
    }

    public function getCurrentAdmissionAttribute()
    {
        $session = "43-44";

        return $this->admissions()->where('session', $session)->first();
    }

    public function getCurrentClassNameAttribute()
    {
        return (string) ( $this->current_admission ? ($this->current_admission->class->name ?? '') : '');
    }

    public function getCurrentClassRollAttribute()
    {
        return (string) ( $this->current_admission ? ($this->current_admission->roll ?? '') : '');
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    public function scopeInactive($query)
    {
        $query->where('status', 0);
    }

    public function scopeStudent($query)
    {
        $query->whereIn('status', [0,1]);
    }

    public function scopeAdmission($query)
    {
        $query->whereIn('status', [2,3]);
    }

    public function father_info()
    {
        return $this->belongsTo(Guardian::class, 'father_info_id');
    }

    public function mother_info()
    {
        return $this->belongsTo(Guardian::class, 'mother_info_id');
    }

    public function guardian_info()
    {
        return $this->belongsTo(Guardian::class, 'guardian_info_id');
    }

    public function present_address()
    {
        return $this->belongsTo(Address::class, 'present_address_id');
    }

    public function permanent_address()
    {
        return $this->belongsTo(Address::class, 'permanent_address_id');
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }
}
