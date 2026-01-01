<?php
// Database configuration — update these values for your environment
return [
    // Supported drivers: 'mysql' or 'sqlite'
    'db_driver' => 'sqlite',

    // MySQL settings (used when db_driver = 'mysql')
    'db_host' => '127.0.0.1',
    'db_name' => 'bank_sampah',
    'db_user' => 'root',
    'db_pass' => '',
    'db_charset' => 'utf8mb4',

    // SQLite settings (used when db_driver = 'sqlite')
    // path is relative to project root
    'db_path' => __DIR__ . '/../database/database.sqlite',
];
