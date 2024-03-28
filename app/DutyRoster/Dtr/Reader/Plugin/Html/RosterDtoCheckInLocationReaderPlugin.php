<?php

namespace App\DutyRoster\Dtr\Reader\Plugin\Html;

use App\DutyRoster\Shared\Dto\LocationDto;
use App\DutyRoster\Shared\Dto\RosterDto;
use InvalidArgumentException;
use Symfony\Component\DomCrawler\Crawler;

final class RosterDtoCheckInLocationReaderPlugin extends AbstractReaderPlugin
{
    protected function getSelector(): string
    {
        return '.activitytablerow-fromstn';
    }

    public function fillRosterDto(Crawler $roster, RosterDto $rosterDto): void
    {
        $checkInLocation = $this->getValue($roster);

        if (strlen($checkInLocation) !== 3) {
            throw new InvalidArgumentException();
        }

        $rosterDto->setCheckInLocation((new LocationDto())->setCode($checkInLocation));
    }
}
