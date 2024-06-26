<?php

namespace Test357;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Test357\Exceptions\BinDataException;

class BinProvider {
    private Client $client;
    private const BIN_URL = 'https://lookup.binlist.net/';

    private array $cache = [];

    public function __construct() {
        $this->client = new Client();
    }

    /**
     * Retrieves BIN data from the external service.
     *
     * @param string $bin The BIN number to lookup.
     * @return object|null The BIN data.
     * @throws BinDataException If there is an error retrieving the BIN data.
     */
    public function getBinData(string $bin): ?object {
        if (isset($this->cache[$bin])) {
            return $this->cache[$bin];
        }
        try {
            $response = $this->client->get(self::BIN_URL . $bin);
            $data = json_decode($response->getBody());
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new BinDataException('Invalid BIN data');
            }

            $this->cache[$bin] = $data;

            return $data;
        } catch (RequestException $exception) {
            throw new BinDataException('Error fetching BIN data: ' . $exception->getMessage());
        } catch (GuzzleException $exception) {
            throw new BinDataException('Error fetching BIN data: ' . $exception->getMessage());
        }
    }
}
