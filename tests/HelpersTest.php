<?php

namespace Test357\Tests;

use PHPUnit\Framework\TestCase;
use Test357\Helpers;

class HelpersTest extends TestCase {
    public function testIsEu() {
        // Assuming you moved the isEu function to a Helpers class
        $result = Helpers::isEu('DE');
        $this->assertTrue($result);

        $result = Helpers::isEu('US');
        $this->assertFalse($result);
    }
}
