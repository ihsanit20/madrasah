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

    public function getTotalSubjectAttribute()
    {
        return $this->subjects()->count();
    }

    public function getTotalFeeAttribute()
    {
        return $this->subjects()->count();
    }

    public function getTotalStudentAttribute()
    {
        return $this->students()->count();
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'class_id');
    }

    public function fees()
    {
        return $this->hasMany(Fee::class, 'class_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'admissions', 'class_id', 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
