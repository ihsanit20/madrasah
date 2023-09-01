<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    const MAX_PIN_ITEM = 4;

    protected $guarded = [];

    public static function getTypes()
    {
        return [
            1 => 'Article',
        ];
    }

    public function getValueOfTypeAttribute()
    {
        $types = self::getTypes();

        return $types[$this->type ?? 1];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
