<?php 

namespace Georgehadjisavva\ElevenApiClient\Interfaces;

interface ElevenClientInterface {
    public function getHttpClient();
    public function voices();
}
?>