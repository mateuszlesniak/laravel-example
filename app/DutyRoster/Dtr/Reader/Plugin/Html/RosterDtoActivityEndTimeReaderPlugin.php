<?php

namespace App\DutyRoster\Dtr\Reader\Plugin\Html;

use App\DutyRoster\Shared\Dto\RosterDto;
use Symfony\Component\DomCrawler\Crawler;

final class RosterDtoActivityEndTimeReaderPlugin extends AbstractReaderPlugin
{
    protected function getSelector(): string
    {
        return '.activitytablerow-checkoututc';
    }

    public function fillRosterDto(Crawler $roster, RosterDto $rosterDto): void
    {
        $activityEnd = $this->getValue($roster);

        if (empty($activityEnd)) {
            $rosterDto->setActivityEnd(null);

            return;
        }

        $rosterDto->getActivityEnd()->setTime(
            (int) substr($activityEnd, 0, 2),
            (int) substr($activityEnd, 2, 2),
        );
    }
}
