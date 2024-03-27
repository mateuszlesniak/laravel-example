<?php

namespace App\DutyRoster\Dtr\Reader;

use App\DutyRoster\Dtr\Reader\Plugin\Html\ReaderPluginInterface;
use App\DutyRoster\DutyRosterReaderInterface;
use App\DutyRoster\Shared\Dto\RosterDto;
use App\DutyRoster\Shared\Dto\RosterDtoCollection;
use DateTime;
use Symfony\Component\DomCrawler\Crawler;

final class CcnxHtmlReader implements DutyRosterReaderInterface
{
    private const DATE_RANGE_SEPARATOR = '|';
    private const DATE_RANGE_DATE_FORMAT = '!Y-m-d';

    /**
     * @var array|DateTime[]
     */
    private array $period;

    /**
     * @var ReaderPluginInterface[]
     */
    private readonly array $readerPlugins;

    public function __construct(
        ReaderPluginInterface ...$readerPlugins,
    )
    {
        $this->readerPlugins = $readerPlugins;
    }

    public function isApplicable(string $mimeType): bool
    {
        return $mimeType === DutyRosterReaderInterface::MIME_TYPE_HTML;
    }

    public function read(string $fileContent): RosterDtoCollection
    {
        $crawler = new Crawler($fileContent);
        $this->readDateRanges($crawler);

        return $this->extractActivityCollection($crawler);
    }

    private function readDateRanges(Crawler $crawler): void
    {
        $dateRange = $crawler
            ->filter('select#ctl00_Main_periodSelect')->first()
            ->filter('option[selected]')->first()->attr('value');

        $dateRangeArray = explode(self::DATE_RANGE_SEPARATOR, $dateRange);

        $startPeriod = DateTime::createFromFormat(self::DATE_RANGE_DATE_FORMAT, $dateRangeArray[0]);
        $endPeriod = DateTime::createFromFormat(self::DATE_RANGE_DATE_FORMAT, $dateRangeArray[1]);

        do {
            $this->period[] = $startPeriod;

            $startPeriod = (clone $startPeriod)->modify('+1 day');

        } while ($startPeriod <= $endPeriod);
    }

    private function extractActivityCollection(Crawler $crawler): RosterDtoCollection
    {
        $collection = new RosterDtoCollection();

        $table = $crawler->filter('table#ctl00_Main_activityGrid')->first();

        $table->filter('tr')->each(function (Crawler $row, int $index) use ($collection) {
            if ($index === 0) {
                return;
            }

            $roster = $row->filter('td');

            $day = $this->resolveDate($roster, $collection);

            $rosterDto = (new RosterDto())
                ->setDay($day)
                ->setActivityStart(clone $day)
                ->setActivityEnd(clone $day)
                ->setDeparture(clone $day)
                ->setArrival(clone $day);

            foreach ($this->readerPlugins as $readerPlugin) {
                $readerPlugin->fillRosterDto($roster, $rosterDto);
            }

            $collection->add($rosterDto);
        });

        return $collection;
    }

    private function resolveDate(Crawler $roster, RosterDtoCollection $rosterDtoCollection): DateTime
    {
        $cellDate = $roster->filter('.activitytablerow-date')->first()?->text();

        if (!$cellDate) {
            /** @var RosterDto $lastRosterDto */
            $lastRosterDto = $rosterDtoCollection->last();
            return $lastRosterDto->getDay();
        }

        foreach ($this->period as $date) {
            if ($date->format('D d') === $cellDate) {
                return $date;
            }
        }
    }
}
