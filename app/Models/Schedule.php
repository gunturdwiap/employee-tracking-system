<?php

namespace App\Models;

use App\Enums\Day;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts()
    {
        return [
            'work_start_time' => 'datetime:H:i:s',
            'work_end_time' => 'datetime:H:i:s',
            'day' => Day::class,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
