<?php

namespace Tests\Unit\DutyRoster\Dtr\Reader\Plugin\Html;

use App\DutyRoster\Dtr\Reader\Plugin\Html\ReaderPluginInterface;
use App\DutyRoster\Dtr\Reader\Plugin\Html\RosterDtoActivityEndTimeReaderPlugin;
use App\DutyRoster\Dtr\Reader\Plugin\Html\RosterDtoArrivalTimeReaderPlugin;
use App\DutyRoster\Dtr\Reader\Plugin\Html\RosterDtoDepartureTimeReaderPlugin;
use App\DutyRoster\Shared\Dto\RosterDto;
use DateTime;
use InvalidArgumentException;
use Tests\TestCase;


class RosterDtoDepartureTimeReaderPluginTest extends TestCase
{
    private readonly ReaderPluginInterface $subject;

    protected function setUp(): void
    {
        $this->subject = new RosterDtoDepartureTimeReaderPlugin();

        parent::setUp();
    }

    public function testDifferentTypeHours(): void
    {
        $crawler = $this->prepareCrawler('12345');
        $rosterDto = (new RosterDto())->setDeparture(DateTime::createFromFormat('!Y-m-d', '2022-01-01'));

        $this->subject->fillRosterDto($crawler, $rosterDto);

        $this->assertSame('00', $rosterDto->getDeparture()->format('H'));
        $this->assertSame('00', $rosterDto->getDeparture()->format('i'));
    }

    public function testValue(): void
    {
        $crawler = $this->prepareCrawler('1254');
        $rosterDto = (new RosterDto())->setDeparture(new DateTime());

        $this->subject->fillRosterDto($crawler, $rosterDto);

        $this->assertSame('12', $rosterDto->getDeparture()->format('H'));
        $this->assertSame('54', $rosterDto->getDeparture()->format('i'));
    }
}
