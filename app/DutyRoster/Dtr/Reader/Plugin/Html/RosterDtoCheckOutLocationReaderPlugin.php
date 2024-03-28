<?php

namespace App\DutyRoster\Dtr\Reader\Plugin\Html;

use App\DutyRoster\Shared\Dto\LocationDto;
use App\DutyRoster\Shared\Dto\RosterDto;
use InvalidArgumentException;
use Symfony\Component\DomCrawler\Crawler;

final class RosterDtoCheckOutLocationReaderPlugin extends AbstractReaderPlugin
{
    protected function getSelector(): string
    {
        return '.activitytablerow-tostn';
    }

    public function fillRosterDto(Crawler $roster, RosterDto $rosterDto): void
    {
        $checkOutLocation = $this->getValue($roster);

        if (strlen($checkOutLocation) !== 3) {
            throw new InvalidArgumentException();
        }

        $rosterDto->setCheckOutLocation((new LocationDto())->setCode($checkOutLocation));
    }
}
