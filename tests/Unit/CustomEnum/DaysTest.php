<?php
/**
 * Copyright © Dániel Szöllősi 2020 - 2021
 * All rights reserved.
 * Created at 2020. 10. 10. 18:51
 */

namespace Tests\Unit\CustomEnum;

use CustomEnum\Exceptions\InvalidFlagException;
use CustomEnum\Exceptions\InvalidValueException;
use Example\Days;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

class DaysTest extends TestCase
{
    public function testConstruct()
    {
        $color = new Days(Days::Monday);

        $reflectionValue = new ReflectionProperty(Days::class, 'value');
        $reflectionValue->setAccessible(true);

        $reflectionName = new ReflectionProperty(Days::class, 'valueName');
        $reflectionName->setAccessible(true);

        $this->assertNotNull($color);
        $this->assertNotNull($reflectionValue->getValue($color));
        $this->assertNotNull($reflectionName->getValue($color));

        $this->expectException(InvalidFlagException::class);
        $this->expectExceptionMessage("Flag (128) cannot be decomposed!");
        new Days(128);
    }

    public function testContains()
    {
        $this->assertTrue(Days::contains(3, Days::Monday));
        $this->assertTrue(Days::contains(3, Days::Monday));
        $this->assertFalse(Days::contains(3, Days::None));
        $this->assertFalse(Days::contains(3, -1));
        $this->assertFalse(Days::contains(3, 10201));

        $this->assertTrue(Days::contains(2, 2));
    }

    public function testValuesToFlag()
    {
        $this->assertEquals(3, Days::valuesToFlag([1, 2]));
        $this->assertEquals(3, Days::valuesToFlag([1, 1, 2, 2]));
        $this->assertEquals(0, Days::valuesToFlag([101, 202, 404]));
        $this->assertEquals(0, Days::valuesToFlag([101, 101, 202, 202, 404, 404]));
    }

    public function testFlagToEnumNames()
    {
        $names = Days::flagToEnumNames(3);
        $this->assertCount(2, $names);
        $this->assertContains('Monday', $names);
        $this->assertContains('Tuesday', $names);

        $names = Days::flagToEnumNames(129);
        $this->assertNull($names);
    }

    public function testFlagToValues()
    {
        $values = Days::flagToValues(3);
        $this->assertNotNull($values);
        $this->assertNotEmpty($values);
        $this->assertCount(2, $values);
        $this->assertNotContains(0, $values);
        $this->assertContains(1, $values);
        $this->assertContains(2, $values);

        $values = Days::flagToValues(2);
        $this->assertNotNull($values);
        $this->assertNotEmpty($values);
        $this->assertCount(1, $values);
        $this->assertNotContains(0, $values);
        $this->assertContains(2, $values);

        $values = Days::flagToValues(Days::Monday + Days::Wednesday);
        $this->assertNotNull($values);
        $this->assertNotEmpty($values);
        $this->assertCount(2, $values);
        $this->assertNotContains(0, $values);
        $this->assertContains(1, $values);
        $this->assertContains(4, $values);
    }

    public function testGetBuiltFrom()
    {
        $days = new Days(Days::Monday + Days::Tuesday);
        $built = $days->getBuiltFrom();

        $this->assertNotNull($built);
        $this->assertNotEmpty($built);
        $this->assertCount(2, $built);
        $this->assertNotContains(0, $built);
        $this->assertContains(1, $built);
        $this->assertContains(2, $built);
        $this->assertNotContains(4, $built);
    }

    public function testIsFlag()
    {
        $isFlag = new Days(Days::Thursday + Days::Saturday);
        $this->assertTrue($isFlag->isFlag());

        $isNotFlag = new Days(Days::Thursday);
        $this->assertFalse($isNotFlag->isFlag());
    }

    public function testHasEnum()
    {
        $flag = new Days(Days::Thursday + Days::Friday);
        $this->assertTrue($flag->hasEnum(Days::Thursday));
        $this->assertTrue($flag->hasEnum(Days::Friday));
        $this->assertFalse($flag->hasEnum(Days::Monday));

        $this->assertFalse($flag->hasEnum(7));

        $flag = new Days(Days::Thursday);
        $this->assertTrue($flag->hasEnum(Days::Thursday));
    }

    public function testNames()
    {
        $flag = new Days(Days::Thursday + Days::Friday);
        $names = $flag->names();
        $this->assertNotNull($names);
        $this->assertNotEmpty($names);
        $this->assertCount(2, $names);
        $this->assertContains('Thursday', $names);
        $this->assertContains('Friday', $names);
    }

    public function testByName()
    {
        $days = Days::byName('Monday');
        $this->assertNotNull($days);

        $days = Days::byName('Monday', true);
        $this->assertNotNull($days);

        $days = Days::byName('Monday', false);
        $this->assertNotNull($days);

        $days = Days::byName('monday', false);
        $this->assertNotNull($days);

        $days = Days::byName('monday', false);
        $this->assertNotNull($days);

        $this->expectException(InvalidValueException::class);
        $this->expectExceptionMessage("The value ('asd') which is provided is not an enum value");
        Days::byName('asd');
    }
}
