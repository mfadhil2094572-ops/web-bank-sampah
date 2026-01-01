<?php
$cfg = require __DIR__ . '/config_db.php';
try {
    if (isset($cfg['db_driver']) && $cfg['db_driver'] === 'sqlite') {
        $path = $cfg['db_path'];
        $dsn = "sqlite:" . $path;
        $pdo = new PDO($dsn, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    } else {
        $dsn = "mysql:host={$cfg['db_host']};dbname={$cfg['db_name']};charset={$cfg['db_charset']}";
        $pdo = new PDO($dsn, $cfg['db_user'], $cfg['db_pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo "Database connection error: " . htmlspecialchars($e->getMessage());
    exit;
}
