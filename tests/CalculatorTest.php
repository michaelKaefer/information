<?php

declare(strict_types=1);

namespace Unit\Information\Tests;

use PHPUnit\Framework\TestCase;
use Unit\Information\Calculator;
use Unit\Information\Size;
use Generator;

class CalculatorTest extends TestCase
{
    private Calculator $calculator;

    public function setUp(): void
    {
        $this->calculator = new Calculator();
    }

    /**
     * @dataProvider getSizesToAdd
     * @param int|float $expectedBits
     */
    public function testCanAdd(Size $a, Size $b, $expectedBits)
    {
        $this->assertEquals($expectedBits, $this->calculator->add($a, $b)->getBits());
    }

    public function getSizesToAdd(): Generator
    {
        yield [new Size(1),   new Size(2), 24];
        yield [new Size(1.3), new Size(2), 26];
    }

    /**
     * @dataProvider getSizesToSubtract
     * @param int|float $expectedBits
     */
    public function testCanSubtract(Size $a, Size $b, $expectedBits)
    {
        $this->assertEquals($expectedBits, $this->calculator->subtract($a, $b)->getBits());
    }

    public function getSizesToSubtract(): Generator
    {
        yield [new Size(2), new Size(1),   8];
        yield [new Size(2), new Size(1.3), 6];
    }

    /**
     * @dataProvider getSizesToMultiply
     * @param int|float $expectedBits
     */
    public function testCanMultiply(Size $a, Size $b, $expectedBits)
    {
        $this->assertEquals($expectedBits, $this->calculator->multiply($a, $b)->getBits());
    }

    public function getSizesToMultiply(): Generator
    {
        yield [new Size(2), new Size(3),   384];
        yield [new Size(2), new Size(1.3), 166];
    }

    /**
     * @dataProvider getSizesToDivide
     * @param int|float $expectedBits
     */
    public function testCanDivide(Size $a, Size $b, $expectedBits)
    {
        $this->assertEquals($expectedBits, $this->calculator->divide($a, $b)->getBits());
    }

    public function getSizesToDivide(): Generator
    {
        yield [new Size(4), new Size(2),   2];
        yield [new Size(2), new Size(1.3), 2];
    }
}
