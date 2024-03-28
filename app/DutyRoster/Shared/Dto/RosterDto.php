<?php

namespace App\DutyRoster\Shared\Dto;

use App\DutyRoster\Dtr\ActivityEnum;
use DateTime;

class RosterDto
{
    private ?int $id;

    private DateTime $day;
    private ActivityEnum $activity;
    private ?int $flightNumber;

    private ?DateTime $activityStart;
    private ?DateTime $activityEnd;

    private DateTime $departure;
    private DateTime $arrival;

    private LocationDto $checkInLocation;
    private LocationDto $checkOutLocation;

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setActivity(ActivityEnum $activity): self
    {
        $this->activity = $activity;

        return $this;
    }

    public function setFlightNumber(?int $flightNumber): self
    {
        $this->flightNumber = $flightNumber;

        return $this;
    }

    public function setDay(DateTime $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function setActivityStart(?DateTime $activityStart): self
    {
        $this->activityStart = $activityStart;

        return $this;
    }

    public function setActivityEnd(?DateTime $activityEnd): self
    {
        $this->activityEnd = $activityEnd;

        return $this;
    }

    public function setDeparture(DateTime $departure): self
    {
        $this->departure = $departure;

        return $this;
    }

    public function setArrival(DateTime $arrival): self
    {
        $this->arrival = $arrival;

        return $this;
    }

    public function setCheckInLocation(LocationDto $checkInLocation): self
    {
        $this->checkInLocation = $checkInLocation;

        return $this;
    }

    public function setCheckOutLocation(LocationDto $checkOutLocation): self
    {
        $this->checkOutLocation = $checkOutLocation;

        return $this;
    }

    public function getActivity(): ActivityEnum
    {
        return $this->activity;
    }

    public function getFlightNumber(): ?int
    {
        return $this->flightNumber;
    }

    public function getDay(): DateTime
    {
        return $this->day;
    }

    public function getActivityStart(): ?DateTime
    {
        return $this->activityStart;
    }

    public function getActivityEnd(): ?DateTime
    {
        return $this->activityEnd;
    }

    public function getDeparture(): DateTime
    {
        return $this->departure;
    }

    public function getArrival(): DateTime
    {
        return $this->arrival;
    }

    public function getCheckInLocation(): LocationDto
    {
        return $this->checkInLocation;
    }

    public function getCheckOutLocation(): LocationDto
    {
        return $this->checkOutLocation;
    }
}
