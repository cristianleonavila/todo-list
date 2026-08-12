<?php

namespace App\Infrastructure\Security;

use App\Application\Security\PasswordHasher;

class PhpPasswordHasher implements PasswordHasher
{
    public function hash($password)
    {
        return password_hash(
            $password,
            PASSWORD_DEFAULT
        );
    }

    public function verify($password, $hash)
    {
        return password_verify(
            $password,
            $hash
        );
    }
}