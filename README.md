# Group

Package for calculating and formatting information units like Bit, Byte, Kilobit, Kilobyte, Megabit, Megabyte, etc.

## Installation

```
composer require unit/information-unit
```

### Units
| Name     | Abbreviation | In Bit               | In Byte           |
| -------- |:------------:| --------------------:| -----------------:|
| Bit      | b            | 1                    | 8                 |
| Kilobit  | kb           | 0.001                | 0,008             |
| Megabit  | Mb           | 0.000001             | 0,000008          |
| Gigabit  | Gb           | 0.000000001          | 0,000000008       |
| Terabit  | Tb           | 0.000000000001       | 0,000000000008    |
| Petabit  | Pb           | 0.000000000000001    | 0,000000000000008 |
| Byte     | B            | 0.125                | 1                 |
| Kilobyte | kB           | 0.000125             | 0,001             |
| Megabyte | MB           | 0.000000125          | 0,000001          |
| Gigabyte | GB           | 0.000000000125       | 0,000000001       |
| Terabyte | TB           | 0.000000000000125    | 0,000000000001    |
| Petabyte | PB           | 0.000000000000000125 | 0,000000000000001 |

## Usage
Intelligent formatting
```php
use Unit\Information\Size;

// Format 1 Byte
(new Size(1))->format(); // "1B"

// Format Byte values
(new Size(4300000))->format();     // "4.3MB"
(new Size(73042346800))->format(); // "73.0423468GB"

// Cut at precision
(new Size(73042346800))->format(null, 0); // "73GB"
(new Size(73042346800))->format(null, 2); // "73.04GB"
```

Format value in specified unit
```php
use Unit\Information\Size;

(new Size(73042346800))->format('MB', 0); // "73042MB"
(new Size(300000))->format('MB', 1);      // "0.3MB"
```

Transform to a number (not a formatted string) value in another unit
```php
use Unit\Information\Size;

(new Size(100000))->get('kB'); // 100
(new Size(1))->get('kB');      // 0.001
```

Create a size from a value in a specified unit
```php
use Unit\Information\Size;

new Size(1);     // If the value is not a string it is treated as a Byte value which is transformed to a Bit value internally
new Size('1MB'); // If it is a string the string is transformed to a Bit value intelligently
new Size('0.05GB');
```

Calculating
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

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## License

The MIT License (MIT). Please see [License File](https://github.com/unit/information-unit/blob/master/LICENSE) for more information.
