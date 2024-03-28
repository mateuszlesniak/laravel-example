<?php

namespace App\DutyRoster\Dtr\Writer;

use App\DutyRoster\DutyRosterWriterInterface;
use App\DutyRoster\Shared\Dto\RosterDtoCollection;

class DtrDutyRosterWriter implements DutyRosterWriterInterface
{
    private array $locationEntities = [];

    public function write(RosterDtoCollection $dtoCollection): void
    {
        foreach ($dtoCollection as $rosterDto) {

        }
    }

}
