<?php

namespace HnhDigital\PhpNumberConverter\Tests;

use HnhDigital\PhpNumberConverter\NumberConverter;
use PHPUnit\Framework\TestCase;

class NumberConverterTest extends TestCase
{
    public function testNumber()
    {
        $converter = new NumberConverter();

        $this->assertEquals('zero', $converter->word(0));
        $this->assertEquals('one', $converter->word(1));
        $this->assertEquals('two', $converter->word(2));
        $this->assertEquals('three', $converter->word(3));
        $this->assertEquals('four', $converter->word(4));
        $this->assertEquals('five', $converter->word(5));
        $this->assertEquals('six', $converter->word(6));
        $this->assertEquals('seven', $converter->word(7));
        $this->assertEquals('eight', $converter->word(8));
        $this->assertEquals('nine', $converter->word(9));
        $this->assertEquals('ten', $converter->word(10));
        $this->assertEquals('eleven', $converter->word(11));
        $this->assertEquals('twelve', $converter->word(12));
        $this->assertEquals('thirteen', $converter->word(13));
        $this->assertEquals('fourteen', $converter->word(14));
        $this->assertEquals('fifteen', $converter->word(15));
        $this->assertEquals('sixteen', $converter->word(16));
        $this->assertEquals('seventeen', $converter->word(17));
        $this->assertEquals('eighteen', $converter->word(18));
        $this->assertEquals('nineteen', $converter->word(19));
        $this->assertEquals('twenty', $converter->word(20));
        $this->assertEquals('twenty-one', $converter->word(21));
        $this->assertEquals('thirty', $converter->word(30));
        $this->assertEquals('fourty', $converter->word(40));
        $this->assertEquals('fifty', $converter->word(50));
        $this->assertEquals('sixty', $converter->word(60));
        $this->assertEquals('seventy', $converter->word(70));
        $this->assertEquals('eighty', $converter->word(80));
        $this->assertEquals('ninety', $converter->word(90));
        $this->assertEquals('one hundred', $converter->word(100));
        $this->assertEquals('one hundred and one', $converter->word(101));
        $this->assertEquals('one thousand', $converter->word(1000));
        $this->assertEquals('one million', $converter->word(1000000));
        $this->assertEquals('one billion', $converter->word(1000000000));
        $this->assertEquals('one trillion', $converter->word(1000000000000));
        $this->assertEquals('one quadrillion', $converter->word(1000000000000000));
        $this->assertEquals('one quintillion', $converter->word(1000000000000000000));
    }

    public function testWordOrdinal()
    {
        $converter = new NumberConverter();

        //$this->assertEquals('0', $converter->wordOrdinal(0));
        $this->assertEquals('first', $converter->wordOrdinal(1));
        $this->assertEquals('second', $converter->wordOrdinal(2));
        $this->assertEquals('third', $converter->wordOrdinal(3));
        $this->assertEquals('fourth', $converter->wordOrdinal(4));
        $this->assertEquals('fifth', $converter->wordOrdinal(5));
        $this->assertEquals('sixth', $converter->wordOrdinal(6));
        $this->assertEquals('seventh', $converter->wordOrdinal(7));
        $this->assertEquals('eighth', $converter->wordOrdinal(8));
        $this->assertEquals('ninth', $converter->wordOrdinal(9));
        $this->assertEquals('tenth', $converter->wordOrdinal(10));
        $this->assertEquals('eleventh', $converter->wordOrdinal(11));
        $this->assertEquals('twenty first', $converter->wordOrdinal(21));
        $this->assertEquals('one hundredth', $converter->wordOrdinal(100));
        $this->assertEquals('one hundredth and one', $converter->wordOrdinal(101));
        $this->assertEquals('two hundredth and two', $converter->wordOrdinal(202));
    }

    public function testNumberOrdinal()
    {
        $converter = new NumberConverter();

        $this->assertEquals('0', $converter->numberOrdinal(0));
        $this->assertEquals('1st', $converter->numberOrdinal(1));
        $this->assertEquals('2nd', $converter->numberOrdinal(2));
        $this->assertEquals('3rd', $converter->numberOrdinal(3));
        $this->assertEquals('4th', $converter->numberOrdinal(4));
        $this->assertEquals('5th', $converter->numberOrdinal(5));
        $this->assertEquals('6th', $converter->numberOrdinal(6));
        $this->assertEquals('7th', $converter->numberOrdinal(7));
        $this->assertEquals('8th', $converter->numberOrdinal(8));
        $this->assertEquals('9th', $converter->numberOrdinal(9));
        $this->assertEquals('10th', $converter->numberOrdinal(10));
        $this->assertEquals('11th', $converter->numberOrdinal(11));
        $this->assertEquals('21st', $converter->numberOrdinal(21));
        $this->assertEquals('100th', $converter->numberOrdinal(100));
        $this->assertEquals('101st', $converter->numberOrdinal(101));
    }

    public function testRoman()
    {
        $converter = new NumberConverter();

        $this->assertEquals('I', $converter->roman(1));
        $this->assertEquals('II', $converter->roman(2));
        $this->assertEquals('III', $converter->roman(3));
        $this->assertEquals('IV', $converter->roman(4));
        $this->assertEquals('V', $converter->roman(5));
        $this->assertEquals('VI', $converter->roman(6));
        $this->assertEquals('VII', $converter->roman(7));
        $this->assertEquals('VIII', $converter->roman(8));
        $this->assertEquals('IX', $converter->roman(9));
        $this->assertEquals('X', $converter->roman(10));
        $this->assertEquals('XI', $converter->roman(11));
        $this->assertEquals('XXI', $converter->roman(21));
        $this->assertEquals('XL', $converter->roman(40));
        $this->assertEquals('XLI', $converter->roman(41));
        $this->assertEquals('L', $converter->roman(50));
        $this->assertEquals('LI', $converter->roman(51));
        $this->assertEquals('C', $converter->roman(100));
        $this->assertEquals('CI', $converter->roman(101));
        $this->assertEquals('D', $converter->roman(500));
        $this->assertEquals('DI', $converter->roman(501));
        $this->assertEquals('CM', $converter->roman(900));
        $this->assertEquals('CMI', $converter->roman(901));
        $this->assertEquals('M', $converter->roman(1000));
        $this->assertEquals('MI', $converter->roman(1001));
    }
}
