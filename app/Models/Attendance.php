<?php

namespace App\Models;

use App\Enums\AttendanceStatus;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AttendanceVerificationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'date' => 'datetime:Y-m-d',
            'check_in_time' => 'datetime:H:i:s',
            'check_out_time' => 'datetime:H:i:s',
            'status' => AttendanceStatus::class,
            'verification_status' => AttendanceVerificationStatus::class
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
