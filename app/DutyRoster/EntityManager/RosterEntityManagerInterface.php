<?php

namespace App\DutyRoster\EntityManager;

use App\DutyRoster\Shared\Dto\RosterDto;

interface RosterEntityManagerInterface
{
    public function persistRosterDto(RosterDto $rosterDto): void;
}
