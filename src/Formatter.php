<?php

declare(strict_types=1);

namespace Unit\Information;

/**
 * @package Unit\Information
 */
final class Formatter
{
    public static function stringToValueAndUnit(string $string): array
    {
        preg_match('/^([0-9.]+)([a-zA-Z]+)$/', $string, $matches);
        $value = (float) $matches[1];
        $unit = Mapper::getUnitFromAbbreviation($matches[2]);
        return [$value, $unit];
    }

    /**
     * @param int|float $value
     */
    public static function valueAndUnitToString($value, int $unit, int $precision = null): string
    {
        if (null !== $precision) {
            $value = \number_format((float) $value, $precision, '.', '');
        }
        return $value . Mapper::getAbbreviation($unit);
    }

    /**
     * Note: we do not return KiB, MiB, GiB, TiB and PiB (this is just not implemented)
     *
     * @param int|float $bit
     */
    public static function getIntelligentFormat($bit, int $precision = null): string
    {
        if (8000 > $bit) {
            $unit = Size::BYTE;
        } elseif (8000000 > $bit) {
            $unit = Size::KILOBYTE;
        } elseif (8000000000 > $bit) {
            $unit = Size::MEGABYTE;
        } elseif (8000000000000 > $bit) {
            $unit = Size::GIGABYTE;
        } elseif (8000000000000000 > $bit) {
            $unit = Size::TERABYTE;
        } else {
            $unit = Size::PETABYTE;
        }

        $value = $bit / Mapper::getFactor($unit);

        if (null !== $precision) {
            $value = \number_format((float) $value, $precision, '.', '');
        }

        return self::valueAndUnitToString($value, $unit);
    }
}
