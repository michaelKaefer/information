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
use Unit\Information\Calculator;
use Unit\Information\Size;

class CalculatorTest extends TestCase
{
    private Calculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new Calculator();
    }

    /**
     * @dataProvider getSizesToAdd
     *
     * @param int|float $expectedBits
     */
    public function testCanAdd(Size $a, Size $b, $expectedBits)
    {
        $this->assertSame($expectedBits, $this->calculator->add($a, $b)->getBits());
    }

    public function getSizesToAdd(): Generator
    {
        yield [new Size(1),   new Size(2), 24.0];
        yield [new Size(1.3), new Size(2), 26.0];
    }

    /**
     * @dataProvider getSizesToSubtract
     *
     * @param int|float $expectedBits
     */
    public function testCanSubtract(Size $a, Size $b, $expectedBits)
    {
        $this->assertSame($expectedBits, $this->calculator->subtract($a, $b)->getBits());
    }

    public function getSizesToSubtract(): Generator
    {
        yield [new Size(2), new Size(1),   8.0];
        yield [new Size(2), new Size(1.3), 6.0];
    }

    /**
     * @dataProvider getSizesToMultiply
     *
     * @param int|float $expectedBits
     */
    public function testCanMultiply(Size $a, Size $b, $expectedBits)
    {
        $this->assertSame($expectedBits, $this->calculator->multiply($a, $b)->getBits());
    }

    public function getSizesToMultiply(): Generator
    {
        yield [new Size(2), new Size(3),   384.0];
        yield [new Size(2), new Size(1.3), 166.0];
    }

    /**
     * @dataProvider getSizesToDivide
     *
     * @param int|float $expectedBits
     */
    public function testCanDivide(Size $a, Size $b, $expectedBits)
    {
        $this->assertSame($expectedBits, $this->calculator->divide($a, $b)->getBits());
    }

    public function getSizesToDivide(): Generator
    {
        yield [new Size(4), new Size(2),   2.0];
        yield [new Size(2), new Size(1.3), 2.0];
    }
}
