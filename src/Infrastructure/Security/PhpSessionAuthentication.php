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

    public function logout() {
        $this->sessionDestroy();
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
                'cookie_secure'   => true,
                'cookie_samesite' => 'None;Partitioned',
            ])) {
                $error = implode(",", error_get_last());
                throw new \RuntimeException($error);
            } 
        }
    }

    private function sessionDestroy() {
        $this->sessionStart();
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }
}