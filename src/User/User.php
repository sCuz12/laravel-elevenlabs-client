<?php

declare(strict_types=1);

namespace Georgehadjisavva\ElevenLabsClient\User;

use Exception;
use Georgehadjisavva\ElevenLabsClient\Interfaces\ElevenLabsClientInterface;
use Georgehadjisavva\ElevenLabsClient\Traits\ExceptionHandlerTrait;

class User implements UserInterface
{
    use ExceptionHandlerTrait;

    protected $client;


    public function __construct(ElevenLabsClientInterface $client)
    {
        $this->client = $client->getHttpClient();
    }

    /**
     * Gets information about the user
     *
     * @return array Info of current user
     * 
     * See : https://docs.elevenlabs.io/api-reference/user
     */
    public function getUserInfo(): array
    {
        try {
            $response    = $this->client->get('user');
            $data        = $response->getBody()->getContents();
            $decodedData = json_decode($data, true);

            return $decodedData ?? [];
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

     /**
     * Gets extended information about the users subscription
     *
     * @return array Info of current user subscription
     * 
     * See : https://docs.elevenlabs.io/api-reference/user-subscription
     */
    public function getUserSubscription(): array
    {
        try {
            $response    = $this->client->get('user/subscription');
            $data        = $response->getBody()->getContents();
            $decodedData = json_decode($data, true);

            return $decodedData ?? [];
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }


}
