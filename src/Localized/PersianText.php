<?php
declare(strict_types=1);

namespace Imahmood\Localized;

use InvalidArgumentException;
use NumberFormatter;
use RuntimeException;

class PersianText
{
    /**
     * @var array<int, string>
     */
    protected static array $enNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    /**
     * @var array<int, string>
     */
    protected static array $arNumbers = ['۰', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

    /**
     * @var array<int, string>
     */
    protected static array $faNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

    /**
     * @var array<int, string>
     */
    protected static array $arChars = ['ي', 'ى', 'ك', 'ة'];

    /**
     * @var array<int, string>
     */
    protected static array $faChars = ['ی', 'ی', 'ک', 'ه'];

    /**
     * Transforms a string to Persian.
     */
    public static function text(float|int|string|null $string): ?string
    {
        $string = static::onlyArabicChars($string);
        return static::onlyNumbers($string);
    }

    /**
     * Replaces Arabic characters and numbers with Persian equivalents.
     */
    public static function onlyArabicChars(float|int|string|null $string): ?string
    {
        $string = static::convert(self::$arChars, self::$faChars, $string);
        return static::convert(self::$arNumbers, self::$faNumbers, $string);
    }

    /**
     * Replaces English and Arabic numbers with Persian numbers.
     */
    public static function onlyNumbers(float|int|string|null $string): ?string
    {
        $string = static::convert(self::$enNumbers, self::$faNumbers, $string);
        return static::convert(self::$arNumbers, self::$faNumbers, $string);
    }

    /**
     * Convert a string containing Persian or Arabic numbers to English numbers.
     */
    public static function toEnglishNumber(float|int|string|null $string): ?string
    {
        $string = static::convert(self::$faNumbers, self::$enNumbers, $string);
        return static::convert(self::$arNumbers, self::$enNumbers, $string);
    }

    /**
     * Formats a number as a money string.
     *
     * @param mixed $number The number to format
     * @param int $decimals Decimal points
     * @param string $decimalPoint Separator for the decimal point
     * @param string $thousandsSep Thousands separator
     * @return string|null
     */
    public static function money(
        mixed $number,
        int $decimals = 0,
        string $decimalPoint = '٫',
        string $thousandsSep = '٬',
    ): ?string {
        if ($number === null) {
            return null;
        }

        $formattedNumber = number_format(static::parseFloat($number), $decimals, $decimalPoint, $thousandsSep);

        return static::onlyNumbers($formattedNumber);
    }

    /**
     * Convert a numeric value to its spelled-out representation.
     *
     * @param mixed $number The numeric value to be converted.
     * @param string $locale The locale to use for formatting (default is 'fa_IR' for Persian).
     * @return string|null
     */
    public static function asSpellout(mixed $number, string $locale = 'fa_IR'): ?string
    {
        if ($number === null) {
            return null;
        }

        $formatter = new NumberFormatter($locale, NumberFormatter::SPELLOUT);
        $formattedNumber = $formatter->format(static::parseFloat($number));

        if ($formattedNumber === false) {
            throw new RuntimeException('Failed to format the number as spellout.');
        }

        return $formattedNumber;
    }

    /**
     * Parse a mixed value to a floating-point number.
     */
    protected static function parseFloat(mixed $number): float
    {
        if (is_object($number)) {
            if (method_exists($number, 'toFloat')) {
                return $number->toFloat();
            }

            if (method_exists($number, '__toString')) {
                $number = (string)$number;
            }
        }

        if (!is_numeric($number)) {
            throw new InvalidArgumentException('$value is not numeric.');
        }

        return (float)$number;
    }

    /**
     * Replaces elements in a string based on search and replace arrays.
     *
     * @param array<int, string> $search
     * @param array<int, string> $replace
     * @param float|int|string|null $subject
     * @return string|null
     */
    protected static function convert(array $search, array $replace, float|int|string|null $subject): ?string
    {
        if ($subject === null) {
            return null;
        }

        $subject = (string)$subject;

        if (trim($subject) === '') {
            return $subject;
        }

        return str_replace($search, $replace, $subject);
    }
}
