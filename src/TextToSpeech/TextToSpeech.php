<?php

declare(strict_types=1);

namespace Georgehadjisavva\ElevenLabsClient\TextToSpeech;

use Exception;
use Georgehadjisavva\ElevenLabsClient\ElevenLabsClient;
use Georgehadjisavva\ElevenLabsClient\Enums\LatencyOptimizationEnum;
use Georgehadjisavva\ElevenLabsClient\Enums\VoicesEnum;
use Georgehadjisavva\ElevenLabsClient\Responses\ErrorResponse;
use Georgehadjisavva\ElevenLabsClient\Responses\SuccessResponse;

class TextToSpeech implements TextToSpeechInterface
{

    protected $client;

    public function __construct(ElevenLabsClient $client)
    {
        $this->client = $client->getHttpClient();
    }

    /**
     * Generate a voice based on the provided content.
     *
     * @param string $content The content for voice generation.
     * @param string $voice_id The ID of the voice to use (default: 21m00Tcm4TlvDq8ikWAM ).
     * @param bool $optimize_latency Whether to optimize for latency (default: 0 ).
     *
     * @return array status,message
     */
    public function generate(string $content, string $voice_id = VoicesEnum::RACHEL, bool $optimize_latency = LatencyOptimizationEnum::DEFAULT)
    {
        try {
            $response = $this->client->post('text-to-speech/' . $voice_id, [
                'json' => [
                    'text' => $content,
                ],
            ]);

            $status = $response->getStatusCode();

            if ($status === 200) {
                return (new SuccessResponse($status, "Voice Succesfully Generated"))->getResponse();
            }
        } catch (Exception $e) {
            // Decode the JSON string into a PHP associative array
            $body = json_decode($e->getResponse()->getBody()->getContents());

            $errorMessage = "Error while processing";

            if (isset($body->detail->message)) {
                $errorMessage = $body->detail->message;
            }

            return (new ErrorResponse($e->getCode(), $errorMessage  ))->getResponse();
        }
    }
}
