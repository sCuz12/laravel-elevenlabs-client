<?php
declare(strict_types=1);

use Georgehadjisavva\ElevenLabsClient\Interfaces\ElevenLabsClientInterface;

class History implements HistoryInterface {

    protected $client ; 
    
    public function __construct(ElevenLabsClientInterface $client)
    {
      $this->client = $client->getHttpClient();  
    }

    public function getHistory() {

    }
    public function getHistoryItem() {

    }
    public function getHistoryItemAudi() {

    }
    public function deleteHistoryItem() {

    }
    public function downloadHistory() {

    }
}
