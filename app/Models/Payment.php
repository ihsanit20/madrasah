<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $appends = [
        'period_name',
    ];

    public function scopePeriod($query, $period = null)
    {
        return $period
            ? $query->where('period', $period)
            : $query;
    }

    public function getPeriodNameAttribute()
    {
        return Fee::getPeriod()[$this->period] ?? '';
    }

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function payment_details()
    {
        return $this->hasMany(PaymentDetail::class);
    }
}
