<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

/** Fournit la connexion PDO unique de l'application. */
final class Database
{
    private static ?PDO $pdo = null;

    /** Injecte une connexion (utilisé par les tests). */
    public static function setConnection(PDO $pdo): void
    {
        self::$pdo = $pdo;
    }

    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            /** @var array{db_host: string, db_name: string, db_user: string, db_pass: string} $c */
            $c = require dirname(__DIR__, 2) . '/config/config.php';
            $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $c['db_host'], $c['db_name']);
            self::$pdo = new PDO($dsn, $c['db_user'], $c['db_pass'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }

        return self::$pdo;
    }
}
