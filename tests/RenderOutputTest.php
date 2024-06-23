<?php

namespace Test357\Tests;

use PHPUnit\Framework\TestCase;
use Test357\RenderOutput;

class RenderOutputTest extends TestCase {
    public function testOutput() {
        $output = new RenderOutput();
        $data = ['commission' => 1.00];

        ob_start();
        $output->output($data);
        $result = ob_get_clean();

        $this->assertJson($result);
        $this->assertEquals(json_encode($data), $result);
    }

    public function testOutputError() {
        $output = new RenderOutput();
        $message = 'An error occurred';

        ob_start();
        $output->outputError($message);
        $result = ob_get_clean();

        $expected = json_encode(['error' => $message]);

        $this->assertJson($result);
        $this->assertEquals($expected, $result);
    }
}
