<?php

namespace App\Models;

use App\Enums\VacationRequestStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacationRequest extends Model
{
    /** @use HasFactory<\Database\Factories\VacationRequestFactory> */
    use HasFactory;

    protected $guarded = [];

    protected function casts()
    {
        return [
            'start' => 'date:Y-m-d',
            'end' => 'date:Y-m-d',
            'status' => VacationRequestStatus::class
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
