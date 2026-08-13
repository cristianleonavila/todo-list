<?php

namespace App\Infrastructure\Http\Controller;

use App\Infrastructure\Http\Request;
use App\Infrastructure\Http\Response;
use App\Application\User\RegisterUser;

class UserController
{

    public function __construct(
        private RegisterUser $registerUser
    )
    {}

    public function create(
        Request $request
    ): Response {
        $body = $request->getBody();
        $user = $this->registerUser->execute($body['username'], $body['password']);
        return new Response([
            'message' => 'User created!',
            'id' => $user->getId()
        ]);
    }
}
