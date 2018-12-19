<?php

declare(strict_types=1);

namespace Unit\InformationUnit;

/**
 * Class Formatter
 *
 * @package Unit\InformationUnit
 */
class Formatter
{
    /**
     * @param string $string
     *
     * @return array
     */
    public static function stringToValueAndUnit(string $string): array
    {
        preg_match('/^([0-9.]+)([a-zA-Z]+)$/', $string, $matches);
        $value = (float) $matches[1];
        $unit = Mapper::getUnitFromAbbreviation($matches[2]);
        return [$value, $unit];
    }

    /**
     * @param int|float     $value
     * @param int           $unit
     * @param int|null      $precision
     *
     * @return string
     */
    public static function valueAndUnitToString($value, int $unit, int $precision = null): string
    {
        if (null !== $precision) {
            $value = \number_format((float) $value, $precision, '.', '');
        }
        return $value . Mapper::getAbbreviation($unit);
    }

    /**
     * @param int|float     $bit
     * @param int|null      $precision
     *
     * @return string
     */
    public static function getIntelligentFormat($bit, int $precision = null): string
    {
        if (8000 > $bit) {
            $unit = Size::BYTE;
            $value = $bit / Mapper::getFactor($unit);
        } elseif (8000000 > $bit) {
            $unit = Size::KILOBYTE;
            $value = $bit / Mapper::getFactor($unit);
        } elseif (8000000000 > $bit) {
            $unit = Size::MEGABYTE;
            $value = $bit / Mapper::getFactor($unit);
        } elseif (8000000000000 > $bit) {
            $unit = Size::GIGABYTE;
            $value = $bit / Mapper::getFactor($unit);
        } elseif (8000000000000000 > $bit) {
            $unit = Size::TERABYTE;
            $value = $bit / Mapper::getFactor($unit);
        } else {
            $unit = Size::PETABYTE;
            $value = $bit / Mapper::getFactor($unit);
        }
        if (null !== $precision) {
            $value = \number_format((float) $value, $precision, '.', '');
        }
        return self::valueAndUnitToString($value, $unit);
    }
}
