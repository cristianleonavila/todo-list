<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\Security\Exception\InvalidCredentialsException;

class ExceptionHandler
{
    public function handle(\Throwable $exception): Response
    {
        if ($exception instanceof InvalidCredentialsException) {
            return new Response(
                [
                    'error' => 'Invalid credentials'
                ],
                401
            );
        }

        return new Response(
            [
                'error' => 'Internal server error'
            ],
            500
        );
    }
}