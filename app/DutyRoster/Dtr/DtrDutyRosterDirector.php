<?php

namespace App\DutyRoster\Dtr;

use App\DutyRoster\DutyRosterDirectorInterface;

class DtrDutyRosterDirector implements DutyRosterDirectorInterface
{

    public function __construct(
        private readonly array
    )
    {
    }

    public function read(string $content)
    {
        // TODO: Implement read() method.
    }

    public function transform(array $data)
    {
        // TODO: Implement transform() method.
    }

    public function write(array $data)
    {
        // TODO: Implement write() method.
    }

}
