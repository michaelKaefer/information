<?php

declare(strict_types=1);

namespace Unit\Information;

/**
 * @package Unit\Information
 */
final class Formatter
{
    const SIZE = '%size%';
    const UNIT_NAME = '%unit_name%';
    const UNIT_ABBREVIATION = '%unit_abbreviation%';
    const DEFAULT_FORMAT = '%size%%unit_abbreviation%';

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
    public static function valueAndUnitToString($value, int $unit, int $precision = null, string $format = null): string
    {
        if (null !== $precision) {
            $value = \number_format((float) $value, $precision, '.', '');
        }
        if (null === $format) {
            $format = self::DEFAULT_FORMAT;
        }
        return \preg_replace(
            '/%size%/',
            (string) $value,
            \preg_replace(
                '/%unit_name%/',
                (string) Mapper::getName($unit),
                \preg_replace(
                    '/%unit_abbreviation%/',
                    (string) Mapper::getAbbreviation($unit),
                    $format
                )
            )
        );
    }

    /**
     * Note: we do not return b, kb, Mb, Gb, Tb, Pb, KiB, MiB, GiB, TiB and PiB (this is just not implemented)
     *
     * @param int|float $bit
     */
    public static function getIntelligentFormat($bit, int $precision = null, string $format = null): string
    {
        $unit = self::findBestUnit($bit);
        $value = $bit / Mapper::getFactor($unit);

        if (null !== $precision) {
            $value = \number_format((float) $value, $precision, '.', '');
        }

        return self::valueAndUnitToString($value, $unit, null, $format);
    }

    private static function findBestUnit($bit): int
    {
        if (8000 > $bit) {
            return Size::BYTE;
        }
        if (8000000 > $bit) {
            return Size::KILOBYTE;
        }
        if (8000000000 > $bit) {
            return Size::MEGABYTE;
        }
        if (8000000000000 > $bit) {
            return Size::GIGABYTE;
        }
        if (8000000000000000 > $bit) {
            return Size::TERABYTE;
        }
        return Size::PETABYTE;
    }
}
