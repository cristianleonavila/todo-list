<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\Security\Exception\InvalidCredentialsException;
use App\Application\Shared\Exception\ForbiddenException;
use App\Application\Todo\Exception\TodoNotFoundException;
use App\Application\User\Exception\UserAlreadyExistsException;

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

        if ($exception instanceof UserAlreadyExistsException) {
            return new Response(
                [
                    'error' => $exception->getMessage()
                ],
                409
            );
        }  
        
        if ( $exception instanceof TodoNotFoundException) {
            return new Response(
                [
                    'error' => $exception->getMessage()
                ],
                404
            );
        }

        if ( $exception instanceof ForbiddenException) {
            return new Response(
                [
                    'error' => $exception->getMessage()
                ],
                403
            );
        }        
        
        if ($exception instanceof \InvalidArgumentException) {
            return new Response(
                [
                    'error' => $exception->getMessage()
                ],
                400
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