<?php

namespace App\Traits;

trait Resident
{
    public static $resident_array = [
        1 => 'আবাসিক',
        2 => 'অনাবাসিক',
        3 => 'ডে-কেয়ার',
        4 => 'সেমি-আবাসিক',
    ];

    public static function getResidentArrayData()
    {
        return self::$resident_array;
    }

    public function getResident($value)
    {
        return self::$resident_array[$value];
    }

    public function getResidentTextAttribute()
    {
        return self::getResidentArrayData()[$this->resident] ?? '';
    }
}