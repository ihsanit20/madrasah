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
        'purpose_text',
    ];

    public function scopePurpose($query, $purpose = null)
    {
        return $purpose
            ? $query->where('purpose', $purpose)
            : $query;
    }

    public function getPurposeTextAttribute()
    {
        $purpose_array = Fee::getPurpose()[$this->purpose] ?? [];

        return $purpose_array["title"];
    }

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function payment_details()
    {
        return $this->hasMany(PaymentDetail::class);
    }

    public function collector()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
