<?php

declare(strict_types=1);

namespace Unit\Information;

/**
 * Class Size
 *
 * @package Unit\Information
 */
class Size
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

    /**
     * @var int
     */
    private $bit;

    /**
     * Size constructor.
     *
     * @param $value
     */
    public function __construct($value)
    {
        $this->mapper = new Mapper();

        if (!is_string($value)) {
            // if the argument is no string it is considered to be a numeric value in Byte
            $unit = self::BYTE;
        } else {
            [$value, $unit] = Formatter::stringToValueAndUnit($value);
        }

        $this->bit = $value * Mapper::getFactor($unit);
    }

    /**
     * @param Size $size
     *
     * @return Size
     */
    public function add(Size $size): Size
    {
        $this->bit = $this->bit + $size->get('b');
        return $this;
    }

    /**
     * @param Size $size
     *
     * @return Size
     */
    public function subtract(Size $size): Size
    {
        $result = $this->bit - $size->get('b');

        if (0 > $result) {
            throw new \OutOfBoundsException('Could not subtract, the result would be less than 0.');
        }

        $this->bit = $result;

        return $this;
    }

    /**
     * @param Size $size
     *
     * @return Size
     */
    public function multiply(Size $size): Size
    {
        $this->bit = $this->bit * $size->get('b');
        return $this;
    }

    /**
     * @param Size $size
     *
     * @return Size
     */
    public function divide(Size $size): Size
    {
        if (0 === $size->get('b')) {
            throw new \OutOfBoundsException('Could not divide by zero.');
        }

        $this->bit = \ceil($this->bit / $size->get('b'));

        return $this;
    }

    /**
     * @param string|null $format
     * @param int|null $precision
     *
     * @return string
     */
    public function format(string $format = null, int $precision = null)
    {
        if (null === $format) {
            return Formatter::getIntelligentFormat($this->bit, $precision);
        }

        $unit = Mapper::getUnitFromAbbreviation($format);
        $value = $this->bit / Mapper::getFactor($unit);

        return Formatter::valueAndUnitToString($value, $unit, $precision);
    }

    /**
     * @param string $abbreviation
     *
     * @return float|int
     */
    public function get(string $abbreviation)
    {
        $unit = Mapper::getUnitFromAbbreviation($abbreviation);
        return $this->bit / Mapper::getFactor($unit);
    }
}
