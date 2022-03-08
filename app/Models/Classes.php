<?php

namespace App\Models;

use App\Traits\ScopeSearch;
use App\Traits\ScopeSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function getTotalSubjectAttribute()
    {
        return $this->subjects()->count();
    }

    public function getTotalFeeAttribute()
    {
        return $this->subjects()->count();
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'class_id');
    }

    public function fees()
    {
        return $this->hasMany(Fee::class, 'class_id');
    }
}
