<?php

namespace App\Models;

use App\DutyRoster\Dtr\ActivityEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Roster extends Model
{
    protected $fillable = [
        'day',
        'activity_code',
        'flight_number',
        'activity_start',
        'activity_end',
        'departure',
        'arrival',
        'check_in_location_id',
        'check_out_location_id',
    ];

    protected function casts(): array
    {
        return [
            'day' => 'date:Y-m-d',
            'activity_code' => ActivityEnum::class,
            'activity_start' => 'datetime:H:i',
            'activity_end' => 'datetime:H:i',
            'departure' => 'datetime:H:i',
            'arrival' => 'datetime:H:i',
        ];
    }


    public function checkInLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'id', 'check_in_location_id');
    }

    public function checkOutLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'id', 'check_out_location_id');
    }
}
