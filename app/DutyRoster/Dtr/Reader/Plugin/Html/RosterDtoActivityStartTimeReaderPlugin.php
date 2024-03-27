<?php

namespace App\DutyRoster\Dtr\Reader\Plugin\Html;

use App\DutyRoster\Shared\Dto\RosterDto;
use Symfony\Component\DomCrawler\Crawler;

final class RosterDtoActivityStartTimeReaderPlugin extends AbstractReaderPlugin
{
    protected function getSelector(): string
    {
        return '.activitytablerow-checkinutc';
    }

    public function fillRosterDto(Crawler $roster, RosterDto $rosterDto): void
    {
        $activityStart = $this->getValue($roster);

        if (empty($activityStart)) {
            $rosterDto->setActivityStart(null);

            return;
        }

        $rosterDto->getActivityStart()->setTime(
            (int) substr($activityStart, 0, 2),
            (int) substr($activityStart, 2, 2),
        );
    }
}
