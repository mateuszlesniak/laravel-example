<?php

namespace App\DutyRoster\Dtr\Reader\Plugin\Html;

use App\DutyRoster\Shared\Dto\RosterDto;
use Symfony\Component\DomCrawler\Crawler;

final class RosterDtoDepartureTimeReaderPlugin extends AbstractReaderPlugin
{
    protected function getSelector(): string
    {
        return '.activitytablerow-stdutc';
    }

    public function fillRosterDto(Crawler $roster, RosterDto $rosterDto): void
    {
        $departure = $this->getValue($roster);

        if (strlen($departure) > 4) {
            return;
        }

        $rosterDto->getDeparture()->setTime(
            substr($departure, 0, 2),
            substr($departure, 2, 2),
        );
    }
}
