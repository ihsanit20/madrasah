<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function scopeProperty($query, $property)
    {
        $query->where('key', $property);
    }

    public function scopeType($query, $type)
    {
        $query->where('type', $type);
    }
}
