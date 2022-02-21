<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fee extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected static $periods = [
        1 => 'Monthly',
        2 => 'Annual',
    ];

    public static function getPeriod()
    {
        return self::$periods;
    }

    public function getPeriodNameAttribute()
    {
        return self::getPeriod()[$this->period] ?? '';
    }
}
