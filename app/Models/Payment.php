<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function fees()
    {
        return $this->belongsToMany(Fee::class, 'payment_details');
    }
}
