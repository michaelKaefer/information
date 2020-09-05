<?php

declare(strict_types=1);

namespace Unit\Information;

/**
 * @package Unit\Information
 */
final class Mapper
{
    static array $map = [
        Size::BIT        => ['Bit',      Unit::BIT,      1],
        Size::KILOBIT    => ['Kilobit',  Unit::KILOBIT,  1000],
        Size::MEGABIT    => ['Megabit',  Unit::MEGABIT,  1000000],
        Size::GIGABIT    => ['Gigabit',  Unit::GIGABIT,  1000000000],
        Size::TERABIT    => ['Terabit',  Unit::TERABIT,  1000000000000],
        Size::PETABIT    => ['Petabit',  Unit::PETABIT,  1000000000000000],
        Size::BYTE       => ['Byte',     Unit::BYTE,     8],
        Size::KILOBYTE   => ['Kilobyte', Unit::KILOBYTE, 8000],
        Size::MEGABYTE   => ['Megabyte', Unit::MEGABYTE, 8000000],
        Size::GIGABYTE   => ['Gigabyte', Unit::GIGABYTE, 8000000000],
        Size::TERABYTE   => ['Terabyte', Unit::TERABYTE, 8000000000000],
        Size::PETABYTE   => ['Petabyte', Unit::PETABYTE, 8000000000000000],
        Size::KIBIBYTE   => ['Kibibyte', Unit::KIBIBYTE, 8192],
        Size::MEBIBYTE   => ['Mebibyte', Unit::MEBIBYTE, 8388608],
        Size::GIBIBYTE   => ['Gibibyte', Unit::GIBIBYTE, 8589934592],
        Size::TEBIBYTE   => ['Tebibyte', Unit::TEBIBYTE, 8796093022208],
        Size::PEBIBYTE   => ['Pebibyte', Unit::PEBIBYTE, 9007199254740992],
    ];

    public static function getUnitFromAbbreviation(string $abbreviation): int
    {
        foreach (static::$map as $unit => $values) {
            if ($abbreviation === $values[1]) {
                return $unit;
            }
        }
        throw new \InvalidArgumentException('Could not get unit from abbreviation "' . $abbreviation . '".');
    }

    public static function getFactor(int $unit): int
    {
        return static::$map[$unit][2];
    }

    public static function getAbbreviation(int $unit): string
    {
        return static::$map[$unit][1];
    }
}
