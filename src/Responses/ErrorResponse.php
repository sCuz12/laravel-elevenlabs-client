<?php
declare(strict_types=1);

namespace Georgehadjisavva\ElevenApiClient\Responses;

class ErrorResponse {

    protected $status; 
    protected $message; 

    public function __construct(int $status , string $message)
    {
        $this->status  = $status;
        $this->message = $this->customMessage($status,$message);
    }

    public function customMessage(int $status, ?string $message) {
        switch ($status) {
            case 401: 
                return "Provided API key seems to be invalid , please check your Account api key and try again !";
            break;
            default : 
                return $message;
        }
    }

    public function getMessage() {
        return $this->message;
    }

    public function getResponse() : array {
        return [
            'status' => $this->status,
            'message' => $this->message
        ];
    }
}