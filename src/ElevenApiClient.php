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
     * Retrieve all the available voices
     *
     * @return array The list of voices.
    */
    public function getVoices() : array
    {
        $response = $this->httpClient->get('voices');
        $data = json_decode($response->getBody(), true);
        return $data['voices'] ?? [];
    }

    /**
     * Generate a voice based on the provided content.
     *
     * @param string $content The content for voice generation.
     * @param string $voice_id The ID of the voice to use (default: 21m00Tcm4TlvDq8ikWAM ).
     * @param bool $optimize_latency Whether to optimize for latency (default: 0 ).
     *
     * @return SuccessResponse|ErrorResponse The generated voice response.
     */
    public function generateVoice(string $content , string $voice_id = VoicesEnum::RACHEL, bool $optimize_latency = LatencyOptimizationEnum::DEFAULT):array|ErrorResponse {
        try {
            $response = $this->httpClient->post('text-to-speech/'. $voice_id,[
                'json' => [
                    'text' => $content,
                ],
            ]);
            
            $status = $response->getStatusCode();

            if($status === 200) {
                return (new SuccessResponse($status, "Voice Succesfully Generated"))->getResponse();
            } 
            
        } catch(Exception $e) {
            // Decode the JSON string into a PHP associative array
            $errorMessageException = json_encode($e->getMessage());
            $errorMessage          = (new ErrorResponse($e->getCode(),$errorMessageException))->getResponse();

            return $errorMessage;
        }
    }
}
