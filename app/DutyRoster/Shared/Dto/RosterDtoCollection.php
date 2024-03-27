<?php

namespace App\DutyRoster\Shared\Dto;

use Ramsey\Collection\AbstractCollection;
use Traversable;

/**
 * @method Traversable|RosterDto[] getIterator()
 */
class RosterDtoCollection extends AbstractCollection
{
    public function getType(): string
    {
        return RosterDto::class;
    }
}
