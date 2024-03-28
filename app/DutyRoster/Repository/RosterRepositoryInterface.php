<?php

namespace App\DutyRoster\Repository;

use App\DutyRoster\Dtr\ActivityEnum;
use App\DutyRoster\Shared\Dto\RosterDto;
use DateTime;
use Illuminate\Database\Eloquent\Collection;

interface RosterRepositoryInterface
{
    public function persistRosterDto(RosterDto $rosterDto): void;

    public function findByCriteria(DateTime $start, DateTime $end, ?ActivityEnum $activityEnum = null): Collection;
}
