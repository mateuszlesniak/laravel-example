<?php

namespace App\DutyRoster\Dtr\Writer;

use App\DutyRoster\DutyRosterWriterInterface;
use App\DutyRoster\Repository\RosterRepositoryInterface;
use App\DutyRoster\Shared\Dto\RosterDtoCollection;

class DtrDutyRosterWriter implements DutyRosterWriterInterface
{

    public function __construct(
        private readonly RosterRepositoryInterface $rosterRepository,
    )
    {
    }

    public function write(RosterDtoCollection $dtoCollection): void
    {
        foreach ($dtoCollection as $rosterDto) {
            $this->rosterRepository->persistRosterDto($rosterDto);
        }
    }
}
