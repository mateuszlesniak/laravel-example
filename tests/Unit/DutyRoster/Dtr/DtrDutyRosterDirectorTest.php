<?php

namespace Tests\Unit\DutyRoster\Dtr;

use App\DutyRoster\Dtr\DtrDutyRosterDirector;
use App\DutyRoster\DutyRosterDirectorInterface;
use App\DutyRoster\DutyRosterReaderInterface;
use App\DutyRoster\DutyRosterWriterInterface;
use App\DutyRoster\Shared\Exception\EmptyDataException;
use ArrayObject;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class DtrDutyRosterDirectorTest extends TestCase
{
    private readonly MockObject $reader;
    private readonly MockObject $writer;
    private readonly DutyRosterDirectorInterface $subject;

    public function testEmptyDataException(): void
    {
        $data = '';
        $this->prepareSubject();

        $this->expectException(EmptyDataException::class);

        $this->subject->loadData($data, 'mimetype');
    }

    public function testWrongMimeType(): void
    {
        $data = 'data';
        $readerMock = $this->createMock(DutyRosterReaderInterface::class);
        $readerMock
            ->expects($this->once())
            ->method('isApplicable')
            ->willReturn(false);
        $this->prepareSubject($readerMock);
        $this->subject->loadData($data, 'mimetype');

        $this->expectException(Exception::class);

        $this->subject->process();
    }

    public function testProcessEmptyWriters(): void
    {
        $data = 'data';
        $readerMock = $this->createMock(DutyRosterReaderInterface::class);
        $readerMock
            ->expects($this->once())
            ->method('isApplicable')
            ->willReturn(true);
        $this->prepareSubject($readerMock);
        $this->subject->loadData($data, 'mimetype');

        $this->expectException(Exception::class);

        $this->subject->process();
    }

    public function testProcess(): void
    {
        $data = 'data';
        $writerMock = $this->createMock(DutyRosterWriterInterface::class);
        $readerMock = $this->createMock(DutyRosterReaderInterface::class);
        $readerMock
            ->expects($this->once())
            ->method('isApplicable')
            ->willReturn(true);
        $this->prepareSubject($readerMock, $writerMock);
        $this->subject->loadData($data, 'mimetype');

        $this->subject->process();
    }

    private function prepareSubject(?MockObject $reader = null, ?MockObject $writer = null): void
    {
        $readers = new ArrayObject();
        if ($reader) {
            $readers->append($reader);
        }

        $writers = new ArrayObject();
        if ($writer) {
            $writers->append($writer);
        }

        $this->subject = new DtrDutyRosterDirector($readers, $writers);
    }
}
