<?php

namespace App\DutyRoster\Repository;

use App\DutyRoster\Shared\Dto\RosterDto;

interface RosterRepositoryInterface
{
    public function persistRosterDto(RosterDto $rosterDto): void;
}
