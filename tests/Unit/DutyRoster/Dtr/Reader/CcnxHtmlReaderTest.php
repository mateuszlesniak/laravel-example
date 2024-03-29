<?php

namespace Tests\Unit\DutyRoster\Dtr\Reader;

use App\DutyRoster\Dtr\Reader\CcnxHtmlReader;
use App\DutyRoster\Dtr\Reader\Plugin\Html\ReaderPluginInterface;
use App\DutyRoster\DutyRosterReaderInterface;
use App\DutyRoster\Shared\Dto\RosterDto;
use Symfony\Component\DomCrawler\Crawler;
use Tests\TestCase;

class CcnxHtmlReaderTest extends TestCase
{
    private readonly DutyRosterReaderInterface $subject;

    public function testReaderType(): void
    {
        $this->prepareSubject();

        $result = $this->subject->isApplicable(DutyRosterReaderInterface::MIME_TYPE_HTML);

        $this->assertTrue($result);
    }

    public function testReadFile(): void
    {
        $this->prepareSubject();

        $result = $this->subject->read($this->getDtrHtmlRoster());

        $this->assertGreaterThan(0, $result->count());
    }

    public function testCollectionIsFilled(): void
    {
        $this->prepareSubject();

        $result = $this->subject->read($this->getDtrHtmlRoster());
        /** @var RosterDto $first */
        $first = $this->subject->read($this->getDtrHtmlRoster())->first();
        /** @var RosterDto $last */
        $last = $this->subject->read($this->getDtrHtmlRoster())->last();

        $this->assertEquals('2022-01-10', $first->getDay()->format('Y-m-d'));
        $this->assertEquals('2022-01-23', $last->getDay()->format('Y-m-d'));
    }


    public function testReaderUsesPlugins(): void
    {
        $pluginMock = $this->createMock(ReaderPluginInterface::class);
        $pluginMock
            ->method('fillRosterDto')
            ->willReturnCallback(function (Crawler $roster, RosterDto $rosterDto) {
                $rosterDto->setFlightNumber(123);
            });
        $this->prepareSubject($pluginMock);

        $result = $this->subject->read($this->getDtrHtmlRoster());

        foreach ($result as $rosterDto) {
            $this->assertEquals(123, $rosterDto->getFlightNumber());
        }
    }

    private function prepareSubject(ReaderPluginInterface ...$readerPlugin): void
    {
        $this->subject = new CcnxHtmlReader(...$readerPlugin);
    }
}
