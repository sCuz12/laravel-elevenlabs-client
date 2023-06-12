<?php

declare(strict_types=1);

namespace Georgehadjisavva\ElevenLabsClient\TextToSpeech;

use Georgehadjisavva\ElevenLabsClient\Enums\LatencyOptimizationEnum;
use Georgehadjisavva\ElevenLabsClient\Enums\VoicesEnum;

interface TextToSpeechInterface {
    public function generate(string $content, string $voice_id = VoicesEnum::RACHEL, bool $optimize_latency = LatencyOptimizationEnum::DEFAULT) ;
}