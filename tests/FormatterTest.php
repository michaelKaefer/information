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
use Unit\Information\Formatter;
use Unit\Information\Mapper;
use Unit\Information\Size;

class FormatterTest extends TestCase
{
    /**
     * @dataProvider getBitAndPrecision
     *
     * @param int|float $bit
     */
    public function testCanFormatIntelligently($bit, ?int $precision, string $expectedString)
    {
        $this->assertSame($expectedString, Formatter::getIntelligentFormat($bit, $precision));
    }

    public function getBitAndPrecision(): Generator
    {
        yield [8,       null, '1B'];
        yield [8800000, 1,    '1.1MB'];
        yield [8.1,     1,    '1.0B'];
    }

    /**
     * @dataProvider getStrings
     *
     * @param int|float $expectedValue
     */
    public function testCanTransformIntelligentlyStringToValueAndUnit(
        string $string,
        $expectedValue,
        string $expectedUnitAbbreviation
    ) {
        [$value, $unit] = Formatter::stringToValueAndUnit($string);

        $this->assertSame($expectedValue, $value);
        $this->assertSame($expectedUnitAbbreviation, Mapper::getAbbreviation($unit));
    }

    public function getStrings(): Generator
    {
        yield ['1MB',        1.0,      'MB'];
        yield ['1123.723kB', 1123.723, 'kB'];
    }

    /**
     * @dataProvider getValueAndUnitAbbreviationAndPrecision
     *
     * @param int|float $value
     */
    public function testCanTransformValueAndUnitAbbreviationToString(
        $value,
        int $unitAbbreviation,
        ?int $precision,
        string $expectedString
    ) {
        $this->assertSame($expectedString, Formatter::valueAndUnitToString($value, $unitAbbreviation, $precision));
    }

    public function getValueAndUnitAbbreviationAndPrecision(): Generator
    {
        yield [12,      Size::BIT,      null, '12b'];
        yield [2.64562, Size::TERABYTE, null, '2.64562TB'];
        yield [12,      Size::BIT,      2,    '12.00b'];
        yield [2.64562, Size::TERABYTE, 2,    '2.65TB'];
    }

    /**
     * @dataProvider getCustomFormats
     *
     * @param int|float $value
     */
    public function testCanReturnCustomFormats(
        $value,
        int $unitAbbreviation,
        ?int $precision,
        string $format,
        string $expectedString
    ) {
        $string = Formatter::valueAndUnitToString($value, $unitAbbreviation, $precision, $format);
        $this->assertSame($expectedString, $string);
    }

    public function getCustomFormats(): Generator
    {
        yield [2.64562, Size::TERABYTE, null, '%size% %unit_abbreviation%', '2.64562 TB'];
        yield [2.64562, Size::MEBIBYTE, 1, 'The size of the file is %size% %unit_name% (%unit_abbreviation%).', 'The size of the file is 2.6 Mebibyte (MiB).'];
        yield [2.64562, Size::MEBIBYTE, 0, '%unit_name%%unit_name%', 'MebibyteMebibyte'];
    }
}
