<?php
declare(strict_types=1);

namespace Georgehadjisavva\ElevenApiClient\Responses;

class SuccessResponse {

    protected $status ;

    protected $message;


    public function __construct(int $status , string $message)
    {
        $this->status  = $status;
        $this->message = $message;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getMessage()
    {
        return $this->message;
    }


    public function getResponse():array {
        return [
            'status' => $this->status,
            'message' => $this->message,
        ];
    }
}