<?php

namespace Tests\Unit\Http\Resources;

use App\DutyRoster\Dtr\ActivityEnum;
use App\Http\Resources\RosterResource;
use App\Models\Location;
use App\Models\Roster;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Tests\TestCase;

class RosterResourceTest extends TestCase
{
    public function testFormatResource(): void
    {
        $location = Location::create([
            'code' => 'COD'
        ]);
        $dateTime = new DateTime();
        $roster = (new Roster([
            'day' => $dateTime,
            'activity_code' => ActivityEnum::FLIGHT,
            'flight_number' => 123,
            'activity_start' => $dateTime,
            'activity_end' => $dateTime,
            'departure' => $dateTime,
            'arrival' => $dateTime,
            'check_in_location_id' => $location->id,
            'check_out_location_id' => $location->id,
        ]));
        $collection = new Collection();
        $collection->add($roster);

        $result = RosterResource::collection($collection);

        $this->assertEquals([
            [
                'day' => $dateTime->format('Y-m-d'),
                'activity_code' => ActivityEnum::FLIGHT->label(),
                'flight_number' => 123,
                'activity_start' => $dateTime->format('H:i'),
                'activity_end' => $dateTime->format('H:i'),
                'departure' => $dateTime->format('H:i'),
                'arrival' => $dateTime->format('H:i'),
                'check_in' => 'COD',
                'check_out' => 'COD',
            ]
        ], $result->toArray(new Request()));
    }
}
