<?php

namespace HQAPI;

use HQAPI\Client;
use HQAPI\Exceptions\ApiException;

/**
 * ExampleClient
 *
 * A simple example implementation of the HQAPI client.
 * Demonstrates how to create API-specific methods using the base Client.
 *
 * @package HQAPI
 */
class ExampleClient extends Client
{
    /** @var string API endpoint for the "no operation" test */
    private const ENDPOINT_NOP = 'example/nop';

    /** @var string API endpoint for the "ping" test */
    private const ENDPOINT_PING = 'example/ping';

    /** @var string API endpoint for the "add" test */
    private const ENDPOINT_ADD = 'example/add';

    /**
     * Performs a no-operation call to test connectivity.
     *
     * @throws ApiException if the API request fails
     * @return mixed The raw content returned by the API
     */
    public function nop(): mixed
    {
        $response = $this->post(self::ENDPOINT_NOP, []);
        return $response->getContent();
    }

    /**
     * Adds two integers using the API.
     *
     * @param int $a The first number
     * @param int $b The second number
     * @throws ApiException if the API request fails
     * @return int The sum of the two numbers
     */
    public function add(int $a, int $b): int
    {
        $response = $this->post(self::ENDPOINT_ADD, [
            'a' => $a,
            'b' => $b,
        ]);

        return (int) ($response->getContent()['value'] ?? 0);
    }

    /**
     * Sends a ping request and returns the echoed value.
     *
     * @param string $value The value to send to the API
     * @throws ApiException if the API request fails
     * @return string The value returned by the API
     */
    public function ping(string $value): string
    {
        $response = $this->post(self::ENDPOINT_PING, ['value' => $value]);
        return (string) ($response->getContent()['value'] ?? '');
    }
}
