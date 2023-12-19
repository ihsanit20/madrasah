<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    use HasFactory, SoftDeletes;

    const ALL_SETTING_DATA_CACHE_KEY = 'ALL_SETTING_DATA_CACHE_KEY';

    protected $guarded = [];

    public function getValueAttribute($value)
    {
        if($this->key == 'logo') {
            $url = "";
        
            if(Storage::exists($value)) {
                $url = Storage::temporaryUrl($value, now()->addMinute(5));
            }

            return $url ?? $value;
        }

        return $value;
    }

    public function scopeProperties($query, array $properties = [])
    {
        $query->whereIn('key', $properties);
    }

    public function scopeProperty($query, $property)
    {
        $query->where('key', $property);
    }

    public function scopeType($query, $type)
    {
        $query->where('type', $type);
    }
}
