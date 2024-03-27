<?php

namespace App\DutyRoster\Dtr\Reader\Plugin\Html;

use App\DutyRoster\Shared\Dto\RosterDto;
use Symfony\Component\DomCrawler\Crawler;

final class RosterDtoArrivalTimeReaderPlugin extends AbstractReaderPlugin
{
    protected function getSelector(): string
    {
        return '.activitytablerow-stautc';
    }

    public function fillRosterDto(Crawler $roster, RosterDto $rosterDto): void
    {
        $arrival = $this->getValue($roster);

        if (strlen($arrival) > 4) {
            return;
        }

        $rosterDto->getArrival()->setTime(
            substr($arrival, 0, 2),
            substr($arrival, 2, 2),
        );
    }
}
