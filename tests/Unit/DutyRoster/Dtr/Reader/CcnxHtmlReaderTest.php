<?php

namespace Tests\Unit\DutyRoster\Dtr\Reader;

use App\DutyRoster\Dtr\Reader\CcnxHtmlReader;
use App\DutyRoster\DutyRosterReaderInterface;
use PHPUnit\Framework\TestCase;

class CcnxHtmlReaderTest extends TestCase
{
    private readonly DutyRosterReaderInterface $subject;

    protected function setUp(): void
    {
        $this->subject = new CcnxHtmlReader();

        parent::setUp();
    }

    public function testReaderType(): void
    {
        $result = $this->subject->isApplicable(DutyRosterReaderInterface::MIME_TYPE_HTML);

        $this->assertTrue($result);
    }

    public function testReadFile(): void
    {
        $result = $this->subject->read($this->getExampleFile());

    }

    private function getExampleFile(): string
    {
        return file_get_contents(__DIR__ . '../../_data/dtr_html_example.html');
    }
}
