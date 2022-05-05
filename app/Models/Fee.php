<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fee extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $appends = [
        'period_name',
    ];

    protected static $periods = [
        1 => 'ভর্তিকালীন প্রদেয়',
        2 => 'মাসিক প্রদেয়',
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
