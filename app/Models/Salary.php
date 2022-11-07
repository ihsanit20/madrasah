<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salary extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'salaries' => 'array',
    ];

    protected static $purposes =  [
        1 => "মাসিক বেতন : মে ২০২২",
        2 => "মাসিক বেতন : জুন ২০২২",
        3 => "মাসিক বেতন : জুলাই ২০২২",
        4 => "মাসিক বেতন : আগস্ট ২০২২",
        5 => "মাসিক বেতন : সেপ্টেম্বর ২০২২",
        6 => "মাসিক বেতন : অক্টোবর ২০২২",
        7 => "মাসিক বেতন : নভেম্বর ২০২২",
        8 => "মাসিক বেতন : ডিসেম্বর ২০২২",
        9 => "মাসিক বেতন : জানুয়ারি ২০২৩",
        10 => "মাসিক বেতন : ফেব্রুয়ারি ২০২৩",
        11 => "মাসিক বেতন : মার্চ ২০২৩",
        12 => "মাসিক বেতন : এপ্রিল ২০২৩",
    ];
    
    public static function getPurpose($purpose = null)
    {
        $purposes = self::$purposes;

        return $purpose ? ($purposes[$purpose] ?? []) : $purposes;
    }
}
