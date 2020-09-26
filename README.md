# information
Package for calculating and formatting information units like Bit, Byte, Kilobit, Kilobyte, Megabit, Megabyte, etc.

[![Total Downloads](https://poser.pugx.org/unit/information/downloads)](//packagist.org/packages/unit/information)
[![Version](https://poser.pugx.org/unit/information/version)](//packagist.org/packages/unit/information)

## Installation
```console
user@machine:~$ composer require unit/information
```

## Units
The used units follow the IEC standard.

| Name                                               | Abbreviation | In Bit           | In Byte          | Constant to use                  |
| -------------------------------------------------- |:------------:| ----------------:| ----------------:| --------------------------------:|
| [Bit](https://en.wikipedia.org/wiki/Bit)           | b            | 1                | 0.125            | Unit\Information\Unit::BIT       |
| [Kilobit](https://en.wikipedia.org/wiki/Kilobit)   | kb           | 1000             | 125              | Unit\Information\Unit::KILOBIT   |
| [Megabit](https://en.wikipedia.org/wiki/Megabit)   | Mb           | 1000000          | 125000           | Unit\Information\Unit::MEGABIT   |
| [Gigabit](https://en.wikipedia.org/wiki/Gigabit)   | Gb           | 1000000000       | 125000000        | Unit\Information\Unit::GIGABIT   |
| [Terabit](https://en.wikipedia.org/wiki/Terabit)   | Tb           | 1000000000000    | 125000000000     | Unit\Information\Unit::TERABIT   |
| [Petabit](https://en.wikipedia.org/wiki/Petabit)   | Pb           | 1000000000000000 | 125000000000000  | Unit\Information\Unit::PETABIT   |
| [Byte](https://en.wikipedia.org/wiki/Byte)         | B            | 8                | 1                | Unit\Information\Unit::BYTE      |
| [Kilobyte](https://en.wikipedia.org/wiki/Kilobyte) | kB           | 8000             | 1000             | Unit\Information\Unit::KILOBYTE  |
| [Megabyte](https://en.wikipedia.org/wiki/Megabyte) | MB           | 8000000          | 1000000          | Unit\Information\Unit::MEGABYTE  |
| [Gigabyte](https://en.wikipedia.org/wiki/Gigabyte) | GB           | 8000000000       | 1000000000       | Unit\Information\Unit::GIGABYTE  |
| [Terabyte](https://en.wikipedia.org/wiki/Terabyte) | TB           | 8000000000000    | 1000000000000    | Unit\Information\Unit::TERABYTE  |
| [Petabyte](https://en.wikipedia.org/wiki/Petabyte) | PB           | 8000000000000000 | 1000000000000000 | Unit\Information\Unit::PETABYTE  |
| [Kibibyte](https://en.wikipedia.org/wiki/Kibibyte) | KiB          | 8192             | 1024             | Unit\Information\Unit::KIBIBYTE  |
| [Mebibyte](https://en.wikipedia.org/wiki/Mebibyte) | MiB          | 8388608          | 1048576          | Unit\Information\Unit::MEBIBYTE  |
| [Gigabyte](https://en.wikipedia.org/wiki/Gibibyte) | GiB          | 8589934592       | 1073741824       | Unit\Information\Unit::GIBIBYTE  |
| [Terabyte](https://en.wikipedia.org/wiki/Tebibyte) | TiB          | 8796093022208    | 1099511627776    | Unit\Information\Unit::TEBIBYTE  |
| [Pebibyte](https://en.wikipedia.org/wiki/Pebibyte) | PiB          | 9007199254740992 | 1125899906842624 | Unit\Information\Unit::PEBIBYTE  |

## Usage
Intelligent formatting:
```php
use Unit\Information\Size;

// Format 1 Byte
(new Size(1))->format(); // "1B"

// Format Byte values
(new Size(4300000))->format();     // "4.3MB"
(new Size(73042346800))->format(); // "73.0423468GB"

// Cut at precision
(new Size(73042346800))->format(null);    // "73GB"
(new Size(73042346800))->format(null, 0); // "73GB"
(new Size(73042346800))->format(null, 2); // "73.04GB"

// Custom format
(new Size(73042346800))->format(null, 1, '%size% %unit_abbreviation% (%unit_name%)'); // "73.0 GB (Gigabyte)"
```

Format value in specified unit:
```php
use Unit\Information\Size;
use Unit\Information\Unit;

(new Size(73042346800))->format(Unit::MEGABYTE); // "73042MB"
(new Size(300000))->format(Unit::MEGABYTE, 1);   // "0.3MB"
```

Transform to a number (not a formatted string) value in another unit:
```php
use Unit\Information\Size;
use Unit\Information\Unit;

(new Size(100000))->get(Unit::KILOBYTE); // 100
(new Size(1))->get(Unit::KILOBYTE);      // 0.001
```

Create a size from a value in a specified unit:
```php
use Unit\Information\Size;

new Size(1);     // If the value is not a string it is treated as a Byte value which is transformed to a Bit value internally
new Size('1MB'); // If it is a string the string is transformed to a Bit value intelligently
new Size('0.05GB');
```

Calculating:
```php
use Unit\Information\Size;

$size = new Size(1);
$otherSize = new Size('1MB');

$size->add($otherSize);
$size->subtract($otherSize);
$size->multiply($otherSize);
$size->divide($otherSize);

$size->add($otherSize)->subtract($otherSize); // Can be chained
```

Instantiate from PHP's shorthand values (which do not follow the IEC standard, see 
https://www.php.net/manual/en/faq.using.php#faq.using.shorthandbytes):
```php
use Unit\Information\Size;
use Unit\Information\InvalidPhpShorthandValueException;

$size = Size::createFromPhpShorthandValue('1M'); // Results in 1048576 Bytes
try {
    $size = Size::createFromPhpShorthandValue(ini_get('memory_limit'));
} catch (InvalidPhpShorthandValueException $exception) {
    // $exception->getMessage() is: 'The PHP shorthand value "-1" cannot be converted to a meaningful size.'
}
```

## Testing
```console
user@machine:~$ ./vendor/bin/phpunit
```

## License
The MIT License (MIT). Please see [License File](https://github.com/michaelKaefer/information/blob/master/LICENSE) for more information.
