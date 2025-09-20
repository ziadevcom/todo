<?php

namespace App\Core\Database;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $db = null;

    public static function connect(): PDO
    {
        try {

            if (self::$db === null) {
                $dsn = 'sqlite:' . __DIR__ . '/../../../database/db.sq3';
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false

                ];
                self::$db = new PDO(dsn: $dsn, options: $options);
            }

            return self::$db;
        } catch (PDOException $e) {
            throw new PDOException(
                'Could not connect to database: ' . $e->getMessage(),
                (int)$e->getCode()
            );
        }
    }
}
