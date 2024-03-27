<?php

namespace App\DutyRoster\Dtr\Reader\Plugin\Html;

use App\DutyRoster\Dtr\ActivityEnum;
use App\DutyRoster\Shared\Dto\LocationDto;
use App\DutyRoster\Shared\Dto\RosterDto;
use Symfony\Component\DomCrawler\Crawler;

final class RosterDtoCheckOutLocationReaderPlugin extends AbstractReaderPlugin
{
    protected function getSelector(): string
    {
        return '.activitytablerow-tostn';
    }

    public function fillRosterDto(Crawler $roster, RosterDto $rosterDto): void
    {
        if ($rosterDto->getActivity() !== ActivityEnum::FLIGHT) {
            return;
        }

        $checkOutLocation = $this->getValue($roster);

        $rosterDto->setCheckOutLocation((new LocationDto())->setCode($checkOutLocation));
    }
}
