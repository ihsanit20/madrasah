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
        1 => "মাসিক বেতন : শাওয়াল ১৪৪৩",
        2 => "মাসিক বেতন : জ্বিলকদ ১৪৪৩",
        3 => "মাসিক বেতন : জ্বিলহজ্জ ১৪৪৩",
        4 => "মাসিক বেতন : মুহররম ১৪৪৪",
        5 => "মাসিক বেতন : সফর ১৪৪৪",
        6 => "মাসিক বেতন : রবিউল আউয়াল ১৪৪৪",
        7 => "মাসিক বেতন : রবিউস সানি ১৪৪৪",
        8 => "মাসিক বেতন : জমাদিউল আউয়াল ১৪৪৪",
        9 => "মাসিক বেতন : জমাদিউস সানি ১৪৪৪",
        10 => "মাসিক বেতন : রজব ১৪৪৪",
        11 => "মাসিক বেতন : শা'বান ১৪৪৪",
        12 => "মাসিক বেতন : রমজান ১৪৪৪",
    ];
    
    public static function getPurpose($purpose = null)
    {
        $purposes = self::$purposes;

        return $purpose ? ($purposes[$purpose] ?? []) : $purposes;
    }
}
