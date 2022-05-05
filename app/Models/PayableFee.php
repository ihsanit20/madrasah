<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayableFee extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $appends = [
        'fee_name',
        'payable_amount',
        'period',
        'amount',
    ];

    public function getFeeNameAttribute()
    {
        return $this->fee()->first()->name ?? '';
    }

    public function getPayableAmountAttribute()
    {
        return $this->getAmountAttribute() - $this->concession;
    }

    public function getAmountAttribute()
    {
        return $this->fee()->first()->amount;
    }

    public function getPeriodAttribute()
    {
        return $this->fee()->first()->period;
    }

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function fee()
    {
        return $this->belongsTo(Fee::class);
    }
}
