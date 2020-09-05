<?php

declare(strict_types=1);

namespace Unit\Information\Tests;

use PHPUnit\Framework\TestCase;
use Unit\Information\InvalidPhpShorthandValueException;
use Unit\Information\PhpShorthandValueToBytesConverter;
use Generator;

class PhpShorthandValueToBytesConverterTest extends TestCase
{
    /**
     * @dataProvider getShorthandValue
     */
    public function testCanFormatIntelligently(string $phpShorthandValue, $expectedBytes)
    {
        $this->assertEquals($expectedBytes, PhpShorthandValueToBytesConverter::convert($phpShorthandValue));
    }

    public function getShorthandValue(): Generator
    {
        yield ['1',  1      ];
        yield ['1M', 1048576];
    }

    public function testThrowsExceptionOnInvalidArgument()
    {
        $this->expectException(InvalidPhpShorthandValueException::class);

        PhpShorthandValueToBytesConverter::convert('-1');
    }
}
