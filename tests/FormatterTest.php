<?php

declare(strict_types=1);

namespace Unit\Information\Tests;

use PHPUnit\Framework\TestCase;
use Unit\Information\Formatter;
use Unit\Information\Mapper;
use Unit\Information\Size;
use Generator;

class FormatterTest extends TestCase
{
    /**
     * @dataProvider getBitAndPrecision
     */
    public function testCanFormatIntelligently(int $bit, ?int $precision, string $expectedString)
    {
        $this->assertEquals($expectedString, Formatter::getIntelligentFormat($bit, $precision));
    }

    public function getBitAndPrecision(): Generator
    {
        yield [8,       null, '1B'   ];
        yield [8800000, 1,    '1.1MB'];
        yield [8.8,     1,    '1.0B' ];
    }

    /**
     * @dataProvider getStrings
     * @param int|float $expectedValue
     */
    public function testCanTransformIntelligentlyStringToValueAndUnit(
        string $string,
        $expectedValue,
        string $expectedUnitAbbreviation
    )
    {
        [$value, $unit] = Formatter::stringToValueAndUnit($string);

        $this->assertEquals($expectedValue, $value);
        $this->assertEquals($expectedUnitAbbreviation, Mapper::getAbbreviation($unit));
    }

    public function getStrings(): Generator
    {
        yield ['1MB',        1,        'MB'];
        yield ['1123.723kB', 1123.723, 'kB'];
    }

    /**
     * @dataProvider getValueAndUnitAbbreviationAndPrecision
     * @param int|float $value
     */
    public function testCanTransformValueAndUnitAbbreviationToString(
        $value,
        int $unitAbbreviation,
        ?int $precision,
        string $expectedString
    )
    {
        $this->assertEquals($expectedString, Formatter::valueAndUnitToString($value, $unitAbbreviation, $precision));
    }

    public function getValueAndUnitAbbreviationAndPrecision(): Generator
    {
        yield [12,      Size::BIT,      null, '12b'      ];
        yield [2.64562, Size::TERABYTE, null, '2.64562TB'];
        yield [12,      Size::BIT,      2,    '12.00b'   ];
        yield [2.64562, Size::TERABYTE, 2,    '2.65TB'   ];
    }
}
