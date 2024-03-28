<?php

namespace App\DutyRoster\Repository;

use App\DutyRoster\Dtr\ActivityEnum;
use App\DutyRoster\Shared\Dto\RosterDto;
use App\Models\Location;
use DateTime;
use Illuminate\Database\Eloquent\Collection;

interface RosterRepositoryInterface
{
    public function persistRosterDto(RosterDto $rosterDto): void;

    public function findByCriteria(
        ?DateTime $start = null,
        ?DateTime $end = null,
        ?ActivityEnum $activityEnum = null,
        ?Location $startLocation = null,
    ): Collection;
}
