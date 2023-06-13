<?php
declare(strict_types=1);

namespace Georgehadjisavva\ElevenLabsClient\User;

interface UserInterface {
    public function getUserInfo();
    public function getUserSubscription();
}