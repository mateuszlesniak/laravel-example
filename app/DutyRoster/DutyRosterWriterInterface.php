<?php

namespace App\DutyRoster;

use App\DutyRoster\Shared\Dto\ActivitiesDtoCollection;

interface DutyRosterWriterInterface
{
    public function write(ActivitiesDtoCollection $dtoCollection): void;
}
