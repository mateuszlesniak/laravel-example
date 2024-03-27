<?php

namespace App\DutyRoster;

use App\DutyRoster\Shared\Dto\ActivitiesDtoCollection;

interface DutyRosterTransformerInterface
{
    public function transform(ActivitiesDtoCollection $collection): void;
}
