<?php

namespace Tests\Unit\CustomEnum;

use CustomEnum\Exceptions\InvalidValueException;
use Example\Color;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

class ColorTest extends TestCase
{
    const Zero     = 0;
    const MinusOne = -1;
    const Big      = 102030405;

    public function testConstruct(){
        $color = new Color(Color::Red);

        $reflectionValue = new ReflectionProperty(Color::class, 'value');
        $reflectionValue->setAccessible(true);

        $reflectionName = new ReflectionProperty(Color::class, 'valueName');
        $reflectionName->setAccessible(true);

        $this->assertNotNull($color);
        $this->assertNotNull($reflectionValue->getValue($color));
        $this->assertNotNull($reflectionName->getValue($color));

        $this->expectException(InvalidValueException::class);
        $this->expectExceptionMessage("The value (11) which is provided is not an enum value");
        new Color(11);
    }

    public function testNameOf()
    {
        // Default usage (toLower: false, strict: true)
        $this->assertEquals('Red', Color::nameOf(Color::Red));
        $this->assertEquals('Green', Color::nameOf(Color::Green));

        // To lower (toLower: true, strict: true)
        $this->assertEquals('red', Color::nameOf(Color::Red, true));
        $this->assertEquals('green', Color::nameOf(Color::Green, true));

        // To lower, same as the above but strict filled (toLower: true, strict: true)
        $this->assertEquals('red', Color::nameOf(Color::Red, true, true));
        $this->assertEquals('green', Color::nameOf(Color::Green, true, true));

        // Non-strict (toLower: false, strict: false)
        $this->assertEquals('Red', Color::nameOf(Color::Red, false, false));
        $this->assertEquals('Green', Color::nameOf(Color::Green, false, false));

        // Non-strict to lower (toLower: true, strict: false)
        $this->assertEquals('red', Color::nameOf(Color::Red, true, false));
        $this->assertEquals('green', Color::nameOf(Color::Green, true, false));
    }

    public function testValueOf()
    {
        // test if default second param is working
        $lower = Color::valueOf('red');
        $ucFirst = Color::valueOf('Red');
        $capital = Color::valueOf('RED');

        $this->assertEquals(Color::Red, $lower);
        $this->assertEquals(Color::Red, $ucFirst);
        $this->assertEquals(Color::Red, $capital);
        // end default

        // default second param is explicitly provided
        $lower = Color::valueOf('red', false);
        $ucFirst = Color::valueOf('Red', false);
        $capital = Color::valueOf('RED', false);

        $this->assertEquals(Color::Red, $lower);
        $this->assertEquals(Color::Red, $ucFirst);
        $this->assertEquals(Color::Red, $capital);
        // end explicit

        // caseSensitive check
        $lower = Color::valueOf('red', true);
        $ucFirst = Color::valueOf('Red', true);
        $capital = Color::valueOf('RED', true);

        $this->assertNotEquals(Color::Red, $lower);
        $this->assertEquals(self::MinusOne, $lower);

        $this->assertNotEquals(self::MinusOne, $ucFirst);
        $this->assertEquals(Color::Red, $ucFirst);

        $this->assertNotEquals(Color::Red, $capital);
        $this->assertEquals(self::MinusOne, $capital);
        // end caseSensitive

        // test to not return bad values
        $ucFirst = Color::valueOf('Red', true);

        $this->assertNotEquals(Color::None, $ucFirst);
        $this->assertNotEquals(Color::Green, $ucFirst);
        $this->assertNotEquals(Color::Blue, $ucFirst);
        $this->assertNotEquals(self::MinusOne, $ucFirst);
        $this->assertEquals(Color::Red, $ucFirst);
        // end bad lower

        // test unknown name
        $unknown = Color::valueOf('Unknown', true);
        $unknown2 = Color::valueOf('asd', true);

        $this->assertNotEquals(Color::None, $unknown);
        $this->assertNotEquals(Color::Red, $unknown);
        $this->assertNotEquals(Color::Green, $unknown);
        $this->assertNotEquals(Color::Blue, $unknown);
        $this->assertEquals(-1, $unknown);

        $this->assertNotEquals(Color::None, $unknown2);
        $this->assertNotEquals(Color::Red, $unknown2);
        $this->assertNotEquals(Color::Green, $unknown2);
        $this->assertNotEquals(Color::Blue, $unknown2);
        $this->assertEquals(-1, $unknown2);
        // end unknown

        // test unknown name 2
        $unknown = Color::valueOf('Unknown');
        $unknown2 = Color::valueOf('asd');

        $this->assertNotEquals(Color::None, $unknown);
        $this->assertNotEquals(Color::Red, $unknown);
        $this->assertNotEquals(Color::Green, $unknown);
        $this->assertNotEquals(Color::Blue, $unknown);
        $this->assertEquals(-1, $unknown);

        $this->assertNotEquals(Color::None, $unknown2);
        $this->assertNotEquals(Color::Red, $unknown2);
        $this->assertNotEquals(Color::Green, $unknown2);
        $this->assertNotEquals(Color::Blue, $unknown2);
        $this->assertEquals(-1, $unknown2);
        // end unknown 2
    }

    public function testIsValidValue()
    {
        $this->assertFalse(Color::isValidValue(self::Zero));
        $this->assertTrue(Color::isValidValue(Color::Red));
        $this->assertTrue(Color::isValidValue(Color::Green));
        $this->assertFalse(Color::isValidValue(self::MinusOne));
        $this->assertFalse(Color::isValidValue(self::Big));

        $this->assertTrue(Color::isValidValue(self::Zero, false));
        $this->assertTrue(Color::isValidValue(Color::Red, false));
        $this->assertTrue(Color::isValidValue(Color::Green, false));
        $this->assertFalse(Color::isValidValue(self::MinusOne, false));
        $this->assertFalse(Color::isValidValue(self::Big, false));

        $this->assertTrue(Color::isValidValue(self::Zero, false));
        $this->assertTrue(Color::isValidValue(Color::Red, false));
        $this->assertTrue(Color::isValidValue(Color::Green, false));
        $this->assertFalse(Color::isValidValue(self::MinusOne, false));
        $this->assertFalse(Color::isValidValue(self::Big, false));
    }

    public function testIsValidName()
    {
        $this->assertTrue(Color::isValidName('Red', true));
        $this->assertTrue(Color::isValidName('red', false));
        $this->assertFalse(Color::isValidName('red', true));

        $this->assertTrue(Color::isValidName('None', true));
        $this->assertTrue(Color::isValidName('none', false));

        $this->assertFalse(Color::isValidName('Test', true));
        $this->assertFalse(Color::isValidName('test', false));
        $this->assertFalse(Color::isValidName('test', true));
    }

    public function testGetName(){
        $color = new Color(Color::Red);
        $this->assertEquals('Red', $color->getName());
    }

    public function testGetValue(){
        $color = new Color(Color::Red);
        $this->assertEquals(Color::Red, $color->getValue());
    }

    public function testGetAsKeyValue(){
        $color = new Color(Color::Red);

        $actual = $color->getAsKeyValue();
        $expected = ['Red' => Color::Red];

        $this->assertCount(1, $expected);
        $this->assertCount(1, $actual);
        $this->assertEquals($expected, $actual);
    }

    public function testByName()
    {
        $color = Color::byName('Red');
        $this->assertNotNull($color);

        $color = Color::byName('Red', true);
        $this->assertNotNull($color);

        $color = Color::byName('Red', false);
        $this->assertNotNull($color);

        $color = Color::byName('red', false);
        $this->assertNotNull($color);

        $color = Color::byName('red', false);
        $this->assertNotNull($color);

        $this->expectException(InvalidValueException::class);
        $this->expectExceptionMessage("The value ('asd') which is provided is not an enum value");
        Color::byName('asd');
    }
}
