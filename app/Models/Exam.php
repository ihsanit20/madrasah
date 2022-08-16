<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    const LANGUAGE_TYPE = [
        1 => 'Bangla',
        2 => 'Arabic',
        3 => 'English',
    ];

    public static function getLanguageType()
    {
        return self::LANGUAGE_TYPE;
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }
}
