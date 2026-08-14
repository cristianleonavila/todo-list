<?php

declare(strict_types=1);

namespace App\Application\Todo;

final readonly class CreateTodoInput
{
    public function __construct(
        public string $title,
        public string $description
    ) {
    }
}