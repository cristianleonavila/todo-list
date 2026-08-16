<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

final class Cors
{
    private const ALLOWED_ORIGIN = 'http://localhost:4200';

    public static function handle(): void
    {
        header('Access-Control-Allow-Origin: ' . self::ALLOWED_ORIGIN);
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, Accept");
        header('Vary: Origin');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204);
            exit;
        }
    }
}