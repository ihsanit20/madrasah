<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public static $previous_session = "43-44";

    public static $current_session = "44-45";

    public function getAcademicSessionAttribute()
    {
        return substr($this->session ?? "", -5, 5);
    }

    public function scopeCurrent($query)
    {
        $current_session = self::$current_session;

        $is_arabic = substr(self::$current_session, 0, 2) > 42;

        $prefix = $is_arabic ? "14" : "20";

        return $query->where('session', $prefix . $current_session);
    }

    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'exam_classes', 'exam_id', 'class_id')
            ->whereNull('exam_classes.deleted_at')
            ->orderBy('exam_classes.class_id');
    }

    public function exam_classes()
    {
        return $this->hasMany(ExamClass::class)
            ->orderBy('exam_classes.class_id');
    }

    public function seat_plans()
    {
        return $this->hasMany(SeatPlan::class);
    }
}
