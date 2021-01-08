<?php
namespace imahmood\Localized;

use InvalidArgumentException;
use NumberFormatter;

class PersianText
{
    /**
     * @var string[]
     */
    protected static $enNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    /**
     * @var string[]
     */
    protected static $arNumbers = ['۰', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

    /**
     * @var string[]
     */
    protected static $faNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

    /**
     * @var string[]
     */
    protected static $arChars = ['ي', 'ى', 'ك', 'ة'];

    /**
     * @var string[]
     */
    protected static $faChars = ['ی', 'ی', 'ک', 'ه'];

    /**
     * @param string|int|float $string The string being formatted.
     * @return string|int|float
     */
    public static function text($string)
    {
        $string = static::onlyArabicChars($string);
        return static::onlyNumbers($string);
    }

    /**
     * @param string|int|float $string The string being formatted.
     * @return string|int|float
     */
    public static function onlyArabicChars($string)
    {
        $string = static::convert(self::$arChars, self::$faChars, $string);
        return static::convert(self::$arNumbers, self::$faNumbers, $string);
    }

    /**
     * @param string|int|float $string The string being formatted.
     * @return string|int|float
     */
    public static function onlyNumbers($string)
    {
        $string = static::convert(self::$enNumbers, self::$faNumbers, $string);
        return static::convert(self::$arNumbers, self::$faNumbers, $string);
    }

    /**
     * @param string|int|float $string The string being formatted.
     * @return string|int|float
     */
    public static function toEnglishNumber($string)
    {
        $string = static::convert(self::$faNumbers, self::$enNumbers, $string);
        return static::convert(self::$arNumbers, self::$enNumbers, $string);
    }

    /**
     * @param mixed $number Number
     * @param int $decimals Decimal points
     * @param string $decimalPoint Separator for the decimal point
     * @param string $thousandsSep Thousands separator
     * @return string
     */
    public static function money($number, $decimals = 0, $decimalPoint = '٫', $thousandsSep = '٬')
    {
        return number_format(static::parseValue($number), $decimals, $decimalPoint, $thousandsSep);
    }

    /**
     * @param mixed $number Number
     * @param string $locale Locale
     * @return string
     */
    public static function asSpellout($number, $locale = 'fa_IR')
    {
        $formatter = new NumberFormatter($locale, NumberFormatter::SPELLOUT);

        return $formatter->format(static::parseValue($number));
    }

    /**
     * @param mixed $value Value
     * @return float
     */
    protected static function parseValue($value)
    {
        if (is_object($value)) {
            if (method_exists($value, 'toFloat')) {
                return $value->toFloat();
            }

            if (method_exists($value, '__toString')) {
                $value = strval($value);
            }
        }

        if (!is_numeric($value)) {
            throw new InvalidArgumentException(sprintf('"%s" is not numeric.', $value));
        }

        return (float)$value;
    }

    /**
     * @param array $search
     * @param array $replace
     * @param mixed $subject
     * @return mixed
     */
    protected static function convert(array $search, array $replace, $subject)
    {
        if (trim($subject) === '' || is_bool($subject)) {
            return $subject;
        }

        return str_replace($search, $replace, $subject);
    }
}
