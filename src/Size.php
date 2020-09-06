<?php

declare(strict_types=1);

namespace Unit\Information;

/**
 * @package Unit\Information
 */
final class Size
{
    const BIT = 1;
    const KILOBIT = 2;
    const MEGABIT = 3;
    const GIGABIT = 4;
    const TERABIT = 5;
    const PETABIT = 6;
    const BYTE = 7;
    const KILOBYTE = 8;
    const MEGABYTE = 9;
    const GIGABYTE = 10;
    const TERABYTE = 11;
    const PETABYTE = 12;
    const KIBIBYTE = 13;
    const MEBIBYTE = 14;
    const GIBIBYTE = 15;
    const TEBIBYTE = 16;
    const PEBIBYTE = 17;

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

        if (!is_string($value)) {
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
