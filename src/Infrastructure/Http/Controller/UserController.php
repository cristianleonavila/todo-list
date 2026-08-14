<?php

namespace App\Infrastructure\Http\Controller;

use App\Infrastructure\Http\Request;
use App\Infrastructure\Http\Response;
use App\Application\User\RegisterUser;
use App\Application\User\RegisterUserInput;

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
        if (
            !isset($body['username']) ||
            !is_string($body['username']) ||
            !isset($body['password']) ||
            !is_string($body['password'])
        ) {
            return new Response([
                'message' => 'Bad Request'
            ], 400);            
        }        
        $user = $this->registerUser->execute(
            new RegisterUserInput($body['username'], $body['password'])
        );
        return new Response([
            'message' => 'User created!',
            'id' => $user->getId()
        ]);
    }
}
