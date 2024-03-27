<?php

namespace App\DutyRoster;

use App\DutyRoster\Shared\Dto\RosterDtoCollection;

interface DutyRosterTransformerInterface
{
    public function transform(RosterDtoCollection $collection): void;
}
