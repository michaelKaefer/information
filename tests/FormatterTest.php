<?php

namespace Unit\InformationUnit\Tests;

use PHPUnit\Framework\TestCase;
use Unit\InformationUnit\Formatter;
use Unit\InformationUnit\Mapper;
use Unit\InformationUnit\Size;

class MemoryTest extends TestCase
{
    /**
     * @var Size
     */
    protected $size;

    protected function setUp()
    {
        $this->size = new Size(1);
    }

    protected function tearDown()
    {
        $this->size = null;
    }

    public function testStringToValueAndUnit()
    {
        [$value, $unit] = Formatter::stringToValueAndUnit('1MB');
        $this->assertEquals(1, $value);
        $this->assertEquals('MB', Mapper::getAbbreviation($unit));

        [$value, $unit] = Formatter::stringToValueAndUnit('1123.723kB');
        $this->assertEquals(1123.723, $value);
        $this->assertEquals('kB', Mapper::getAbbreviation($unit));
    }

    public function testValueAndUnitToString()
    {
        $this->assertEquals('12b', Formatter::valueAndUnitToString(12, Size::BIT));
        $this->assertEquals('2.65TB', Formatter::valueAndUnitToString(2.64562, Size::TERABYTE, 2));
    }

    public function testGetIntelligentFormat()
    {
        $this->assertEquals('1B', Formatter::getIntelligentFormat(8));
        $this->assertEquals('1.1MB', Formatter::getIntelligentFormat(8800000, 1));
    }
}
