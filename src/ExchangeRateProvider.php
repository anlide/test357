<?php

namespace Test357;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Test357\Exceptions\ExchangeRateException;

class ExchangeRateProvider {
    private Client $client;
    private const EXCHANGE_RATE_URL = 'https://api.exchangeratesapi.io/latest';

    public function __construct() {
        $this->client = new Client();
    }

    /**
     * Retrieves exchange rate for a given currency.
     *
     * @param string $currency The currency code to lookup.
     * @return float The exchange rate.
     * @throws ExchangeRateException If there is an error retrieving the exchange rate.
     */
    public function getRate(string $currency): float {
        try {
            $response = $this->client->get(self::EXCHANGE_RATE_URL);
            $data = json_decode($response->getBody(), true);
            if (json_last_error() !== JSON_ERROR_NONE || !isset($data['rates'][$currency])) {
                throw new ExchangeRateException('Invalid exchange rate data');
            }
            return (float)$data['rates'][$currency];
        } catch (RequestException $e) {
            throw new ExchangeRateException('Error fetching exchange rate data');
        }
    }
}
