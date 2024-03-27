<?php

namespace App\DutyRoster\Dtr\Reader\Plugin\Html;

use App\DutyRoster\Dtr\ActivityEnum;
use App\DutyRoster\Shared\Dto\RosterDto;
use Symfony\Component\DomCrawler\Crawler;

final class RosterDtoActivityReaderPlugin extends AbstractReaderPlugin
{
    protected function getSelector(): string
    {
        return '.activitytablerow-activity';
    }

    public function fillRosterDto(Crawler $roster, RosterDto $rosterDto): void
    {
        $activity = $this->getValue($roster);

        $rosterDto->setActivity($this->findActivityEnum($activity));
        $this->fillAdditionalFieldsByActivity($rosterDto, $activity);
    }

    private function findActivityEnum(string $activity): ActivityEnum
    {
        $activityEnum = current(array_filter(ActivityEnum::cases(), function (ActivityEnum $enum) use ($activity) {
            return false !== mb_strpos($activity, $enum->code());
        }));

        return $activityEnum ?: ActivityEnum::UNKNOWN;
    }

    private function fillAdditionalFieldsByActivity(RosterDto $rosterDto, string $activity): void
    {
        switch ($rosterDto->getActivity()) {
            case ActivityEnum::FLIGHT:
                $rosterDto->setFlightNumber(mb_substr($activity, -2));

                break;
        }
    }
}
