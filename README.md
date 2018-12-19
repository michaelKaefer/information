# Group

Package for calculating and formatting information units like Bit, Byte, Kilobit, Kilobyte, Megabit, Megabyte, etc.

## Installation

```
composer require unit/information-unit
```

## Usage

Instantiate information unit:

```php
use Unit\InformationUnit\Size;

$fileSize = new Size(1); // arguments which are no strings are treated as Byte values
$fileSize2 = new Size('1MB');
```

Get permission information:

```php
$fileSize->format();                                // '1B'
$fileSize->format('b');                             // '8b'
$fileSize->format('kb');                            // '0.008kb'
$fileSize->format('kb', 1);                         // '0.0kb'
$fileSize->format('kb', 2);                         // '0.01kb'
$fileSize->format('Mb');                            // '0.000008Mb'
$fileSize->format('Gb');                            // '0.000000008Gb'
$fileSize->format('Tb');                            // '0.000000000008Tb'
$fileSize->format('Pb');                            // '0.000000000000008Pb'
$fileSize->format('B');                             // '1B'
$fileSize->format('kB');                            // '0.001kB'
$fileSize->format('MB');                            // '0.000001MB'
$fileSize->format('GB');                            // '0.000000001GB'
$fileSize->format('TB');                            // '0.000000000001TB'
$fileSize->format('PB');                            // '0.000000000000001PB'

$fileSize->get('b');                                // 8
$fileSize->get('kb');                               // 0.008
$fileSize->get('Mb');                               // 0.000008
$fileSize->get('Gb');                               // 0.000000008
$fileSize->get('Tb');                               // 0.000000000008
$fileSize->get('Pb');                               // 0.000000000000008
$fileSize->get('B');                                // 1
$fileSize->get('kB');                               // 0.001
$fileSize->get('MB');                               // 0.000001
$fileSize->get('GB');                               // 0.000000001
$fileSize->get('TB');                               // 0.000000000001
$fileSize->get('PB');                               // 0.000000000000001

$fileSize->add($fileSize2)->format();               // '1.000001MB'
$fileSize->add($fileSize2)->format();               // '2.000001MB'
$fileSize->add($fileSize2)->format(null, 1);        // '3.0MB'
$fileSize->subtract($fileSize2)->format();          // '2.000001MB'
$fileSize->multiply($fileSize2)->format(null, 1);   // '16.0TB'
$fileSize->divide($fileSize2)->format(null, 1);     // '2.0MB'
```

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## License

The MIT License (MIT). Please see [License File](https://github.com/unit/information-unit/blob/master/LICENSE) for more information.
