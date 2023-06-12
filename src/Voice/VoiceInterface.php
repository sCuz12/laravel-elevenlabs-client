<?php
namespace Georgehadjisavva\ElevenLabsClient\Voice;

interface VoiceInterface {
    public function getAll();
    public function defaultSettings();
    public function voiceSettings(string $voice_id);
    public function getVoice(string $voice_id);
}
