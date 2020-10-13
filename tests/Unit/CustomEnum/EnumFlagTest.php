<?php
/**
 * Copyright © Dániel Szöllősi 2020 - 2020
 * All rights reserved.
 * Created at 2020. 10. 10. 18:51
 */

namespace Tests\Unit\CustomEnum;

use PHPUnit\Framework\TestCase;
use Tests\Classes\Days;

class EnumFlagTest extends TestCase
{
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
}
