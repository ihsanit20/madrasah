<?php

namespace App\Models;

use App\Traits\ScopeDateFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory, SoftDeletes, ScopeDateFilter;

    protected $guarded = [];
    
    public static $previous_session = "43-44";

    public static $current_session = "44-45";

    public function scopeCurrent($query)
    {
        $current_session = self::$current_session;

        return $query->where('session', $current_session);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
