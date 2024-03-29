# PersianText

[![Latest Stable Version](https://img.shields.io/packagist/v/imahmood/persian-text.svg?style=flat-square)](https://packagist.org/packages/imahmood/persian-text)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/imahmood/persian-text/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/imahmood/persian-text/actions?query=workflow%3Atests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/imahmood/persian-text.svg?style=flat-square)](https://packagist.org/packages/imahmood/persian-text)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

PersianText is a lightweight library for persian language localization.

## Requirements
* PHP 8.1 or greater
* intl PHP extension

## Installation
You can install this package via Composer:

``` bash
$ composer require imahmood/persian-text
```

## Usage

``` php
$string = '0123456789 - ۰١٢٣٤٥٦٧٨٩ - ي ك ة';

echo PersianText::text($string);
output: ۰۱۲۳۴۵۶۷۸۹ - ۰۱۲۳۴۵۶۷۸۹ - ی ک ه

echo PersianText::onlyArabicChars($string);
output: 0123456789 - ۰۱۲۳۴۵۶۷۸۹ - ی ک ه

echo PersianText::onlyNumbers($string);
output: ۰۱۲۳۴۵۶۷۸۹ - ۰۱۲۳۴۵۶۷۸۹ - ي ك ة

echo PersianText::toEnglishNumber($string);
output: 0123456789 - 0123456789 - ي ك ة

echo PersianText::money('123456789');
output: 123٬456٬789

echo PersianText::asSpellout(123456);
output: صد و بیست و سه هزار و چهارصد و پنجاه و شش
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
