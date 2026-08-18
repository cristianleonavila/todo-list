<?php

namespace App\Application\Security;

use App\Application\Security\Exception\NotAuthenticatedException;
use App\Domain\User\User;
use App\Domain\User\UserRepository;

class WhoIAm
{

    public function __construct(
        private AuthenticationSession $auth,
        private UserRepository $userRepo
    ) {}

    /**
     * Undocumented function
     *
     * @return User
     */
    public function execute(): User{
        $userId = $this->auth->getCurrentUserId();
        if ( !$userId ) {
            throw new NotAuthenticatedException("Not authenticated");
        }
        $user = $this->userRepo->findById($userId);
        return $user;
    }
}
