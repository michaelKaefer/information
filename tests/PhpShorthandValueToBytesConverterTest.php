<?php

declare(strict_types=1);

/*
 * This file is part of information.
 * (c) Michael Käfer <michael.kaefer1@gmx.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Unit\Information\Tests;

use Generator;
use PHPUnit\Framework\TestCase;
use Unit\Information\InvalidPhpShorthandValueException;
use Unit\Information\PhpShorthandValueToBytesConverter;

class PhpShorthandValueToBytesConverterTest extends TestCase
{
    /**
     * @dataProvider getShorthandValue
     */
    public function testCanFormatIntelligently(string $phpShorthandValue, $expectedBytes)
    {
        $this->assertSame($expectedBytes, PhpShorthandValueToBytesConverter::convert($phpShorthandValue));
    }

    public function getShorthandValue(): Generator
    {
        yield ['1',  1];
        yield ['1M', 1048576];
    }

    public function testThrowsExceptionOnInvalidArgument()
    {
        $this->expectException(InvalidPhpShorthandValueException::class);

        PhpShorthandValueToBytesConverter::convert('-1');
    }
}
