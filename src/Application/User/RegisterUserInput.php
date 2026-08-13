<?php

declare(strict_types=1);

namespace App\Application\User;

final readonly class RegisterUserInput
{
    public function __construct(
        public string $username,
        public string $password
    ) {
    }
}