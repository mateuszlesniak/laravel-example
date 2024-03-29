<?php

namespace Tests\Unit\DutyRoster\Dtr\Reader\Writer;

use App\DutyRoster\Dtr\Writer\DtrDutyRosterWriter;
use App\DutyRoster\DutyRosterWriterInterface;
use App\DutyRoster\Repository\RosterRepositoryInterface;
use App\DutyRoster\Shared\Dto\RosterDto;
use App\DutyRoster\Shared\Dto\RosterDtoCollection;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;


class DtrDutyRosterWriterTest extends TestCase
{
    private MockObject $repositoryMock;
    private readonly DutyRosterWriterInterface $subject;

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(RosterRepositoryInterface::class);
        $this->subject = new DtrDutyRosterWriter($this->repositoryMock);

        parent::setUp();
    }

    public function testWriteEmptyCollection(): void
    {
        $dtoCollection = new RosterDtoCollection();

        $this->repositoryMock
            ->expects($this->never())
            ->method('persistRosterDto');

        $this->subject->write($dtoCollection);
    }

    public function testWriteCollection(): void
    {
        $dtoCollection = new RosterDtoCollection();
        $dtoCollection->add(new RosterDto());
        $dtoCollection->add(new RosterDto());

        $this->repositoryMock
            ->expects($this->exactly(2))
            ->method('persistRosterDto');

        $this->subject->write($dtoCollection);
    }
}
