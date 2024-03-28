<?php

namespace Tests\Unit\DutyRoster\Dtr\Reader\Plugin\Html;

use App\DutyRoster\Dtr\Reader\Plugin\Html\ReaderPluginInterface;
use App\DutyRoster\Dtr\Reader\Plugin\Html\RosterDtoActivityEndTimeReaderPlugin;
use App\DutyRoster\Shared\Dto\RosterDto;
use DateTime;
use Tests\TestCase;


class RosterDtoActivityEndTimeReaderPluginTest extends TestCase
{
    private readonly ReaderPluginInterface $subject;

    protected function setUp(): void
    {
        $this->subject = new RosterDtoActivityEndTimeReaderPlugin();

        parent::setUp();
    }

    public function testEmptyValue(): void
    {
        $crawler = $this->prepareCrawler();
        $rosterDto = new RosterDto();

        $this->subject->fillRosterDto($crawler, $rosterDto);

        $this->assertNull($rosterDto->getActivityEnd());
    }

    public function testNotEmptyValue(): void
    {
        $crawler = $this->prepareCrawler('1254');
        $rosterDto = (new RosterDto())->setActivityEnd(new DateTime());

        $this->subject->fillRosterDto($crawler, $rosterDto);

        $this->assertSame('12', $rosterDto->getActivityEnd()->format('H'));
        $this->assertSame('54', $rosterDto->getActivityEnd()->format('i'));
    }
}
