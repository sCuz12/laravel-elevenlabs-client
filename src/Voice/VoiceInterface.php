<?php

namespace Georgehadjisavva\ElevenLabsClient\Voice;

interface VoiceInterface
{
    public function getAll();
    public function defaultSettings();
    public function voiceSettings(string $voice_id);
    public function getVoice(string $voice_id);
    public function addVoice(string $name, ?string $description, string $files, ?string $labels);
    public function editVoice(string $voice_id, string $name ,?string $description, ?string $files, ?string $labels);
    public function deleteVoice(string $voice_id) :array;
}
