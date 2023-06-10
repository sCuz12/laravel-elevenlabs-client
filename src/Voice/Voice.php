<?php
namespace Georgehadjisavva\ElevenApiClient\Voice;

use Exception;
use Georgehadjisavva\ElevenApiClient\Interfaces\ElevenClientInterface;
use Georgehadjisavva\ElevenApiClient\Responses\ErrorResponse;


class Voice implements VoiceInterface
{
    protected $client;

    public function __construct(ElevenClientInterface $client)
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
            $body = json_decode($e->getResponse()->getBody());

            if (isset($body->detail->message)) {
                $errorMessage = $body->detail->message;
            }

            return (new ErrorResponse($e->getCode(), $errorMessage  ))->getResponse();
        }
    }

    /**
     * Returns metadata about a specific voice.
     *
     * @return array metadata of voice
    */
    public function getVoice(): array
    {
        //TODO:
       return [];
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
            
            $body = json_decode($e->getResponse()->getBody());
        
            if (isset($body->detail->message)) {
                $errorMessage = $body->detail->message;
            }

            return (new ErrorResponse($e->getCode(), $errorMessage))->getResponse();
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
            $body = json_decode($e->getResponse()->getBody());
        
            if (isset($body->detail->message)) {
                $errorMessage = $body->detail->message;
            }

            return (new ErrorResponse($e->getCode(), $errorMessage))->getResponse();
        }
    }
}