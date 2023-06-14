# Laravel ElevenLabs Voice Generation Wrapper

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE.md)

This is a Laravel package that serves as a wrapper for ElevenLabs Voice Generation API. It provides an easy-to-use interface for generating voices based on provided content.

## Installation

You can install the package via Composer. Run the following command:

```bash
composer require georgehadjisavva/elevenlabs-api-client
```
Next, you need to add the service provider in your Laravel application's config/app.php file. Open the file and locate the 'providers' array. Add the following line to the array:

```bash
Georgehadjisavva\ElevenLabsClient\Providers\ElevenLabsClientServiceProvider::class,
```


## Usage
To get started, make sure to set up your ElevenLabs API key. You can do this by adding the following key to your .env file:
```bash
ELEVEN_API_KEY=your-api-key
```

You can then use the package by accessing the ElevenLabsClient instance. For example, you can add the following route to your web.php or api.php file to test that the library is working:

```bash
use Georgehadjisavva\ElevenLabsClient\Facades\ElevenLabsClient;

Route::get('/test_elevenlabsclient', function() {
    $elevenLabsClient = app()->make(ElevenLabsClient::class);
    return $elevenLabsClient->voices()->getAll();
});
```

