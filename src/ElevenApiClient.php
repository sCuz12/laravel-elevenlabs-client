<?php

namespace Georgehadjisavva\ElevenApiClient;

use Exception;
use Georgehadjisavva\ElevenApiClient\Enums\LatencyOptimizationEnum;
use Georgehadjisavva\ElevenApiClient\Enums\VoicesEnum;
use Georgehadjisavva\ElevenApiClient\Exceptions\UnauthorizedException;
use Georgehadjisavva\ElevenApiClient\Interfaces\ElevenClientInterface;
use Georgehadjisavva\ElevenApiClient\Responses\ErrorResponse;
use Georgehadjisavva\ElevenApiClient\Responses\SuccessResponse;
use GuzzleHttp\Client;


class ElevenApiClient implements ElevenClientInterface
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

    /**
     * Get the list of voices.
     *
     * @return array The list of voices.
    */
    public function getVoices() : array
    {
        $response = $this->httpClient->get('voices');
        $data = json_decode($response->getBody(), true);
        return $data['voices'] ?? [];
    }

    public function generateVoice(string $content , string $voice_id = VoicesEnum::RACHEL, bool $optimize_latency = LatencyOptimizationEnum::DEFAULT):SuccessResponse|ErrorResponse {
        try {
            $response = $this->httpClient->post('text-to-speech/'. $voice_id,[
                'json' => [
                    'text' => $content,
                ],
            ]);
            
            $status = $response->getStatusCode();

            if($status === 200) {
                return new SuccessResponse($status, "Voice Succesfully Generated");
            } 
            
        } catch(Exception $e) {
            // Decode the JSON string into a PHP associative array
            $errorMessageException = json_encode($e->getMessage());
            $errorMessage          = new ErrorResponse($e->getCode(),$errorMessageException);

            return $errorMessage;
        }
    }
}
