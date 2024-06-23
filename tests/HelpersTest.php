<?php

namespace Test357\Tests;

use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase {
    public function testIsEu() {
        // Assuming you moved the isEu function to a Helpers class
        $result = \Test357\Helpers::isEu('DE');
        $this->assertTrue($result);

        $result = \Test357\Helpers::isEu('US');
        $this->assertFalse($result);
    }
}
