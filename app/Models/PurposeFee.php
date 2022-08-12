<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurposeFee extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function purpose()
    {
        return $this->belongsTo(Purpose::class);
    }
}
