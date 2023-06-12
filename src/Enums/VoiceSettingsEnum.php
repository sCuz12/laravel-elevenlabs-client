<?php
declare(strict_types = 1);

namespace Georgehadjisavva\ElevenLabsClient\Enums;

abstract class VoiceSettingsEnum {
    public const STABILITY        = 'stability';
    public const SIMILARITY_BOOST = 'similarity_boost';

    public const ALLOWED_VOICESETTINGS = [
        SELF::SIMILARITY_BOOST,
        SELF::STABILITY,
    ];
    
}

