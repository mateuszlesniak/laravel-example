<?php

namespace App\DutyRoster\Repository;

use App\DutyRoster\Shared\Dto\RosterDto;
use App\Location\LocationRepositoryInterface;
use App\Models\Roster;
use DateTime;
use Illuminate\Database\Eloquent\Collection;

class RosterRepository implements RosterRepositoryInterface
{
    public function __construct(
        private readonly LocationRepositoryInterface $locationRepository
    )
    {
    }

    public function persistRosterDto(RosterDto $rosterDto): void
    {
        $model = $this->transformDtoToModel($rosterDto);

        $model->save();
    }

    public function findRostersBetweenDates(DateTime $start, DateTime $end): Collection
    {
        return Roster::with(['checkInLocation', 'checkOutLocation'])
            ->where('day', '>=', $start->format('Y-m-d'))
            ->where('day', '<=', $end->format('Y-m-d'))
            ->get();
    }

    private function transformDtoToModel(RosterDto $rosterDto): Roster
    {
        $checkInLocation = $this->locationRepository->findOrCreateByCode($rosterDto->getCheckInLocation()->getCode());
        $checkPOutLocation = $this->locationRepository->findOrCreateByCode($rosterDto->getCheckOutLocation()->getCode());

        return new Roster([
            'day' => $rosterDto->getDay()->format('Y-m-d'),
            'activity_code' => $rosterDto->getActivity()->value,
            'flight_number' => $rosterDto->getFlightNumber(),
            'activity_start' => $rosterDto->getActivityStart()?->format('H:i'),
            'activity_end' => $rosterDto->getActivityEnd()?->format('H:i'),
            'departure' => $rosterDto->getDeparture()->format('H:i'),
            'arrival' => $rosterDto->getArrival()->format('H:i'),
            'check_in_location_id' => $checkInLocation->id,
            'check_out_location_id' => $checkPOutLocation->id,
        ]);
    }
}
