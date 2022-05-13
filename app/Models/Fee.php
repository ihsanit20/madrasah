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

    public static function getPeriodText($period)
    {
        return self::$periods[$period];
    }

    public function getPeriodNameAttribute()
    {
        return self::getPeriod()[$this->period] ?? '';
    }

    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'class_fees', 'class_id', 'fee_id');
    }

    public function class_fees()
    {
        return $this->hasMany(ClassFee::class, 'fee_id');
    }
}
