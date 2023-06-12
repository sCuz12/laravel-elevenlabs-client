<?php
declare(strict_types=1);

namespace Georgehadjisavva\ElevenLabsClient\Voice;

use Exception;
use Georgehadjisavva\ElevenLabsClient\Responses\ErrorResponse;
use Georgehadjisavva\ElevenLabsClient\Interfaces\ElevenLabsClientInterface;
use Georgehadjisavva\ElevenLabsClient\Traits\ExceptionHandlerTrait;

class Voice implements VoiceInterface
{
    use ExceptionHandlerTrait;
    protected $client;

    public function __construct(ElevenLabsClientInterface $client)
    {
        $this->client = $client->getHttpClient();
    }

    /**
     * Retrieve all the available voices
     *
     * @return array The list of voices.
     */
    public function getAll(): array
    {
        try {
            $response = $this->client->get('voices');
            $data     = json_decode($response->getBody(), true);
            return $data['voices'] ?? [];
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Returns metadata about a specific voice.
     *
     * @return array metadata of voice
     */
    public function getVoice(string $voice_id): array
    {
        try {
            $response = $this->client->get('voices/'.$voice_id);
            $data     = json_decode($response->getBody(), true);
            return $data;

        } catch ( Exception $e){
            return $this->handleException($e);
        }
    }



     /**
     * Gets the default settings for voices. "similarity_boost" corresponds to"Clarity + Similarity Enhancement" 
     * in the web app and "stability" corresponds to "Stability" slider in the web ap
     *
     * @return array The list of voices.
     */
    public function defaultSettings() {
        try {
            $response = $this->client->get('voices/settings/default');
            $data     = json_decode($response->getBody(), true);

            return $data;
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Gets the default settings for voices. "similarity_boost" corresponds to"Clarity + Similarity Enhancement" 
     * in the web app and "stability" corresponds to "Stability" slider in the web ap
     *
     * @return array The list of voices.
     */
    public function voiceSettings(string $voice_id) {
        if(empty($voice_id)) {
            return (new ErrorResponse(400,"voice_id is missing"));
        }

        try {
            $response = $this->client->get('voices/'.$voice_id.'/settings');
            $data     = json_decode($response->getBody(), true);

            return $data;
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}