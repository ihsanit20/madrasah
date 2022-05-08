<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admission extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function getVerificationsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function scopeStudent($query)
    {
        $query->whereIn('status', [3]);
    }

    public function scopeAdmission($query)
    {
        $query->whereIn('status', [1, 1, 2]);
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

    public function payable_fees()
    {
        return $this->hasMany(PayableFee::class);
    }
}
