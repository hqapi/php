<?php

namespace HQAPI;

use HQAPI\Client;
use HQAPI\Exceptions\ApiException;

/**
 * ScreenshotClient
 *
 * Client for interacting with the Screenshot API.
 * Allows capturing screenshots of websites with optional customization.
 *
 * @package HQAPI
 */
class ScreenshotClient extends Client
{
    /** @var string API endpoint for the "no operation" test */
    private const ENDPOINT_NOP = 'screenshot/nop';

    /** @var string API endpoint for creating screenshots */
    private const ENDPOINT_CREATE = 'screenshot/create';

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
     * Creates a screenshot of a website.
     *
     * Only $url is required; all other parameters are optional.
     * Optional parameters are included in the request payload only if non-null.
     *
     * @param string $url The website URL to capture (http or https)
     * @param string|null $theme Browser theme, 'light' or 'dark'
     * @param int|null $browser_width Width of the virtual browser viewport
     * @param int|null $browser_height Height of the virtual browser viewport
     * @param int|null $delay Milliseconds to wait before capturing the screenshot
     * @param string|null $format Image format: 'png' or 'jpeg'
     * @param int|null $jpeg_quality JPEG quality (1-100), used if format=jpeg
     * @param int|null $image_width Width to resize the image before returning
     * @param int|null $image_height Height to resize the image before returning
     * @param bool|null $mobile Render screenshot with a mobile viewport if true
     * @param bool|null $hide_cookie_popups Attempt to hide cookie popups if true
     * @param bool|null $full_page Capture the full page if true
     *
     * @throws ApiException if the API request fails
     * @return mixed The raw image data
     */
    public function create(
        string $url,
        ?string $theme = null,
        ?int $browser_width = null,
        ?int $browser_height = null,
        ?int $delay = null,
        ?string $format = null,
        ?int $jpeg_quality = null,
        ?int $image_width = null,
        ?int $image_height = null,
        ?bool $mobile = null,
        ?bool $hide_cookie_popups = null,
        ?bool $full_page = null
    ): mixed {
        // Always include the required field
        $payload = ['url' => $url];

        // Add only non-null optional parameters
        $optionalParams = [
            'theme' => $theme,
            'browser_width' => $browser_width,
            'browser_height' => $browser_height,
            'delay' => $delay,
            'format' => $format,
            'jpeg_quality' => $jpeg_quality,
            'image_width' => $image_width,
            'image_height' => $image_height,
            'mobile' => $mobile,
            'hide_cookie_popups' => $hide_cookie_popups,
            'full_page' => $full_page,
        ];

        foreach ($optionalParams as $key => $value) {
            if ($value !== null) {
                $payload[$key] = $value;
            }
        }

        $response = $this->post(self::ENDPOINT_CREATE, $payload);
        return $response->getContent();
    }
}
