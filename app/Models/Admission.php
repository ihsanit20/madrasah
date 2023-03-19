<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admission extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'paid_purposes' => 'array',
    ];

    public static $previous_session = "43-44";

    public static $current_session = "44-45";

    public function getVerificationsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function scopeLastSession($query)
    {
        $current_session = self::$previous_session;

        return $query->where('session', $current_session);
    }

    public function scopeCurrent($query)
    {
        $current_session = self::$current_session;

        return $query->where('session', $current_session);
    }

    public function scopeStudent($query)
    {
        return $query->whereIn('status', [4]);
    }

    public function scopeAdmission($query)
    {
        return $query->whereIn('status', [1, 2, 3]);
    }

    public function verified_by_admin()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
