<?php

declare(strict_types=1);

/*
 * This file is part of information.
 * (c) Michael Käfer <michael.kaefer1@gmx.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Unit\Information;

final class Size
{
    public const BIT = 1;
    public const KILOBIT = 2;
    public const MEGABIT = 3;
    public const GIGABIT = 4;
    public const TERABIT = 5;
    public const PETABIT = 6;
    public const BYTE = 7;
    public const KILOBYTE = 8;
    public const MEGABYTE = 9;
    public const GIGABYTE = 10;
    public const TERABYTE = 11;
    public const PETABYTE = 12;
    public const KIBIBYTE = 13;
    public const MEBIBYTE = 14;
    public const GIBIBYTE = 15;
    public const TEBIBYTE = 16;
    public const PEBIBYTE = 17;

    /**
     * @var float|int
     */
    private $bits;
    private Mapper $mapper;
    private ?Calculator $calculator = null;

    /**
     * @param int|string $value
     */
    public function __construct($value)
    {
        $this->mapper = new Mapper();

        if (!\is_string($value)) {
            // If the argument is no string it is considered to be a numeric value in Byte.
            $unit = self::BYTE;
        } else {
            [$value, $unit] = Formatter::stringToValueAndUnit($value);
        }

        $this->bits = $value * Mapper::getFactor($unit);
    }

    public static function createFromPhpShorthandValue(string $phpShorthandValue): Size
    {
        return new self(PhpShorthandValueToBytesConverter::convert($phpShorthandValue));
    }

    public function format(string $unitAbbreviation = null, int $precision = null, string $format = null): string
    {
        if (null === $unitAbbreviation) {
            return Formatter::getIntelligentFormat($this->bits, $precision, $format);
        }

        $unit = Mapper::getUnitFromAbbreviation($unitAbbreviation);
        $value = $this->bits / Mapper::getFactor($unit);

        return Formatter::valueAndUnitToString($value, $unit, $precision, $format);
    }

    /**
     * @return float|int
     */
    public function get(string $abbreviation)
    {
        $unit = Mapper::getUnitFromAbbreviation($abbreviation);

        return $this->bits / Mapper::getFactor($unit);
    }

    public function add(Size $size): Size
    {
        return $this->getCalculator()->add($this, $size);
    }

    public function subtract(Size $size): Size
    {
        return $this->getCalculator()->subtract($this, $size);
    }

    public function multiply(Size $size): Size
    {
        return $this->getCalculator()->multiply($this, $size);
    }

    public function divide(Size $size): Size
    {
        return $this->getCalculator()->divide($this, $size);
    }

    /**
     * @return float|int
     */
    public function getBits()
    {
        return $this->bits;
    }

    /**
     * @param float|int $bits
     */
    public function setBits($bits): self
    {
        $this->bits = $bits;

        return $this;
    }

    private function getCalculator(): Calculator
    {
        if (null === $this->calculator) {
            $this->calculator = new Calculator();
        }

        return $this->calculator;
    }
}
