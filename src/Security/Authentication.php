<?php

namespace App\Security;

final readonly class Authentication
{
    private const string SESSION_COOKIE_NAME = '__SIDmsFyt6gRAkLq';

    public function isSessionValid(): bool
    {
        return !empty($_SESSION[self::SESSION_COOKIE_NAME] ?? '');
    }

    public function login(string $email): bool
    {
        $this->logout();

        // todo: store the email against the session id

        $_SESSION[self::SESSION_COOKIE_NAME] = $email;
    }

    public function logout(): void
    {
        $_SESSION[self::SESSION_COOKIE_NAME] = null;
    }
}