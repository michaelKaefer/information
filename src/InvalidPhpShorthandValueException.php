<?php

declare(strict_types=1);

/*
 * This file is part of information.
 * (c) Michael Käfer <michael.kaefer1@gmx.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
