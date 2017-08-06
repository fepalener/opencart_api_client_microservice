<?php
declare(strict_types = 1);

use Test\UnitTestCase;

class UnitTest extends UnitTestCase
{

    public function testCase()
    {
        $this->assertEquals(
            "works", "works", "This is OK"
        );

        $this->assertNotEquals(
            "works", "works1", "This will fail"
        );
    }
}