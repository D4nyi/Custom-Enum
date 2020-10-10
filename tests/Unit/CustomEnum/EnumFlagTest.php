<?php
/**
 * Copyright © Dániel Szöllősi 2020 - 2020
 * All rights reserved.
 * Created at 2020. 10. 10. 18:51
 */

namespace Tests\Unit\CustomEnum;

use CustomEnum\EnumFlag;
use Mockery;
use PHPUnit\Framework\TestCase;

class EnumFlagTest extends TestCase
{
    private $mock;

    public function testValuesToFlag()
    {
        $this->assertEquals(3, $this->mock::valuesToFlag([1, 2]));
        $this->assertEquals(3, $this->mock::valuesToFlag([1, 1, 2, 2]));
        $this->assertEquals(0, $this->mock::valuesToFlag([101, 202, 404]));
        $this->assertEquals(0, $this->mock::valuesToFlag([101, 101, 202, 202, 404, 404]));
    }

    public function testFlagToEnumNames()
    {
        $names = $this->mock::flagToEnumNames(3);
        $this->assertCount(2, $names);
        $this->assertContains('One', $names);
        $this->assertContains('Two', $names);
    }

    public function testFlagToValues()
    {
        $values = $this->mock::flagToValues(3);
        $this->assertNotNull($values);
        $this->assertNotEmpty($values);
        $this->assertCount(2, $values);
        $this->assertNotContains(0, $values);
        $this->assertContains(1, $values);
        $this->assertContains(2, $values);

        $values = $this->mock::flagToValues(2);
        $this->assertNotNull($values);
        $this->assertNotEmpty($values);
        $this->assertCount(1, $values);
        $this->assertNotContains(0, $values);
        $this->assertContains(2, $values);

        $values = $this->mock::flagToValues(1 + 4);
        $this->assertNotNull($values);
        $this->assertNotEmpty($values);
        $this->assertCount(2, $values);
        $this->assertNotContains(0, $values);
        $this->assertContains(1, $values);
    }

    public function testContains()
    {
        $this->assertTrue($this->mock::contains(3, 1));
        $this->assertTrue($this->mock::contains(3, 1));
        $this->assertFalse($this->mock::contains(3, 0));
        $this->assertFalse($this->mock::contains(3, -1));
        $this->assertFalse($this->mock::contains(3, 10201));

        $this->assertTrue($this->mock::contains(2, 2));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->mock = Mockery::mock(EnumFlag::class);
        $this->mock->shouldAllowMockingProtectedMethods()
                   ->shouldReceive('getConstants')
                   ->andReturn([
                       'None' => 0,
                       'One'  => 1,
                       'Two'  => 2,
                       'Four' => 4,
                   ]);
    }
}
