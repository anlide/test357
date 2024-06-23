<?php

require 'vendor/autoload.php';

use Test357\CommissionCalculator;
use Test357\BinProvider;
use Test357\ExchangeRateProvider;
use Test357\RenderOutput;
use Test357\Exceptions\InvalidDataException;
use Test357\Exceptions\InvalidRateException;
use Test357\Exceptions\BinDataException;
use Test357\Exceptions\ExchangeRateException;

$binProvider = new BinProvider();
$exchangeRateProvider = new ExchangeRateProvider();
$renderOutput = new RenderOutput();
$calculator = new CommissionCalculator($binProvider, $exchangeRateProvider);

$inputFile = $argv[1] ?? 'input.txt';

if (!file_exists($inputFile)) {
    $renderOutput->outputError("Input file not found: $inputFile");
}

$input = file_get_contents($inputFile);

try {
    $commissions = $calculator->calculate($input);
    $renderOutput->output($commissions);
    exit(0);
} catch (InvalidDataException | InvalidRateException | BinDataException | ExchangeRateException $e) {
    $renderOutput->outputError($e->getMessage());
    exit(1);
}
