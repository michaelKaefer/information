<?php

declare(strict_types=1);

/*
 * This file is part of information.
 * (c) Michael Käfer <michael.kaefer1@gmx.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Unit\Information\Tests;

use PHPUnit\Framework\TestCase;
use Unit\Information\Size;

class SizeTest extends TestCase
{
    private Size $size;

    protected function setUp(): void
    {
        $this->size = new Size(1);
    }

    public function testCanAdd()
    {
        $this->assertSame(16.0, $this->size->add($this->size)->getBits());
    }

    public function testCanSubtract()
    {
        $this->assertSame(0.0, $this->size->subtract($this->size)->getBits());
    }

    public function testCanMultiply()
    {
        $this->assertSame(64.0, $this->size->multiply($this->size)->getBits());
    }

    public function testCanDivide()
    {
        $this->assertSame(1.0, $this->size->divide($this->size)->getBits());
    }
}
