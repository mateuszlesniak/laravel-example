<?php

namespace App\DutyRoster\Shared\Dto;

use Ramsey\Collection\AbstractCollection;

class RosterDtoCollection extends AbstractCollection
{
    public function getType(): string
    {
        return RosterDto::class;
    }
}
