<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'exam_classes', 'exam_id', 'class_id')->whereNull('exam_classes.deleted_at');
    }

    public function exam_classes()
    {
        return $this->hasMany(ExamClass::class);
    }

    public function seat_plans()
    {
        return $this->hasMany(SeatPlan::class);
    }
}
