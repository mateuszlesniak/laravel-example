<?php

namespace App\DutyRoster\Shared\Dto;

class LocationDto
{
    private ?int $id;

    private string $code;

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
}
