<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'default_salaries' => 'array',
    ];

    protected $appends = [
        'due',
    ];

    public function getDueAttribute()
    {
        $salary = $this->salaries()->latest()->first() ?? null;

        return $salary
            ? $salary->due
            : 0;
    }

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

    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }
}
