<?php

namespace App\Location;

use App\Models\Location;

class LocationRepository implements LocationRepositoryInterface
{
    public function findOrCreateByCode(string $code): Location
    {
        return Location::firstOrCreate(['code' => $code]);
    }
}
