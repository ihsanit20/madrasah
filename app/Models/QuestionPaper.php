<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionPaper extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    const LANGUAGE_TYPE = [
        1 => 'Bangla',
        2 => 'Arabic',
        3 => 'English',
    ];

    const MADRASAH_NAME = [
        1 => 'মাদরাসা সায়্যিদাতুল জান্নাত (রা.)',
        2 => 'مدرسة سيدة الجنة (رض)',
        3 => 'Madrasah Saiyedatul Zannat (R.)',
    ];

    public static function getLanguageType()
    {
        return self::LANGUAGE_TYPE;
    }

    public static function getMadrasahName()
    {
        return self::MADRASAH_NAME;
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }
}
