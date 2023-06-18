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
&nbsp;
&nbsp;


# **Voice Class**

## Namespace

`Georgehadjisavva\ElevenLabsClient\Voice`

## Class Description

The `Voice` class is a part of the `Georgehadjisavva\ElevenLabsClient\Voice` namespace. It implements the `VoiceInterface`.

### `getAll()`

Retrieve all the available voices.

---

### `getVoice(string $voice_id)`

Returns metadata about a specific voice.

---

### `defaultSettings()`

Gets the default settings for voices.

---

### `voiceSettings(string $voice_id)`

---

### `addVoice(string $name, ?string $description, string $files, ?string $labels = "American")`

Add a new voice to your collection of voices in VoiceLab.

**Parameters:**
- `$name` (string): The name of the voice.
- `$description` (string|null): The description of the voice.
- `$files` (string): The file path of the voice.
- `$labels` (string|null, default: "American"): The labels for the voice.

---

### `editVoice(string $voice_id, string $name, ?string $description, ?string $files, ?string $labels = "American")`

Edit a voice in your collection of voices in VoiceLab.

**Parameters:**
- `$voice_id` (string): The ID of the voice.
- `$name` (string): The new name of the voice.
- `$description` (string|null): The new description of the voice.
- `$files` (string|null): The new file path of the voice.
- `$labels` (string|null, default: "American"): The new labels for the voice.

---

### `deleteVoice(string $voice_id)`

Delete a specific voice from your collection of voices in VoiceLab.

**Parameters:**
- `$voice_id` (string): The ID of the voice.

&nbsp;
&nbsp;

# TextToSpeech class

## Namespace

`Georgehadjisavva\ElevenLabsClient\TextToSpeech`

## Class Description

The `TextToSpeech` class is a part of the `Georgehadjisavva\ElevenLabsClient\TextToSpeech` namespace. It implements the `TextToSpeechInterface`.

### `generate(string $content, string $voice_id , ?bool $optimize_latency, ?string $model_id, ?array $voice_settings = [])`

---

### `generate_stream(string $content, string $voice_id , ?bool $optimize_latency, ?string $model_id , ?array $voice_settings = [])`


&nbsp;
&nbsp;

# History

## Namespace

`Georgehadjisavva\ElevenLabsClient\History`

## Class Description

The `History` class is a part of the `Georgehadjisavva\ElevenLabsClient\History` namespace. It implements the `HistoryInterface`.

### `getHistory()`
Returns metadata about all your generated audio.

---

### `getHistoryItem(string $history_item_id)`
Returns information about a history item by its ID.

### Parameters
- `$history_item_id` (string): The ID of the history item.

---

### `getHistoryItemAudio(string $history_item_id, string $fileName)`
Returns the audio of a history item.

### Parameters
- `$history_item_id` (string): The ID of the history item.
- `$fileName` (string): The desired file name for the audio file.

---

### `deleteHistoryItem(string $history_item_id)`
Delete a history item by its ID.

### Parameters
- `$history_item_id` (string): The ID of the history item.

---

### `downloadHistory(array $history_items, string $filename)`
Download one or more history items. If one history item ID is provided, a single audio file will be returned. If multiple history item IDs are provided, the history items will be packed into a .zip file.

### Parameters
- `$history_items` (array): An array of history item IDs.
- `$filename` (string): The desired file name for the downloaded file.


&nbsp;
&nbsp;
&nbsp;
# `Models` Class

## Available Methods

### `getModels()`

Gets a list of available models.

**Return Type:** `array`


&nbsp;
&nbsp;

# `User` Class

## Namespace

`Georgehadjisavva\ElevenLabsClient\User`

## Class Description

The `User` class is a part of the `Georgehadjisavva\ElevenLabsClient\User` namespace. It implements the `UserInterface`.

## Available Methods

### `getUserInfo()`

Gets information about the user.

**Return Type:** `array`

**Description:**
This method retrieves information about the current user. It sends a GET request to the `user` endpoint and returns the decoded response data as an array.

### `getUserSubscription()`

Gets extended information about the user's subscription.

**Return Type:** `array`

**Description:**
This method retrieves extended information about the current user's subscription. It sends a GET request to the `user/subscription` endpoint and returns the decoded response data as an array.

&nbsp;
&nbsp;

Feel free to use these methods in your Laravel application to interact with the ElevenLabs Voice Generation API.
