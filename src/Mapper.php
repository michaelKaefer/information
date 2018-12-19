<?php

declare(strict_types=1);

namespace Unit\InformationUnit;

/**
 * Class Mapper
 *
 * @package Unit\InformationUnit
 */
class Mapper
{
    /**
     * @var array
     */
    static $map = [
        Size::BIT        => ['Bit',      'b',    1],
        Size::KILOBIT    => ['Kilobit',  'kb',   1000],
        Size::MEGABIT    => ['Megabit',  'Mb',   1000000],
        Size::GIGABIT    => ['Gigabit',  'Gb',   1000000000],
        Size::TERABIT    => ['Terabit',  'Tb',   1000000000000],
        Size::PETABIT    => ['Petabit',  'Pb',   1000000000000000],
        Size::BYTE       => ['Byte',     'B',    8],
        Size::KILOBYTE   => ['Kilobyte', 'kB',   8000],
        Size::MEGABYTE   => ['Megabyte', 'MB',   8000000],
        Size::GIGABYTE   => ['Gigabyte', 'GB',   8000000000],
        Size::TERABYTE   => ['Terabyte', 'TB',   8000000000000],
        Size::PETABYTE   => ['Petabyte', 'PB',   8000000000000000],
    ];

    /**
     * @param string $abbreviation
     *
     * @return int
     */
    public static function getUnitFromAbbreviation(string $abbreviation): int
    {
        foreach (static::$map as $unit => $values) {
            if ($abbreviation === $values[1]) {
                return $unit;
            }
        }
        throw new \InvalidArgumentException('Could not get unit from abbreviation "' . $abbreviation . '".');
    }

    /**
     * @param int $unit
     *
     * @return int
     */
    public static function getFactor(int $unit): int
    {
        return static::$map[$unit][2];
    }

    /**
     * @param int $unit
     *
     * @return string
     */
    public static function getAbbreviation(int $unit): string
    {
        return static::$map[$unit][1];
    }
}
