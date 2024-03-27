<?php

namespace App\DutyRoster\Dtr;

enum ActivityEnum: string
{
    case DAY_OFF = 'DO';
    case STANDBY = 'SBY';
    case FLIGHT = 'FLT';
    case CHECK_IN = 'CI';
    case CHECK_OUT = 'CO';
    case UNKNOWN = 'UNK';

    public function label(): string
    {
        return match ($this) {
            ActivityEnum::DAY_OFF => 'Day off',
            ActivityEnum::STANDBY => 'Standby',
            ActivityEnum::FLIGHT => 'Flight',
            ActivityEnum::CHECK_IN => 'Check in',
            ActivityEnum::CHECK_OUT => 'Check out',
            ActivityEnum::UNKNOWN => 'Unknown',
        };
    }

    public function code(): string
    {
        return match ($this) {
            ActivityEnum::DAY_OFF => 'OFF',
            ActivityEnum::STANDBY => ActivityEnum::STANDBY->value,
            ActivityEnum::FLIGHT => 'DX',
            ActivityEnum::CHECK_IN => ActivityEnum::CHECK_IN->value,
            ActivityEnum::CHECK_OUT => ActivityEnum::CHECK_OUT->value,
            ActivityEnum::UNKNOWN => ActivityEnum::UNKNOWN->value,
        };
    }
}
