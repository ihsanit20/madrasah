<?php

namespace App\Models;

use App\Traits\ScopeSearch;
use App\Traits\ScopeSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    
    protected $appends = [
        'code'
    ];

    public function getCodeAttribute()
    {
        return $this->id;
    }

    // public function getTotalStudentAttribute()
    // {
    //     return $this->students()->count();
    // }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'class_id');
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class, 'class_id');
    }

    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Admission::class, 'class_id', 'admission_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'admissions', 'class_id', 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function fees()
    {
        return $this->belongsToMany(Fee::class, 'class_fees', 'fee_id', 'class_id');
    }

    public function class_fees()
    {
        return $this->hasMany(ClassFee::class, 'class_id');
    }
}
