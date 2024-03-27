<?php

namespace App\DutyRoster\Shared\Dto;

use Ramsey\Collection\AbstractCollection;

class ActivitiesDtoCollection extends AbstractCollection
{
    public function getType(): string
    {
        return ActivityDto::class;
    }
}
