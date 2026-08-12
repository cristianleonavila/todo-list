<?php

namespace App\Application\Security;

interface PasswordHasher
{
    public function hash($password);

    public function verify($password, $hash);
}