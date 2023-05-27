<?php

namespace App\Models;

use App\Traits\BloodGroup;
use App\Traits\Gender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory, SoftDeletes, BloodGroup, Gender;

    protected $guarded = [];

    public static $previous_session = "43-44";

    public static $current_session = "44-45";

    protected $casts = [
        'default_salaries'  => 'array',
        'fathers_info'      => 'json',
        'mothers_info'      => 'json',
        'reference_info'    => 'json',
        'date_of_birth'     => 'date',
        'joining_date'      => 'date',

        'present_address_info'      => 'json',
        'permanent_address_info'    => 'json',
    ];

    protected $appends = [
        'due',
        'due_purpose_id',
    ];

    public function getDueAttribute()
    {
        $salary = $this->salaries()->latest()->first() ?? null;

        return $salary
            ? $salary->due
            : 0;
    }

    public function getDuePurposeIdAttribute()
    {
        $salary = $this->salaries()->latest()->first() ?? null;

        return $salary && $salary->due > 0
            ? $salary->purpose_id
            : 0;
    }

    public function scopePrincipal($query)
    {
        return $query->whereHas('current_appointment', function($query) {
            $query->where('designation_id', 1);
        });
    }

    public function scopeMale($query)
    {
        return $query->where('gender', 1);
    }

    public function scopeFemale($query)
    {
        return $query->where('gender', 2);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable')
            ->latest('images.id')
            ->where('images.type', 1);
    }

    public function signature()
    {
        return $this->morphOne(Image::class, 'imageable')
            ->latest('images.id')
            ->where('images.type', 2);
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class)
            ->latest();
    }

    public function educational_qualifications()
    {
        return $this->hasMany(EducationalQualification::class)
            ->orderBy('educational_qualifications.year', 'desc');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function last_session_appointment()
    {
        $session = self::$previous_session;

        return $this->hasOne(Appointment::class)
            ->where('appointments.session', $session);
    }

    public function current_appointment()
    {
        $session = self::$current_session;

        return $this->hasOne(Appointment::class)
            ->where('appointments.session', $session);
    }

}
