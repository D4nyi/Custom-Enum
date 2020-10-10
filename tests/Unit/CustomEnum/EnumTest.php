<?php
/**
 * Copyright © Dániel Szöllősi 2020 - 2020
 * All rights reserved.
 * Created at 2020. 10. 10. 18:35
 */

namespace Tests\Unit\CustomEnum;

use CustomEnum\Enum;
use Mockery;
use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase
{
    private $mock;

    public function testIsValidName()
    {
        $this->assertTrue($this->mock::isValidName('One', true));
        $this->assertTrue($this->mock::isValidName('one', false));
        $this->assertFalse($this->mock::isValidName('one', true));

        $this->assertTrue($this->mock::isValidName('None', false));
        $this->assertTrue($this->mock::isValidName('None', true));

        $this->assertFalse($this->mock::isValidName('Test', true));
        $this->assertFalse($this->mock::isValidName('test', false));
        $this->assertFalse($this->mock::isValidName('test', true));
    }

    public function testNameOf()
    {
        // Default usage (toLower: false, strict: true)
        $this->assertEquals('One', $this->mock::nameOf(1));
        $this->assertEquals('Two', $this->mock::nameOf(2));

        // To lower (toLower: true, strict: true)
        $this->assertEquals('one', $this->mock::nameOf(1, true));
        $this->assertEquals('two', $this->mock::nameOf(2, true));

        // To lower, same as the above but strict filled (toLower: true, strict: true)
        $this->assertEquals('one', $this->mock::nameOf(1, true, true));
        $this->assertEquals('two', $this->mock::nameOf(2, true, true));

        // Non-strict (toLower: false, strict: false)
        $this->assertEquals('One', $this->mock::nameOf(1, false, false));
        $this->assertEquals('Two', $this->mock::nameOf(2, false, false));

        // Non-strict to lower (toLower: true, strict: false)
        $this->assertEquals('one', $this->mock::nameOf(1, true, false));
        $this->assertEquals('two', $this->mock::nameOf(2, true, false));
    }

    public function testIsValidValue()
    {
        $this->assertFalse($this->mock::isValidValue(0));
        $this->assertTrue($this->mock::isValidValue(1));
        $this->assertTrue($this->mock::isValidValue(2));
        $this->assertFalse($this->mock::isValidValue(-1));
        $this->assertFalse($this->mock::isValidValue(10201));

        $this->assertTrue($this->mock::isValidValue(0, false));
        $this->assertTrue($this->mock::isValidValue(1, false));
        $this->assertTrue($this->mock::isValidValue(2, false));
        $this->assertFalse($this->mock::isValidValue(-1, false));
        $this->assertFalse($this->mock::isValidValue(10201, false));

        $this->assertTrue($this->mock::isValidValue(0, false));
        $this->assertTrue($this->mock::isValidValue(1, false));
        $this->assertTrue($this->mock::isValidValue(2, false));
        $this->assertFalse($this->mock::isValidValue(-1, false));
        $this->assertFalse($this->mock::isValidValue(10201, false));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->mock = Mockery::mock(Enum::class);
        $this->mock->shouldAllowMockingProtectedMethods()
                   ->shouldReceive('getConstants')
                   ->andReturn([
                       'None' => 0,
                       'One'  => 1,
                       'Two'  => 2,
                   ]);
    }
}
