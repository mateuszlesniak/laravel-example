<?php

namespace App\DutyRoster\Dtr\Reader\Plugin\Html;

use App\DutyRoster\Dtr\ActivityEnum;
use App\DutyRoster\Shared\Dto\LocationDto;
use App\DutyRoster\Shared\Dto\RosterDto;
use Symfony\Component\DomCrawler\Crawler;

final class RosterDtoCheckInLocationReaderPlugin extends AbstractReaderPlugin
{
    protected function getSelector(): string
    {
        return '.activitytablerow-fromstn';
    }

    public function fillRosterDto(Crawler $roster, RosterDto $rosterDto): void
    {
        if ($rosterDto->getActivity() !== ActivityEnum::FLIGHT) {
            return;
        }

        $checkInLocation = $this->getValue($roster);

        $rosterDto->setCheckInLocation((new LocationDto())->setCode($checkInLocation));
    }
}
