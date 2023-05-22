<?php

namespace App\Models;

use App\Traits\BloodGroup;
use App\Traits\Gender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffForm extends Model
{
    use HasFactory, SoftDeletes, BloodGroup, Gender;

    protected $guarded = [];

    public static $previous_session = "43-44";

    public static $current_session = "44-45";

    protected $casts = [
        'date_of_birth'                 => 'date',
        'fathers_info'                  => 'json',
        'mothers_info'                  => 'json',
        'reference_info'                => 'json',
        'present_address_info'          => 'json',
        'permanent_address_info'        => 'json',
        'educational_qualifications'    => 'json',
        'previous_experience'           => 'json',
        'default_salaries'              => 'json',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeCurrent($query)
    {
        return $query->where('session', self::$current_session);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
}
