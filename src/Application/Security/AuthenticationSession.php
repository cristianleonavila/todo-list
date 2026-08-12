<?php

namespace App\Application\Security;

use App\Domain\User\User;

interface AuthenticationSession
{
    public function login(User $user);

    public function logout();

    public function getCurrentUserId();
}