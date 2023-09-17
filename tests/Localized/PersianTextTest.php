<?php
declare(strict_types=1);

namespace Imahmood\Tests\Localized;

use Imahmood\Localized\PersianText;
use PHPUnit\Framework\TestCase;

class PersianTextTest extends TestCase
{
    public function testTextMethodWithNullInput(): void
    {
        $result = PersianText::text(null);
        $this->assertNull($result);
    }

    public function testTextMethod(): void
    {
        $text = 'En: 0123456789 - Ar: ۰١٢٣٤٥٦٧٨٩ - ArChars: ي ك ة';
        $result = PersianText::text($text);

        $this->assertSame('En: ۰۱۲۳۴۵۶۷۸۹ - Ar: ۰۱۲۳۴۵۶۷۸۹ - ArChars: ی ک ه', $result);
    }

    public function testOnlyArabicCharsMethodWithNullInput(): void
    {
        $result = PersianText::onlyArabicChars(null);
        $this->assertNull($result);
    }

    public function testOnlyArabicCharsMethodWithArabicCharsInput(): void
    {
        $text = 'En: 0123456789 - Ar: ۰١٢٣٤٥٦٧٨٩ - ArChars: ي ك ة';
        $result = PersianText::onlyArabicChars($text);

        $this->assertSame('En: 0123456789 - Ar: ۰۱۲۳۴۵۶۷۸۹ - ArChars: ی ک ه', $result);
    }

    public function testOnlyNumbersMethodWithNullInput(): void
    {
        $result = PersianText::onlyNumbers(null);
        $this->assertNull($result);
    }

    public function testOnlyNumbersMethodWithMixedInput(): void
    {
        $text = 'En: 0123456789 - Ar: ۰١٢٣٤٥٦٧٨٩ - ArChars: ي ك ة';
        $result = PersianText::onlyNumbers($text);

        $this->assertSame('En: ۰۱۲۳۴۵۶۷۸۹ - Ar: ۰۱۲۳۴۵۶۷۸۹ - ArChars: ي ك ة', $result);
    }

    public function testToEnglishNumberMethodWithNullInput(): void
    {
        $result = PersianText::toEnglishNumber(null);
        $this->assertNull($result);
    }

    public function testToEnglishNumberMethodWithPersianNumbersInput(): void
    {
        $result = PersianText::toEnglishNumber('۰١٢٣٤٥٦٧٨٩');
        $this->assertSame('0123456789', $result);

        $result = PersianText::toEnglishNumber('۰۱۲۳۴۵۶۷۸۹');
        $this->assertSame('0123456789', $result);
    }

    public function testMoneyMethodWithNullInput(): void
    {
        $result = PersianText::money(null);
        $this->assertNull($result);
    }

    public function testMoneyMethodWithNumericInput(): void
    {
        $result = PersianText::money(12345.67, 2, '٫', '٬');
        $this->assertSame('۱۲٬۳۴۵٫۶۷', $result);

        $result = PersianText::money(12345.67, 0, '٫', '٬');
        $this->assertSame('۱۲٬۳۴۶', $result);
    }

    public function testAsSpelloutMethodWithNullInput(): void
    {
        $result = PersianText::asSpellout(null);
        $this->assertNull($result);
    }

    public function testAsSpelloutMethodWithNumericInput(): void
    {
        $result = PersianText::asSpellout(12345);
        $this->assertSame('دوازده هزار و سیصد و چهل و پنج', $result);
    }
}
