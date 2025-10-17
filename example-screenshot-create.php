<?php

require __DIR__ . '/vendor/autoload.php';

use HQAPI\Client;

// Your HQAPI.com screenshot token, get your on https://hqapis.com
$token = '--put--your--token--here--';

$client = new HQAPI\ScreenshotClient($token);
$image = $client->create(url: 'https://wikipedia.org', theme: 'dark');
file_put_contents('screenshot.png', $image);
