<?php

namespace App\Application\Security;

class LogoutUser {
    public function __construct(
        private AuthenticationSession $auth
    )
    {}

    public function execute() {
        $this->auth->logout();
    }
}