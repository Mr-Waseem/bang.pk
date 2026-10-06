# PHP Number Converter

This package provides the ability to convert a numerical number to a word, roman numeral, or include the ordinal suffix.

[![Latest Stable Version](https://poser.pugx.org/hnhdigital-os/php-number-converter/v/stable.svg)](https://packagist.org/packages/hnhdigital-os/php-number-converter) [![Total Downloads](https://poser.pugx.org/hnhdigital-os/php-number-converter/downloads.svg)](https://packagist.org/packages/hnhdigital-os/php-number-converter) [![Latest Unstable Version](https://poser.pugx.org/hnhdigital-os/php-number-converter/v/unstable.svg)](https://packagist.org/packages/hnhdigital-os/php-number-converter) [![License](https://poser.pugx.org/hnhdigital-os/php-number-converter/license.svg)](https://packagist.org/packages/hnhdigital-os/php-number-converter)

[![Build Status](https://travis-ci.org/hnhdigital-os/php-number-converter.svg?branch=master)](https://travis-ci.org/hnhdigital-os/php-number-converter) [![StyleCI](https://styleci.io/repos/61008347/shield?branch=master)](https://styleci.io/repos/61008347) [![Test Coverage](https://codeclimate.com/github/hnhdigital-os/php-number-converter/badges/coverage.svg)](https://codeclimate.com/github/hnhdigital-os/php-number-converter/coverage) [![Issue Count](https://codeclimate.com/github/hnhdigital-os/php-number-converter/badges/issue_count.svg)](https://codeclimate.com/github/hnhdigital-os/php-number-converter) [![Code Climate](https://codeclimate.com/github/hnhdigital-os/php-number-converter/badges/gpa.svg)](https://codeclimate.com/github/hnhdigital-os/php-number-converter)

This package has been forked from [saintkabyo/number-converter](https://github.com/saintkabyo/number-converter) and further developed by H&H|Digital, an Australian botique developer. Visit us at [hnh.digital](http://hnh.digital).

## Install

Via composer:

`$ composer require hnhdigital-os/php-number-converter`

## Usage

### Convert to word

Supported number range -2147483647 to 2147483647.

```php
use HnhDigital/PhpNumberConverter;

echo (new NumberConverter())->word(1);
```

```
one
```

### Convert to roman

Supported number range 1 to 3999.

```php
use HnhDigital/PhpNumberConverter;

echo (new NumberConverter())->roman(1);
```

```
I
```

### Ordinal (word + suffix)

Supported number range 1 to 2147483647.

```php
use HnhDigital/PhpNumberConverter;

echo (new NumberConverter())->wordOrdinal(1);
```

```
first
```

### Ordinal (number + suffix)

Supported number range 1 to 2147483647.

```php
use HnhDigital/PhpNumberConverter;

echo (new NumberConverter())->numberOrdinal(1);
```

```
1st
```

## Frameworks

* [Laravel-Number-Converter](https://github.com/hnhdigital-os/laravel-number-converter)

## Contributing

Please see [CONTRIBUTING](https://github.com/hnhdigital-os/php-number-converter/blob/master/CONTRIBUTING.md) for details.

## Credits

* Forked from [saintkabyo/number-converter](https://github.com/saintkabyo/number-converter)
* [Rocco Howard](https://github.com/therocis)
* [All Contributors](https://github.com/hnhdigital-os/php-number-converter/contributors)

## License

The MIT License (MIT). Please see [License File](https://github.com/hnhdigital-os/php-number-converter/blob/master/LICENSE) for more information.
