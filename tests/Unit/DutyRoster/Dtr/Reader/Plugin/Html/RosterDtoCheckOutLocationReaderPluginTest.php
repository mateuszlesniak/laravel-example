<?php

namespace Tests\Unit\DutyRoster\Dtr\Reader\Plugin\Html;

use App\DutyRoster\Dtr\Reader\Plugin\Html\ReaderPluginInterface;
use App\DutyRoster\Dtr\Reader\Plugin\Html\RosterDtoCheckOutLocationReaderPlugin;
use App\DutyRoster\Shared\Dto\LocationDto;
use App\DutyRoster\Shared\Dto\RosterDto;
use InvalidArgumentException;
use Tests\TestCase;


class RosterDtoCheckOutLocationReaderPluginTest extends TestCase
{
    private readonly ReaderPluginInterface $subject;

    protected function setUp(): void
    {
        $this->subject = new RosterDtoCheckOutLocationReaderPlugin();

        parent::setUp();
    }

    public function testWrongValue(): void
    {
        $crawler = $this->prepareCrawler('1234');
        $rosterDto = new RosterDto();

        $this->expectException(InvalidArgumentException::class);

        $this->subject->fillRosterDto($crawler, $rosterDto);
    }

    public function testNotEmptyValue(): void
    {
        $crawler = $this->prepareCrawler('COD');
        $rosterDto = new RosterDto();

        $this->subject->fillRosterDto($crawler, $rosterDto);

        $this->assertInstanceOf(LocationDto::class, $rosterDto->getCheckOutLocation());
        $this->assertSame('COD', $rosterDto->getCheckOutLocation()->getCode());
    }
}
