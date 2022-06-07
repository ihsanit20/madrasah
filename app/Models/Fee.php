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

    protected static $purposes =  [
        1 => [
            "period"    => 1,
            "title"     => "১৪৪৩-৪৪ শিক্ষাবর্ষে ভর্তি",
            "monthId"   => "",
        ],
        2 => [
            "period"    => 2,
            "title"     => "মাসিক প্রদেয় : শাওয়াল ১৪৪৩",
            "monthId"   => 10,
        ],
        3 => [
            "period"    => 2,
            "title"     => "মাসিক প্রদেয় : জ্বিলকদ ১৪৪৩",
            "monthId"   => 11,
        ],
        4 => [
            "period"    => 2,
            "title"     => "মাসিক প্রদেয় : জ্বিলহজ্জ ১৪৪৩",
            "monthId"   => 12,
        ],
        5 => [
            "period"    => 2,
            "title"     => "মাসিক প্রদেয় : মুহররম ১৪৪৪",
            "monthId"   => 1,
        ],
        6 => [
            "period"    => 2,
            "title"     => "মাসিক প্রদেয় : সফর ১৪৪৪",
            "monthId"   => 2,
        ],
        7 => [
            "period"    => 2,
            "title"     => "মাসিক প্রদেয় : রবিউল আউয়াল ১৪৪৪",
            "monthId"   => 3,
        ],
        8 => [
            "period"    => 2,
            "title"     => "মাসিক প্রদেয় : রবিউস সানি ১৪৪৪",
            "monthId"   => 4,
        ],
        9 => [
            "period"    => 2,
            "title"     => "মাসিক প্রদেয় : জমাদিউল আউয়াল ১৪৪৪",
            "monthId"   => 5,
        ],
        10 => [
            "period"    => 2,
            "title"     => "মাসিক প্রদেয় : জমাদিউস সানি ১৪৪৪",
            "monthId"   => 6,
        ],
        11 => [
            "period"    => 2,
            "title"     => "মাসিক প্রদেয় : রজব ১৪৪৪",
            "monthId"   => 7,
        ],
        12 => [
            "period"    => 2,
            "title"     => "মাসিক প্রদেয় : শা'বান ১৪৪৪",
            "monthId"   => 8,
        ],
        13 => [
            "period"    => 2,
            "title"     => "মাসিক প্রদেয় : রমজান ১৪৪৪",
            "monthId"   => 9,
        ],
    ];

    public static function getPeriod()
    {
        return self::$periods;
    }

    public static function getPurpose($purpose = null)
    {
        $purposes = self::$purposes;

        return $purpose ? $purposes[$purpose] : $purposes;
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
