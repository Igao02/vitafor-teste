<?php

namespace App\Infrastructure;

use PDO;

class Database
{
    private static ?PDO $instance = null;

    public static function connection(): PDO
    {
        if (self::$instance === null) {
            $path = BASE_PATH . '/storage/database.sqlite';
            self::$instance = new PDO('sqlite:' . $path);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            self::$instance->exec('PRAGMA foreign_keys = ON;');
        }

        return self::$instance;
    }

    public static function migrate(): void
    {
        $db = self::connection();

        $db->exec("
            CREATE TABLE IF NOT EXISTS users (
                id         INTEGER PRIMARY KEY AUTOINCREMENT,
                name       TEXT NOT NULL,
                email      TEXT NOT NULL UNIQUE,
                password   TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS characters (
                id         INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id    INTEGER NOT NULL,
                api_id     INTEGER,
                name       TEXT NOT NULL,
                species    TEXT DEFAULT '',
                gender     TEXT DEFAULT '',
                location   TEXT DEFAULT '',
                image      TEXT DEFAULT '',
                url        TEXT DEFAULT '',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            );
        ");
    }
}
