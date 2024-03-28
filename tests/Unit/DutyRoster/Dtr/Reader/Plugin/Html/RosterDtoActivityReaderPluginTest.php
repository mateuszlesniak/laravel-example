<?php

namespace Tests\Unit\DutyRoster\Dtr\Reader\Plugin\Html;

use App\DutyRoster\Dtr\ActivityEnum;
use App\DutyRoster\Dtr\Reader\Plugin\Html\ReaderPluginInterface;
use App\DutyRoster\Dtr\Reader\Plugin\Html\RosterDtoActivityReaderPlugin;
use App\DutyRoster\Shared\Dto\RosterDto;
use Tests\TestCase;


class RosterDtoActivityReaderPluginTest extends TestCase
{
    private readonly ReaderPluginInterface $subject;

    protected function setUp(): void
    {
        $this->subject = new RosterDtoActivityReaderPlugin();

        parent::setUp();
    }

    public function testUnrecognizedActivity(): void
    {
        $crawler = $this->prepareCrawler('XXX');
        $rosterDto = new RosterDto();

        $this->subject->fillRosterDto($crawler, $rosterDto);

        $this->assertNotNull($rosterDto->getActivity());
        $this->assertSame(ActivityEnum::UNKNOWN, $rosterDto->getActivity());
    }

    public function testUnknownActivity(): void
    {
        $crawler = $this->prepareCrawler('UNK');
        $rosterDto = new RosterDto();

        $this->subject->fillRosterDto($crawler, $rosterDto);

        $this->assertNotNull($rosterDto->getActivity());
        $this->assertSame(ActivityEnum::UNKNOWN, $rosterDto->getActivity());
    }

    public function testFlightActivity(): void
    {
        $crawler = $this->prepareCrawler('DX10');
        $rosterDto = new RosterDto();

        $this->subject->fillRosterDto($crawler, $rosterDto);

        $this->assertNotNull($rosterDto->getActivity());
        $this->assertSame(ActivityEnum::FLIGHT, $rosterDto->getActivity());
        $this->assertSame(10, $rosterDto->getFlightNumber());
    }
}
