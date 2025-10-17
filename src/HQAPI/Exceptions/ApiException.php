<?php

namespace HqApi\Exceptions;

use Exception;
use Throwable;

/**
 * ApiException
 *
 * Thrown when an API request fails or the response is invalid.
 *
 * @package HqApi\Exceptions
 */
class ApiException extends Exception
{
    /**
     * ApiException constructor.
     *
     * @param string $message Error message
     * @param int $code Error code
     * @param Throwable|null $previous Previous exception, if any
     */
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
