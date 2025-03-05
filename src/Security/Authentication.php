<?php

namespace App\Security;

final readonly class Authentication
{
    private const string SESSION_COOKIE_NAME = '__SIDmsFyt6gRAkLq';

    public function hasSession(): bool
    {
        return !empty($_SESSION[self::SESSION_COOKIE_NAME] ?? '');
    }

    public function getSession(): string
    {
        return $_SESSION[self::SESSION_COOKIE_NAME] ?? $this->generateSession();
    }

    private function generateSession(): string
    {
        $_SESSION[self::SESSION_COOKIE_NAME] = uniqid();

        return $_SESSION[self::SESSION_COOKIE_NAME];
    }
}