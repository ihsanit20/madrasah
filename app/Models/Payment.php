<?php

namespace App\Models;

use App\Traits\ScopeSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes, ScopeSearch;

    protected $guarded = [];

    protected $appends = [
        'purpose_text',
    ];

    
    protected $casts = [
        'purposes' => 'array',
    ];

    public function scopeFilter($query, $request)
    {
        return $query
            ->when($request->class, function($query, $class_id) {
                $query->whereHas('admission', function($query) use ($class_id) {
                    $query->where('class_id', $class_id);
                });
            })
            ->when($request->student, function($query, $student_id) {
                $query->whereHas('admission', function($query) use ($student_id) {
                    $query->where('student_id', $student_id);
                });
            })
            ->where(function($query) use ($request) {
                $query
                    ->when($request->purpose, function($query, $purpose_id) {
                        $query->where('purpose', $purpose_id);
                    })
                    ->when($request->other_purpose, function($query, $purpose_id) {
                        $query->orWhere('purpose', $purpose_id);
                    });
            });
    }

    public function scopePurpose($query, $purpose = null)
    {
        return $purpose
            ? $query->where('purpose', $purpose)
            : $query;
    }

    public function getPurposeTextAttribute()
    {
        $purpose = Purpose::find($this->purpose);

        $purpose_array = Fee::getPurpose()[$this->purpose] ?? [];

        return $purpose
            ? ($purpose->title ?? '')
            : ($purpose_array["title"] ?? "");
    }

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function payment_details()
    {
        return $this->hasMany(PaymentDetail::class);
    }

    public function collector()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
