<?php

namespace HQAPI;

use HQAPI\Exceptions\ApiException;
use JsonException;

/**
 * Base Client for HQAPI
 *
 * Provides core HTTP functionality for making requests to the HQAPI endpoints.
 *
 * @package HQAPI
 */
class Client
{
    /** @var string Base URI for HQAPI */
    protected string $baseUri;

    /** @var string API token for authentication */
    protected string $token;

    /** @var int Request timeout in seconds */
    protected int $timeout = 60;

    /**
     * Client constructor.
     *
     * @param string $token API token
     */
    public function __construct(string $token)
    {
        $this->baseUri = 'https://api.eu-west.hqapi.com/api/v1';
        $this->token = $token;
    }

    /**
     * Make a POST request with JSON data.
     *
     * @param string $endpoint API endpoint (without token)
     * @param array $data Data to send as JSON
     * @throws ApiException If request fails or response cannot be decoded
     * @return Response Response object containing content and content type
     */
    protected function post(string $endpoint, array $data): Response
    {
        $url = $this->baseUri . '/' . $this->token . '/' . ltrim($endpoint, '/');

        // Encode request payload to JSON
        try {
            $payload = json_encode($data, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new ApiException("Failed to encode data to JSON: " . $e->getMessage(), 0, $e);
        }

        $ch = curl_init($url);

        $headers = ['Content-Type: application/json'];

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $payload,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_TIMEOUT        => $this->timeout,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);

        $responseContent = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new ApiException("cURL error: {$error}");
        }

        curl_close($ch);

        // Handle HTTP errors (>= 400)
        if ($httpCode >= 400) {
            $decoded = null;
            if (str_starts_with($contentType ?? '', 'application/json')) {
                try {
                    $decoded = json_decode($responseContent, true, 512, JSON_THROW_ON_ERROR);
                } catch (\JsonException $e) {
                    // ignore JSON decode errors here, use raw response
                }
            }

            $message = $decoded['message'] ?? $responseContent;
            $code = $decoded['code'] ?? $httpCode;
            throw new ApiException("HTTP {$code}: {$message}", $httpCode);
        }

        // Parse JSON responses
        if ($contentType !== null && str_starts_with($contentType, 'application/json')) {
            try {
                $decoded = json_decode($responseContent, true, 512, JSON_THROW_ON_ERROR);
            } catch (JsonException $e) {
                throw new ApiException("Failed to decode JSON response: " . $e->getMessage(), $httpCode, $e);
            }

            return new Response($contentType, $decoded);
        }

        // Return other content types as raw string (images, etc.)
        return new Response($contentType ?? 'text/plain', $responseContent);
    }
}
