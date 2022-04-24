<?php

namespace App\Traits;

trait BloodGroup
{
    static $blood_groups = [
        1 => "A (+)",
        2 => "A (-)",
        3 => "B (+)",
        4 => "B (-)",
        5 => "AB (+)",
        6 => "AB (-)",
        7 => "O (+)",
        8 => "O (-)",
    ];

    static function getBloodGroups()
    {
        return self::$blood_groups;
    }

    public function getBloodGroup($value)
    {
        return self::$blood_groups[$value];
    }

    public function getBloodGroupTextAttribute()
    {
        return self::$blood_groups[$this->blood_group ?? 0] ?? '';
    }
}