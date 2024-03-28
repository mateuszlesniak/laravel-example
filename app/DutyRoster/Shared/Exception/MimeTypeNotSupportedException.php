<?php

namespace App\DutyRoster\Shared\Exception;

use Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

class MimeTypeNotSupportedException extends Exception
{
    #[Pure]
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Mime type not supported.', $code, $previous);
    }
}
