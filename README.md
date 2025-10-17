# HQAPI PHP Client

A lightweight and easy-to-use PHP client for interacting with the **HQAPI**
web services.

This client provides convenient access to HQAPI endpoints for tasks such as
capturing screenshots, example operations, and other web services — without
manually handling HTTP requests or cURL calls.

---

## 🚀 Features

* Simple, intuitive interface for all HQAPI endpoints
* Fully type-hinted and PHP 8+ compatible
* Automatic error handling with `ApiException`
* Handles JSON responses and binary content (images) seamlessly
* PSR-12 compliant and ready for Composer autoloading

---

## 📦 Installation

Install via Composer:

```bash
composer require hqapi/hqapi-client
```

Autoloading is handled automatically by Composer.

---

## 🔧 Usage

### Initialize the client

```php
<?php

use HQAPI\ScreenshotClient;
use HQAPI\Exceptions\ApiException;

require 'vendor/autoload.php';

$client = new ScreenshotClient('YOUR_API_TOKEN_HERE');
```

---

### Screenshot Create method

```php
try {
    $response = $client->create(
        url: "https://hqapi.com/",
        theme: "dark",
        full_page: true
    );

    // Get raw content (image data)
    $imageData = $response->getContent();

    // Save to disk
    file_put_contents("screenshot.png", $imageData);

    echo "Screenshot saved successfully!";
} catch (ApiException $e) {
    echo "API error: " . $e->getMessage();
}
```

---

### ExampleClient usage

```php
use HQAPI\ExampleClient;

$example = new ExampleClient('YOUR_API_TOKEN_HERE');

try {
    // No operation
    $nop = $example->nop();
    
    // Ping
    $ping = $example->ping("hello");
    
    // Add numbers
    $sum = $example->add(3, 7);
    
    echo "Ping response: $ping, Sum: $sum";
} catch (ApiException $e) {
    echo "API error: " . $e->getMessage();
}
```

---

## 🛠️ Classes

* **ScreenshotClient** – Screenshot API methods (`nop`, `create`)
* **ExampleClient** – Example API methods (`nop`, `ping`, `add`)
* **ApiException** – Thrown on API errors or invalid responses

---

## 📜 License

Distributed under the MIT License.

