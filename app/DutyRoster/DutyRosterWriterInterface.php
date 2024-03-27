<?php

namespace App\DutyRoster;

use App\DutyRoster\Shared\Dto\RosterDtoCollection;

interface DutyRosterWriterInterface
{
    public function write(RosterDtoCollection $dtoCollection): void;
}
