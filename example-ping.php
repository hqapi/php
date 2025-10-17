<?php

require __DIR__ . '/vendor/autoload.php';

use HQAPI\Client;

// Your HQAPI.com screenshot token, get your on https://hqapis.com
$token = '--put--your--token--here--';

$client = new HQAPI\ExampleClient($token);
$pong = $client->ping(value: date('r'));

echo "Pong value = {$pong}\n";
