<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function getUrlAttribute($value)
    {
        $url = "";
        
        if(Storage::exists($value)) {
            $url = Storage::temporaryUrl($value, now()->addMinute(5));
        }

        return $url ?? $value;
    }

    public function imageable()
    {
        return $this->morphTo();
    }
}
