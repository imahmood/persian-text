<?php
namespace imahmood\Localized;

use NumberFormatter;

class PersianText
{

    protected static $enNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    protected static $arNumbers = ['۰', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
    protected static $faNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    protected static $arChars = ['ي', 'ى', 'ك', 'ة'];
    protected static $faChars = ['ی', 'ی', 'ک', 'ه'];

    /**
     * @param mixed $string
     * @return string|array
     */
    public static function text($string)
    {
        $string = static::onlyArabicChars($string);
        return static::onlyNumbers($string);
    }

    /**
     * @param mixed $string
     * @return string|array
     */
    public static function onlyArabicChars($string)
    {
        $string = static::convert(self::$arChars, self::$faChars, $string);
        return static::convert(self::$arNumbers, self::$faNumbers, $string);
    }

    /**
     * @param mixed $string
     * @return string|array
     */
    public static function onlyNumbers($string)
    {
        $string = static::convert(self::$enNumbers, self::$faNumbers, $string);
        return static::convert(self::$arNumbers, self::$faNumbers, $string);
    }

    /**
     * @param mixed $string
     * @return string|array
     */
    public static function toEnglishNumber($string)
    {
        $string = static::convert(self::$faNumbers, self::$enNumbers, $string);
        return static::convert(self::$arNumbers, self::$enNumbers, $string);
    }

    /**
     * @param float $number
     * @param string $thousandsSep
     * @param int $decimals
     * @param string $decimalPoint
     * @return string
     */
    public static function money($number, $thousandsSep = '٫', $decimals = 0, $decimalPoint = '.')
    {
        return number_format($number, $decimals, $decimalPoint, $thousandsSep);
    }

    /**
     * @param float $number
     * @param string $locale
     * @return string
     */
    public static function asSpellout($number, $locale = 'fa_IR')
    {
        $formatter = new NumberFormatter($locale, NumberFormatter::SPELLOUT);
        return $formatter->format($number);
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
