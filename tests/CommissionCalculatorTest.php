<?php

namespace Test357\Tests;

use PHPUnit\Framework\TestCase;
use Test357\CommissionCalculator;
use Test357\BinProvider;
use Test357\ExchangeRateProvider;
use Test357\RenderOutput;

class CommissionCalculatorTest extends TestCase {
    private $binProviderMock;
    private $exchangeRateProviderMock;
    private $renderOutputMock;
    private $commissionCalculator;

    protected function setUp(): void {
        $this->binProviderMock = $this->createMock(BinProvider::class);
        $this->exchangeRateProviderMock = $this->createMock(ExchangeRateProvider::class);
        $this->renderOutputMock = $this->createMock(RenderOutput::class);

        $this->commissionCalculator = new CommissionCalculator(
            $this->binProviderMock,
            $this->exchangeRateProviderMock,
            $this->renderOutputMock
        );
    }

    public function testCalculate(): void {
        $input = '{"bin":"45717360","amount":"100.00","currency":"EUR"}';

        $this->binProviderMock->method('getBinData')->willReturn((object)['country' => (object)['alpha2' => 'DE']]);
        $this->exchangeRateProviderMock->method('getRate')->willReturn(1);
        $this->renderOutputMock->expects($this->once())
            ->method('output')
            ->with(['commission' => 1.00]);

        $this->commissionCalculator->calculate($input);
    }
}
