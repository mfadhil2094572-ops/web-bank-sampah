<?php
// Database configuration. Prefer environment variables for production.
// If no env vars are set, the file falls back to a local sqlite database.
return [
    // Supported drivers: 'mysql', 'pgsql' or 'sqlite'. Default: sqlite for local dev.
    'db_driver' => getenv('DB_DRIVER') ?: 'sqlite',

    // MySQL / PostgreSQL settings (used when db_driver = 'mysql' or 'pgsql')
    'db_host' => getenv('DB_HOST') ?: '127.0.0.1',
    'db_port' => getenv('DB_PORT') ?: null,
    'db_name' => getenv('DB_NAME') ?: 'bank_sampah',
    'db_user' => getenv('DB_USER') ?: 'root',
    'db_pass' => getenv('DB_PASS') ?: '',
    'db_charset' => getenv('DB_CHARSET') ?: 'utf8mb4',

    // SQLite settings (used when db_driver = 'sqlite')
    // path is relative to project root
    'db_path' => getenv('DB_PATH') ?: (__DIR__ . '/../database/database.sqlite'),
];
