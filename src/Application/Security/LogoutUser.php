<?php

namespace App\Application\Security;

use App\Infrastructure\Http\Response;

class LogoutUser {
    public function __construct(
        private AuthenticationSession $auth
    )
    {}

    public function execute() {
        $this->auth->logout();
        return new Response([
            'message' => 'Logged out'
        ]);
    }
}