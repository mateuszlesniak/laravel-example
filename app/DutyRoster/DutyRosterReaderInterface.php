<?php

namespace App\DutyRoster;

interface DutyRosterReaderInterface
{
    public const MIME_TYPE_HTML = 'text/html';

    public function isApplicable(string $mimeType): bool;

    public function read(string $fileContent);
}
