<?php

namespace App\Location;

use App\Models\Location;

interface LocationRepositoryInterface
{
    public function find(string $code): ?Location;

    public function findOrCreateByCode(string $code): Location;
}
