<?php

namespace App\Models;

use App\Traits\ScopeSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salary extends Model
{
    use HasFactory, SoftDeletes, ScopeSearch;

    protected $guarded = [];

    public static $previous_session = "43-44";

    public static $current_session = "44-45";

    protected $casts = [
        'salaries' => 'array',
    ];

    protected $appends = [
        'purpose_text',
        'created_at_as_text',
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
        13 => "মাসিক বেতন : মে ২০২৩",
        14 => "মাসিক বেতন : জুন ২০২৩",
        15 => "মাসিক বেতন : জুলাই ২০২৩",
        16 => "মাসিক বেতন : আগস্ট ২০২৩",
        17 => "মাসিক বেতন : সেপ্টেম্বর ২০২৩",
        18 => "মাসিক বেতন : অক্টোবর ২০২৩",
        19 => "মাসিক বেতন : নভেম্বর ২০২৩",
        20 => "মাসিক বেতন : ডিসেম্বর ২০২৩",

        21 => "মাসিক বেতন : জানুয়ারি ২০২৪",
        22 => "মাসিক বেতন : ফেব্রুয়ারি ২০২৪",
        23 => "মাসিক বেতন : মার্চ ২০২৪",
        24 => "মাসিক বেতন : এপ্রিল ২০২৪",        
        25 => "মাসিক বেতন : মে ২০২৪",
        26 => "মাসিক বেতন : জুন ২০২৪",
        27 => "মাসিক বেতন : জুলাই ২০২৪",
        28 => "মাসিক বেতন : আগস্ট ২০২৪",
        29 => "মাসিক বেতন : সেপ্টেম্বর ২০২৪",
        30 => "মাসিক বেতন : অক্টোবর ২০২৪",
        31 => "মাসিক বেতন : নভেম্বর ২০২৪",
        32 => "মাসিক বেতন : ডিসেম্বর ২০২৪",
    ];
    
    public static function getPurpose($purpose = null)
    {
        $purposes = self::$purposes;

        return $purpose ? ($purposes[$purpose] ?? []) : $purposes;
    }

    public function getPurposeTextAttribute()
    {
        return self::getPurpose($this->purpose_id ?? 0) ?? '';
    }

    public function getcreatedAtAsTextAttribute()
    {
        return $this->created_at ? $this->created_at->format('d-m-Y') : '';
    }

    public function scopeFilter($query, $request)
    {
        return $query
            ->when($request->staff, function($query, $staff_id) {
                $query->where('staff_id', $staff_id);
            })
            ->when($request->purpose, function($query, $purpose_id) {
                $query->where('purpose_id', $purpose_id);
            });
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
