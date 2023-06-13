<?php

declare(strict_types=1);

namespace Georgehadjisavva\ElevenLabsClient\Models;

use Exception;
use Georgehadjisavva\ElevenLabsClient\Interfaces\ElevenLabsClientInterface;
use Georgehadjisavva\ElevenLabsClient\Traits\ExceptionHandlerTrait;

class Models implements ModelsInterface
{
    use ExceptionHandlerTrait;

    protected $client;


    public function __construct(ElevenLabsClientInterface $client)
    {
        $this->client = $client->getHttpClient();    
    }

    /**
     * Gets a list of available models. (eleven_monolingual_v1,eleven_multilingual_v1)
     *
     * @return array All available models
     * 
     * See : https://docs.elevenlabs.io/api-reference/models-get
     */
    public function getModels(): array {
        try {
            $response    = $this->client->get('models');
            $data        = $response->getBody()->getContents();
            $decodedData = json_decode($data, true);

            return $decodedData ?? [];
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

}
