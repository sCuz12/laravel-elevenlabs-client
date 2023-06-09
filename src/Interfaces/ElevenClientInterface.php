<?php 

namespace Georgehadjisavva\ElevenApiClient\Interfaces;

interface ElevenClientInterface {
    public function getVoices();
    public function generateVoice(string $content, string $voice_id, bool $optimize_latency);
    public function getModels();
}
?>