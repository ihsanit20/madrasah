<?php

namespace App\Traits;

trait Gender
{
    public static $gender_array = [
        1 => 'ছেলে',
        2 => 'মেয়ে',
    ];

    public static function getGenderArrayData()
    {
        return self::$gender_array;
    }

    public function getGender($value)
    {
        return self::$gender_array[$value];
    }

    public function getGenderTextAttribute()
    {
        return self::getGenderArrayData()[$this->gender] ?? '';
    }
}