<?php

namespace App\DutyRoster\Repository;

use App\DutyRoster\Shared\Dto\RosterDto;
use DateTime;
use Illuminate\Database\Eloquent\Collection;

interface RosterRepositoryInterface
{
    public function persistRosterDto(RosterDto $rosterDto): void;

    public function findRostersBetweenDates(DateTime $start, DateTime $end): Collection;
}
