<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mockery\Matcher\Subset;

class Subject extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    
    protected $appends = [
        'code'
    ];

    public function getCodeAttribute()
    {
        $sl = 1;

        $sl += Subject::query()
            ->where('id', '<', $this->id)
            ->where('class_id', $this->class_id)
            ->count();

        return $this->class_id . str_pad($sl, 2, '0', STR_PAD_LEFT);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }
}
