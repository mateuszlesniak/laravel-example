<?php

namespace App\DutyRoster;

interface DutyRosterDirectorInterface
{
    public function loadData(string $data, string $mimeType): void;

    public function process(): void;
}
