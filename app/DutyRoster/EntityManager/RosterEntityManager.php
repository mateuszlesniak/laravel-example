<?php

namespace App\DutyRoster\EntityManager;

use App\DutyRoster\Shared\Dto\RosterDto;
use App\Location\EntityManager\LocationEntityManagerInterface;
use App\Models\Roster;

class RosterEntityManager implements RosterEntityManagerInterface
{

    public function __construct(
        LocationEntityManagerInterface $locationEntityManager
    )
    {
    }

    public function persistRosterDto(RosterDto $rosterDto): void
    {
        $model = $this->transformDtoToModel($rosterDto);

        $model->save();
    }

    private function transformDtoToModel(RosterDto $rosterDto): Roster
    {
        $checkInLocation = null;
        $checkPOutLocation = null;

        return new Roster([
            'day' => $rosterDto->getDay()->format('Y-m-d'),
            'activity_code' => $rosterDto->getActivity()->value,
            'flight_number' => $rosterDto->getFlightNumber(),
            'activity_start' => $rosterDto->getActivityStart()?->format('H:i'),
            'activity_end' => $rosterDto->getActivityEnd()?->format('H:i'),
            'departure' => $rosterDto->getDeparture()->format('H:i'),
            'arrival' => $rosterDto->getArrival()->format('H:i'),
            'check_in_location_id' => null,
            'check_out_location_id' => null,
        ]);
    }
}
