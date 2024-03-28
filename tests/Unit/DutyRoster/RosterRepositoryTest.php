<?php

namespace Tests\Unit\DutyRoster;

use App\DutyRoster\Dtr\ActivityEnum;
use App\DutyRoster\Repository\RosterRepository;
use App\DutyRoster\Repository\RosterRepositoryInterface;
use App\DutyRoster\Shared\Dto\LocationDto;
use App\DutyRoster\Shared\Dto\RosterDto;
use App\Location\LocationRepositoryInterface;
use App\Models\Location;
use App\Models\Roster;
use DateTime;
use Illuminate\Support\Facades\Date;
use Tests\TestCase;


class RosterRepositoryTest extends TestCase
{
    private readonly LocationRepositoryInterface $locationRepository;
    private readonly RosterRepositoryInterface $subject;

    protected function setUp(): void
    {
        $this->locationRepository = $this->createMock(LocationRepositoryInterface::class);
        $this->subject = new RosterRepository($this->locationRepository);

        parent::setUp();
    }

    protected function tearDown(): void
    {
        Roster::where('1', '=', '1')->delete();
        Location::where('1', '=', '1')->delete();
    }


    public function testPersistRosterDtoSuccessfully(): void
    {
        $locationDto = (new LocationDto())
            ->setId(1)
            ->setCode('TES');

        $rosterDto = (new RosterDto())
            ->setDay(new DateTime())
            ->setActivity(ActivityEnum::UNKNOWN)
            ->setDeparture(new DateTime())
            ->setArrival(new DateTime())
            ->setCheckInLocation($locationDto)
            ->setCheckOutLocation($locationDto);

        $this->subject->persistRosterDto($rosterDto);

        $this->assertNotNull($rosterDto->getId());
    }

    public function testPersistRosterDtoSuccessfullyWithDependencies(): void
    {
        $locationDto = (new LocationDto())
            ->setCode('TES');
        $location = new Location(['code' => 'TES']);
        $location->id = 1;

        $rosterDto = (new RosterDto())
            ->setDay(new DateTime())
            ->setActivity(ActivityEnum::UNKNOWN)
            ->setDeparture(new DateTime())
            ->setArrival(new DateTime())
            ->setCheckInLocation($locationDto)
            ->setCheckOutLocation(clone $locationDto);

        $this->locationRepository
            ->expects($this->exactly(2))
            ->method('findOrCreateByCode')
            ->with($locationDto->getCode())
            ->willReturn($location);

        $this->subject->persistRosterDto($rosterDto);

        $this->assertNotNull($rosterDto->getId());
        $this->assertSame(1, $rosterDto->getCheckInLocation()->getId());
        $this->assertSame(1, $rosterDto->getCheckOutLocation()->getId());
    }

    public function testFindByCriteriaWithoutParameters(): void
    {
        $collection = $this->subject->findByCriteria();

        $this->assertEmpty($collection);
    }

    public function testFindByCriteriaWithParameters(): void
    {
        $startDate = new DateTime();
        $roster1 = $this->createRoster($startDate);
        $roster2 = $this->createRoster((clone $startDate)->modify('+1 day'));
        $location = Location::create(['code' => 'TES']);

        $collection = $this->subject->findByCriteria(
            $startDate,
        );

        $this->assertNotEmpty($collection);
        $this->assertCount(2, $collection);
    }

    public function testFindByCriteriaWithParametersAndPartialResult(): void
    {
        $startDate = new DateTime();
        $endDate = (new DateTime())->modify('+1 day');
        $location = Location::create(['code' => 'TES']);
        $roster1 = $this->createRoster($startDate, $location);
        $roster2 = $this->createRoster($endDate, $location);

        $collection = $this->subject->findByCriteria(
            $endDate,
            (clone $endDate)->modify('+1 day'),
            ActivityEnum::UNKNOWN,
            $location
        );

        $this->assertNotEmpty($collection);
        $this->assertCount(1, $collection);
    }

    private function createRoster(DateTime $dateTime, ?Location $location = null): Roster
    {
        return Roster::create([
            'day' => $dateTime,
            'activity_code' => ActivityEnum::UNKNOWN,
            'flight_number' => rand(10, 1000),
            'activity_start' => clone $dateTime,
            'activity_end' => (clone $dateTime)->modify('+1 hour'),
            'departure' => (clone $dateTime)->modify('+10 minutes'),
            'arrival' => (clone $dateTime)->modify('+50 minutes'),
            'check_in_location_id' => $location ? $location->id : rand(100, 1000),
            'check_out_location_id' => $location ? $location->id : rand(100, 1000),
        ]);
    }

}
