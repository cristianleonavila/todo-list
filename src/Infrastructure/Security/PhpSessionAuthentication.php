<?php

namespace App\Infrastructure\Security;

use App\Application\Security\AuthenticationSession;
use App\Domain\User\User;

class PhpSessionAuthentication implements AuthenticationSession
{
    public function login(User $user)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION['user_id'] = $user->getId();
    }

    public function logout()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        unset($_SESSION['user_id']);
    }

    public function getCurrentUserId()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        return $_SESSION['user_id'] ?? null;
    }
}