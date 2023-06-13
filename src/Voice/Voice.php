<?php

declare(strict_types=1);

namespace Georgehadjisavva\ElevenLabsClient\Voice;

use Exception;
use Georgehadjisavva\ElevenLabsClient\Responses\ErrorResponse;
use Georgehadjisavva\ElevenLabsClient\Interfaces\ElevenLabsClientInterface;
use Georgehadjisavva\ElevenLabsClient\Responses\SuccessResponse;
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
     * 
     * See: https://docs.elevenlabs.io/api-reference/voices
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
     * 
     * See: https://docs.elevenlabs.io/api-reference/voices-get
     */
    public function getVoice(string $voice_id): array
    {
        try {
            $response = $this->client->get('voices/' . $voice_id);
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
     * 
     * See: https://docs.elevenlabs.io/api-reference/voices-settings-default
     */
    public function defaultSettings()
    {
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
     * 
     * See: https://docs.elevenlabs.io/api-reference/voices-settings
     */
    public function voiceSettings(string $voice_id)
    {
        if (empty($voice_id)) {
            return (new ErrorResponse(400, "voice_id is missing"));
        }

        try {
            $response = $this->client->get('voices/' . $voice_id . '/settings');
            $data     = json_decode($response->getBody(), true);

            return $data;
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

      /**
     * Add a new voice to your collection of voices in VoiceLab.
     *
     * @return array status,message
     * 
     * See: https://docs.elevenlabs.io/api-reference/voices-add
     */
    public function addVoice(string $name, ?string $description, string $files, ?string $labels = "American")
    {
        try {

            $requestData = [
                [
                    'name' => 'name',
                    'contents' => $name,
                ],
                [
                    'name' => 'files',
                    'contents' => fopen($files, 'r'),
                ],
                [
                    'name' => 'description',
                    'contents' => $description,
                ],
                [
                    'name' => 'labels',
                    'contents' => '{"accent":"'.$labels.'"}',
                ],
            ];

            $response = $this->client->post('voices/add', [
                'multipart' => $requestData,
            ]);

            $status = $response->getStatusCode();

            if ($status === 200) {
                return (new SuccessResponse($status, "Your Custom Voice Succesfully Created"))->getResponse();
            }
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }
}
