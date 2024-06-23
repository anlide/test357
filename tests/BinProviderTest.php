<?php

namespace Test357\Tests;

use PHPUnit\Framework\TestCase;
use Test357\BinProvider;
use Test357\Exceptions\BinDataException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

class BinProviderTest extends TestCase {
    public function testGetBinData() {
        $mock = new MockHandler([
            new Response(200, [], json_encode(['country' => ['alpha2' => 'DE']])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $binProvider = new BinProvider($client);

        $result = $binProvider->getBinData('45717360');

        $this->assertEquals('DE', $result->country->alpha2);
    }

    public function testGetBinDataThrowsException() {
        $mock = new MockHandler([
            new RequestException('Error Communicating with Server', new \GuzzleHttp\Psr7\Request('GET', 'test'))
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $binProvider = new BinProvider($client);

        $this->expectException(BinDataException::class);
        $binProvider->getBinData('45717360');
    }
}
