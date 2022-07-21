<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable')
            ->latest('images.id')
            ->where('images.type', 1);
    }

    public function signature()
    {
        return $this->morphOne(Image::class, 'imageable')
            ->latest('images.id')
            ->where('images.type', 2);
    }
}
