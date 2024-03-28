<?php

namespace App\Location;

use App\Models\Location;

interface LocationRepositoryInterface
{
    public function findOrCreateByCode(string $code): Location;
}
