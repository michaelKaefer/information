<?php

declare(strict_types=1);

namespace Unit\Information\Tests;

use PHPUnit\Framework\TestCase;
use Unit\Information\Size;

class SizeTest extends TestCase
{
    private Size $size;

    public function setUp(): void
    {
        $this->size = new Size(1);
    }

    public function testCanAdd()
    {
        $this->assertEquals(16, $this->size->add($this->size)->getBits());
    }

    public function testCanSubtract()
    {
        $this->assertEquals(0, $this->size->subtract($this->size)->getBits());
    }

    public function testCanMultiply()
    {
        $this->assertEquals(64, $this->size->multiply($this->size)->getBits());
    }

    public function testCanDivide()
    {
        $this->assertEquals(1, $this->size->divide($this->size)->getBits());
    }
}
