<?php

declare(strict_types=1);

namespace Unit\Information;

use InvalidArgumentException;
use Throwable;

final class InvalidPhpShorthandValueException extends InvalidArgumentException
{
    public function __construct($message = 'The PHP shorthand value "-1" cannot be converted to a meaningful size.', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
