<?php

namespace Tests\Unit\DutyRoster\Dtr\Reader\Plugin\Html;

use App\DutyRoster\Dtr\Reader\Plugin\Html\ReaderPluginInterface;
use App\DutyRoster\Dtr\Reader\Plugin\Html\RosterDtoActivityStartTimeReaderPlugin;
use App\DutyRoster\Shared\Dto\RosterDto;
use DateTime;
use Tests\TestCase;


class RosterDtoActivityStartTimeReaderPluginTest extends TestCase
{
    private readonly ReaderPluginInterface $subject;

    protected function setUp(): void
    {
        $this->subject = new RosterDtoActivityStartTimeReaderPlugin();

        parent::setUp();
    }

    public function testEmptyValue(): void
    {
        $crawler = $this->prepareCrawler();
        $rosterDto = new RosterDto();

        $this->subject->fillRosterDto($crawler, $rosterDto);

        $this->assertNull($rosterDto->getActivityStart());
    }

    public function testNotEmptyValue(): void
    {
        $crawler = $this->prepareCrawler('1254');
        $rosterDto = (new RosterDto())->setActivityStart(new DateTime());

        $this->subject->fillRosterDto($crawler, $rosterDto);

        $this->assertSame('12', $rosterDto->getActivityStart()->format('H'));
        $this->assertSame('54', $rosterDto->getActivityStart()->format('i'));
    }
}
