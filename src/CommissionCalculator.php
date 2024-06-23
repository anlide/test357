<?php

namespace Test357;

use Test357\BinProvider;
use Test357\ExchangeRateProvider;
use Test357\Exceptions\BinDataException;
use Test357\Exceptions\ExchangeRateException;
use Test357\Exceptions\InvalidDataException;
use Test357\Exceptions\InvalidRateException;
use Test357\Helpers;

class CommissionCalculator {
    private BinProvider $binProvider;
    private ExchangeRateProvider $exchangeRateProvider;

    public function __construct(BinProvider $binProvider, ExchangeRateProvider $exchangeRateProvider) {
        $this->binProvider = $binProvider;
        $this->exchangeRateProvider = $exchangeRateProvider;
    }

    /**
     * Calculates commission based on input transactions.
     *
     * @param string $input Input transactions in JSON format.
     * @return array Calculated commissions.
     * @throws InvalidDataException If the input data is invalid.
     * @throws InvalidRateException If the exchange rate is invalid.
     * @throws BinDataException If there is an error retrieving the BIN data.
     * @throws ExchangeRateException If there is an error retrieving the exchange rate.
     */
    public function calculate(string $input): array {
        $commissions = [];
        $transactions = explode("\n", $input);
        foreach ($transactions as $transaction) {
            if (empty($transaction)) continue;

            $data = json_decode($transaction, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new InvalidDataException('Invalid JSON');
            }

            if (!isset($data['bin'], $data['amount'], $data['currency'])) {
                throw new InvalidDataException('Missing required fields');
            }

            $bin = $data['bin'];
            $amount = $data['amount'];
            $currency = $data['currency'];

            $binData = $this->binProvider->getBinData($bin);
            if (!isset($binData->country->alpha2)) {
                throw new InvalidDataException('Invalid BIN data');
            }

            $isEu = Helpers::isEu($binData->country->alpha2);

            $rate = $this->exchangeRateProvider->getRate($currency);
            if ($rate == 0) {
                throw new InvalidRateException('Invalid exchange rate');
            }

            $amountInEur = ($currency == 'EUR') ? $amount : $amount / $rate;
            $commission = ceil($amountInEur * ($isEu ? 0.01 : 0.02) * 100) / 100;

            $commissions[] = ['commission' => $commission];
        }

        return $commissions;
    }
}
