<?php

declare(strict_types=1);

namespace Georgehadjisavva\ElevenLabsClient\Traits;


use Exception;
use Georgehadjisavva\ElevenLabsClient\Responses\ErrorResponse;

trait ExceptionHandlerTrait
{
    /**
     * Handle exceptions and return the error response.
     *
     * @param Exception $e The exception to handle.
     * @return array The error response.
     */
    protected function handleException(Exception $e): array
    {
        $errorMessage = 'An unexpected error occurred.';
        if ($e->getResponse() !== null) {
            $body = $e->getResponse()->getBody()->getContents();
            $decodedBody = json_decode($body);

            if (isset($decodedBody->detail->message)) {
                $errorMessage = $decodedBody->detail->message;
            }
        }

        return (new ErrorResponse($e->getCode(), $errorMessage))->getResponse();
    }
}
