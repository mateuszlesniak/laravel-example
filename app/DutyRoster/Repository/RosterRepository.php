<?php

namespace App\DutyRoster\Repository;

use App\DutyRoster\Dtr\ActivityEnum;
use App\DutyRoster\Shared\Dto\RosterDto;
use App\Location\LocationRepositoryInterface;
use App\Models\Location;
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

        $rosterDto->setId($model->id);
    }

    public function findByCriteria(
        ?DateTime $start = null,
        ?DateTime $end = null,
        ?ActivityEnum $activityEnum = null,
        ?Location $startLocation = null,
    ): Collection
    {
        $query = Roster::with(['checkInLocation', 'checkOutLocation']);

        if ($start) {
            $query->where('day', '>=', $start->format('Y-m-d'));
        }

        if ($end) {
            $query->where('day', '<=', $end->format('Y-m-d'));
        }

        if ($activityEnum) {
            $query->where('activity_code', '=', $activityEnum->code());
        }

        if ($startLocation) {
            $query->whereCheckInLocationId($startLocation->id);
        }

        return $query->get();
    }

    private function transformDtoToModel(RosterDto $rosterDto): Roster
    {
        if (!$rosterDto->getCheckInLocation()->getId()) {
            $checkInLocation = $this->locationRepository->findOrCreateByCode($rosterDto->getCheckInLocation()->getCode());
            $rosterDto->getCheckInLocation()->setId($checkInLocation->id);
        }

        if (!$rosterDto->getCheckOutLocation()->getId()) {
            $checkOutLocation = $this->locationRepository->findOrCreateByCode($rosterDto->getCheckOutLocation()->getCode());
            $rosterDto->getCheckOutLocation()->setId($checkOutLocation->id);
        }

        return new Roster([
            'day' => $rosterDto->getDay()->format('Y-m-d'),
            'activity_code' => $rosterDto->getActivity()->value,
            'flight_number' => $rosterDto->getFlightNumber(),
            'activity_start' => $rosterDto->getActivityStart()?->format('H:i'),
            'activity_end' => $rosterDto->getActivityEnd()?->format('H:i'),
            'departure' => $rosterDto->getDeparture()->format('H:i'),
            'arrival' => $rosterDto->getArrival()->format('H:i'),
            'check_in_location_id' => $rosterDto->getCheckOutLocation()->getId(),
            'check_out_location_id' =>$rosterDto->getCheckOutLocation()->getId(),
        ]);
    }
}
