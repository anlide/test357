<?php

namespace Test357;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Test357\Exceptions\ExchangeRateException;

class ExchangeRateProvider {
    private Client $client;
    private const EXCHANGE_RATE_URL = 'https://api.exchangeratesapi.io/latest';

    /** @var ?array */
    private ?array $cache = null;

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
        if ($this->cache !== null) {
            if (!isset($data['rates'][$currency])) {
                throw new ExchangeRateException('Missed exchange rate data for currency: ' . $currency);
            }

            return (float)$this->cache['rates'][$currency];
        }
        try {
            $response = $this->client->get(self::EXCHANGE_RATE_URL);
            $data = json_decode($response->getBody(), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new ExchangeRateException('Invalid exchange rate data');
            }
            if (!isset($data['rates'][$currency])) {
                throw new ExchangeRateException('Missed exchange rate data for currency: ' . $currency);
            }

            $this->cache = $data;

            return (float)$data['rates'][$currency];
        } catch (RequestException $exception) {
            throw new ExchangeRateException('Error fetching exchange rate data: ' . $exception->getMessage());
        } catch (GuzzleException $exception) {
            throw new ExchangeRateException('Error fetching exchange rate data: ' . $exception->getMessage());
        }
    }
}
