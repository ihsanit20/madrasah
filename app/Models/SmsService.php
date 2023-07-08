<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use function PHPUnit\Framework\returnSelf;

class SmsService extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        "receivers" => "json",
    ];

    protected $appends = [
        "status_text",
        'date',
    ];

    public function getStatusTextAttribute()
    {
        switch($this->status) {
            case 1:
                return "বার্তা প্রস্তুত";

            case 2:
                return "বার্তা পাঠানো হয়েছে";

            default:
                return "বার্তা বাতিল করা হয়েছে";
        }

        return "বার্তা বাতিল করা হয়েছে";
    }

    public function getDateAttribute()
    {
        return $this->created_at
            ? $this->created_at->format('d M Y')
            : "";
    }

}
