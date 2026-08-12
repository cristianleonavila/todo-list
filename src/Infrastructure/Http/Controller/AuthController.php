<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\User\LoginUser;
use App\Infrastructure\Http\Request;
use App\Infrastructure\Http\Response;

class AuthController
{
    public function __construct(
        private LoginUser $loginUser
    ) {
    }

    public function login(Request $request): Response
    {
        $input = $request->getBody();

        $username = $input['username'] ?? '';
        $password = $input['password'] ?? '';

        $user = $this->loginUser->execute(
            $username,
            $password
        );

        return new Response([
            'user' => [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
            ]
        ]);
    }
}