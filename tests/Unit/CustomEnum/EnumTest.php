<?php
/**
 * Copyright © Dániel Szöllősi 2020 - 2020
 * All rights reserved.
 * Created at 2020. 10. 10. 18:35
 */

namespace Tests\Unit\CustomEnum;

use Example\Color;
use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase
{
    const Zero = 0;
    const MinusOne = -1;
    const Big = 102030405;
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
}
