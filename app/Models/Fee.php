<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fee extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public static $previous_session = "43-44";

    public static $current_session = "44-45";

    public static $prefix = "14";

    public static $eng_prefix = "20";

    protected $appends = [
        'period_name',
    ];

    protected $casts = [
        // 'months' => 'array',
    ];

    protected static $periods = [
        1 => 'ভর্তিকালীন প্রদেয়',
        2 => 'মাসিক প্রদেয়',
        // 3 => 'খন্ডকালীন প্রদেয়',
    ];

    protected static $purposes = [
        1 => [
            "period"    => 1,
            "title"     => "PRFP-LP শিক্ষাবর্ষে ভর্তি",
            "monthId"   => "",
        ],
        2 => [
            "period"    => 2,
            "title"     => "মাসিক প্রদেয় : শাওয়াল PRFP",
            "eng_title" => "মাসিক প্রদেয় : এপ্রিল PRFP",
            "monthId"   => 10,
        ],
        3 => [
            "period"    => 2,
            "title"     => "মাসিক প্রদেয় : জ্বিলকদ PRFP",
            "eng_title" => "মাসিক প্রদেয় : মে PRFP",
            "monthId"   => 11,
        ],
        4 => [
            "period"    => 2,
            "title"     => "মাসিক প্রদেয় : জ্বিলহজ্জ PRFP",
            "eng_title" => "মাসিক প্রদেয় : জুন PRFP",
            "monthId"   => 12,
        ],
        5 => [
            "period"    => 2,
            "title"     => "মাসিক প্রদেয় : মুহররম PRLP",
            "eng_title" => "মাসিক প্রদেয় : জুলাই PRFP",
            "monthId"   => 1,
        ],
        6 => [
            "period"    => 2,
            "title"     => "মাসিক প্রদেয় : সফর PRLP",
            "eng_title" => "মাসিক প্রদেয় : আগস্ট PRFP",
            "monthId"   => 2,
        ],
        7 => [
            "period"    => 2,
            "title"     => "মাসিক প্রদেয় : রবিউল আউয়াল PRLP",
            "eng_title" => "মাসিক প্রদেয় : সেপ্টেম্বর PRFP",
            "monthId"   => 3,
        ],
        8 => [
            "period"    => 2,
            "title"     => "মাসিক প্রদেয় : রবিউস সানি PRLP",
            "eng_title" => "মাসিক প্রদেয় : অক্টোবর PRFP",
            "monthId"   => 4,
        ],
        9 => [
            "period"    => 2,
            "title"     => "মাসিক প্রদেয় : জমাদিউল আউয়াল PRLP",
            "eng_title" => "মাসিক প্রদেয় : নভেম্বর PRFP",
            "monthId"   => 5,
        ],
        10 => [
            "period"    => 2,
            "title"     => "মাসিক প্রদেয় : জমাদিউস সানি PRLP",
            "eng_title" => "মাসিক প্রদেয় : ডিসেম্বর PRFP",
            "monthId"   => 6,
        ],
        11 => [
            "period"    => 2,
            "title"     => "মাসিক প্রদেয় : রজব PRLP",
            "eng_title" => "মাসিক প্রদেয় : জানুয়ারি PRLP",
            "monthId"   => 7,
        ],
        12 => [
            "period"    => 2,
            "title"     => "মাসিক প্রদেয় : শা'বান PRLP",
            "eng_title" => "মাসিক প্রদেয় : ফেব্রুয়ারি PRLP",
            "monthId"   => 8,
        ],
        13 => [
            "period"    => 2,
            "title"     => "মাসিক প্রদেয় : রমজান PRLP",
            "eng_title" => "মাসিক প্রদেয় : মার্চ PRLP",
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

        $is_arabic = substr(self::$current_session, 0, 2) > 42;

        $prefix = $is_arabic ? self::$prefix : self::$eng_prefix;

        $purposes = array_map(function($purpose) use ($prefix, $is_arabic) {
            $title = $is_arabic ? $purpose["title"] : ($purpose["eng_title"] ?? $purpose["title"]);

            $title = str_replace("PR", $prefix, $title);

            $title = str_replace("FP", substr(self::$current_session, 0, 2), $title);

            $title = str_replace("LP", substr(self::$current_session, 3, 2), $title);

            return [
                "period"    => $purpose["period"],
                "title"     => $title,
                "monthId"   => $purpose["monthId"],
            ];
        }, $purposes);

        return $purpose ? ($purposes[$purpose] ?? []) : $purposes;
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
