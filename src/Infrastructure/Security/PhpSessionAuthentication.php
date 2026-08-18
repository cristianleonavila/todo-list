<?php

namespace App\Infrastructure\Security;

use App\Application\Security\AuthenticationSession;
use App\Domain\User\User;

class PhpSessionAuthentication implements AuthenticationSession
{
    public function login(User $user)
    {
        $this->sessionStart();
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['username'] = $user->getUsername();
    }

    public function logout()
    {
        $this->sessionStart();
        unset($_SESSION['user_id']);
    }

    public function getCurrentUserId()
    {
        $this->sessionStart();
        return $_SESSION['user_id'] ?? null;
    }

    private function sessionStart() {
        $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
        if (session_status() !== PHP_SESSION_ACTIVE) {
            if (!session_start([
                'cookie_httponly' => true,
                'cookie_secure'   => $secure,
                'cookie_samesite' => 'None;Partitioned',
            ])) {
                $error = implode(",", error_get_last());
                throw new \RuntimeException($error);
            } 
        }
    }
}