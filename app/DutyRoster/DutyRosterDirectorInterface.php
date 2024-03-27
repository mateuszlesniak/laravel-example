<?php

namespace App\DutyRoster;

interface DutyRosterDirectorInterface
{
    public function read(string $content);

    public function transform(array $data);

    public function write(array $data);
}
