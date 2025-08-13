<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class SimpleTest extends TestCase
{
    public function testBasicAssertion()
    {
        $this->assertTrue(true);
        $this->assertEquals(2, 1 + 1);
    }

    public function testStringOperations()
    {
        $string = "Hello World";
        $this->assertEquals("Hello World", $string);
        $this->assertStringContainsString("Hello", $string);
    }
} 