<?php
declare(strict_types=1);

namespace App\Infrastructure;

class ConnectionProvider
{
    public static function getConnection(): \PDO
    {
        return new \PDO('mysql:host=lecture-db;dbname=lecture', 'root', '1234');
    }
}