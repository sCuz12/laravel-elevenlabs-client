<?php

namespace Georgehadjisavva\ElevenLabsClient;

use Exception;
use Georgehadjisavva\ElevenLabsClient\Enums\LatencyOptimizationEnum;
use Georgehadjisavva\ElevenLabsClient\Enums\VoicesEnum;
use Georgehadjisavva\ElevenLabsClient\Interfaces\ElevenLabsClientInterface;
use Georgehadjisavva\ElevenLabsClient\Responses\ErrorResponse;
use Georgehadjisavva\ElevenLabsClient\Responses\SuccessResponse;
use Georgehadjisavva\ElevenLabsClient\TextToSpeech\TextToSpeech;
use Georgehadjisavva\ElevenLabsClient\TextToSpeech\TextToSpeechInterface;
use Georgehadjisavva\ElevenLabsClient\Voice\Voice;
use GuzzleHttp\Client;
use History;
use HistoryInterface;

class ElevenLabsClient implements ElevenLabsClientInterface
{
    protected $apiKey;

    protected $httpClient;

    const BASE_URL = 'https://api.elevenlabs.io/v1/';

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;

        $this->httpClient = new Client([
            'base_uri' => self::BASE_URL,
            'headers' => [
                'xi-api-key' => $this->apiKey,
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function getHttpClient(): Client
    {
        return $this->httpClient;
    }


    /**
     * Get the Voice Instance.
     *
     * @return Voice The Voice instance.
     */
    public function voices(): Voice
    {
        return new Voice($this);
    }

    /**
     * Get the TextToSpeech Instance.
     *
     * @return TextToSpeech The Voice instance.
     */
    public function textToSpeech() : TextToSpeechInterface
    {
        return new TextToSpeech($this);
    }

    public function history() : HistoryInterface {
        return new History($this);
    }

    public function getModels()
    {
        try {
            $response = $this->httpClient->get('models');

            $data = json_decode($response->getBody(), true);
            dd($data);
            return $data['voices'] ?? [];
        } catch (Exception $e) {
            $errorMessageException = json_encode($e->getMessage());
            return (new ErrorResponse($e->getCode(), $errorMessageException))->getResponse();
        }
    }
}
