<?php 
namespace Georgehadjisavva\ElevenLabsClient\Exceptions;

use Exception;

class UnauthorizedException extends Exception
{
    public function __construct($message = "Provided API key seems to be invalid , please check your Account api key and try again !", $code = 401, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}