<?php

namespace Test357\Tests;

use PHPUnit\Framework\TestCase;
use Test357\ExchangeRateProvider;
use Test357\Exceptions\ExchangeRateException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

class ExchangeRateProviderTest extends TestCase {
    public function testGetRate() {
        $mock = new MockHandler([
            new Response(200, [], json_encode(['rates' => ['USD' => 1.2]])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $exchangeRateProvider = new ExchangeRateProvider($client);

        $rate = $exchangeRateProvider->getRate('USD');

        $this->assertEquals(1.2, $rate);
    }

    public function testGetRateThrowsException() {
        $mock = new MockHandler([
            new RequestException('Error Communicating with Server', new \GuzzleHttp\Psr7\Request('GET', 'test'))
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $exchangeRateProvider = new ExchangeRateProvider($client);

        $this->expectException(ExchangeRateException::class);
        $exchangeRateProvider->getRate('USD');
    }
}
