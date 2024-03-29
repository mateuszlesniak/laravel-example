<?php

namespace Tests\Unit\DutyRoster\Shared\Dto;

use App\DutyRoster\Shared\Dto\RosterDto;
use App\DutyRoster\Shared\Dto\RosterDtoCollection;
use Tests\TestCase;

class RosterDtoCollectionTest extends TestCase
{
    private readonly RosterDtoCollection $subject;

    protected function setUp(): void
    {
        $this->subject = new RosterDtoCollection();

        parent::setUp();
    }

    public function testCollectionReturnType(): void
    {
        $this->assertSame(RosterDto::class, $this->subject->getType());
    }
}
