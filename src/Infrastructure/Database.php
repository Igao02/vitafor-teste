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
                image      TEXT DEFAULT '',
                url        TEXT DEFAULT '',
                active     INTEGER NOT NULL DEFAULT 1,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            );
        ");

        self::dropLegacyColumns($db);
        self::addMissingColumns($db);
    }

    private static function addMissingColumns(\PDO $db): void
    {
        $cols = array_column(
            $db->query('PRAGMA table_info(characters)')->fetchAll(),
            'name'
        );

        if (!in_array('active', $cols)) {
            $db->exec('ALTER TABLE characters ADD COLUMN active INTEGER NOT NULL DEFAULT 1');
        }
    }

    private static function dropLegacyColumns(\PDO $db): void
    {
        $cols = array_column(
            $db->query('PRAGMA table_info(characters)')->fetchAll(),
            'name'
        );

        if (empty(array_intersect($cols, ['gender', 'location']))) {
            return;
        }

        $db->exec('PRAGMA foreign_keys = OFF');
        $db->exec('DROP TABLE IF EXISTS characters_new');
        $db->exec('
            CREATE TABLE characters_new (
                id         INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id    INTEGER NOT NULL,
                api_id     INTEGER,
                name       TEXT NOT NULL,
                species    TEXT DEFAULT "",
                image      TEXT DEFAULT "",
                url        TEXT DEFAULT "",
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            )
        ');
        $db->exec('
            INSERT INTO characters_new (id, user_id, api_id, name, species, image, url, created_at, updated_at)
            SELECT id, user_id, api_id, name, species, image, url, created_at, updated_at
            FROM characters
        ');
        $db->exec('DROP TABLE characters');
        $db->exec('ALTER TABLE characters_new RENAME TO characters');
        $db->exec('PRAGMA foreign_keys = ON');
    }
}
