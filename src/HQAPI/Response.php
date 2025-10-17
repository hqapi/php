<?php

namespace HQAPI;

/**
 * Response
 *
 * Represents the response returned from the HQAPI.
 * Encapsulates the content type and the actual content.
 *
 * @package HQAPI
 */
class Response
{
    /** @var string The MIME type of the response (e.g., application/json, image/png) */
    protected string $contentType;

    /** @var mixed The actual response content (array for JSON, string for raw data) */
    protected mixed $content;

    /**
     * Response constructor.
     *
     * @param string $contentType MIME type of the response
     * @param mixed $content Response content (decoded JSON or raw data)
     */
    public function __construct(string $contentType, mixed $content)
    {
        $this->contentType = $contentType;
        $this->content = $content;
    }

    /**
     * Get the response content type.
     *
     * @return string The MIME type of the response
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * Get the response content.
     *
     * @return mixed Decoded JSON array or raw string content
     */
    public function getContent(): mixed
    {
        return $this->content;
    }
}
