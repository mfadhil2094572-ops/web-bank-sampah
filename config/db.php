<?php
$cfg = require __DIR__ . '/config_db.php';
try {
    $driver = $cfg['db_driver'] ?? 'sqlite';
    if ($driver === 'sqlite') {
        $path = $cfg['db_path'];
        $dsn = "sqlite:" . $path;
        $pdo = new PDO($dsn, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    } elseif ($driver === 'mysql' || $driver === 'pgsql') {
        $host = $cfg['db_host'] ?? '127.0.0.1';
        $port = $cfg['db_port'] ? ":{$cfg['db_port']}" : '';
        $charset = $cfg['db_charset'] ?? 'utf8mb4';
        if ($driver === 'mysql') {
            $dsn = "mysql:host={$host}{$port};dbname={$cfg['db_name']};charset={$charset}";
        } else {
            $dsn = "pgsql:host={$host}{$port};dbname={$cfg['db_name']}";
        }
        $pdo = new PDO($dsn, $cfg['db_user'] ?? null, $cfg['db_pass'] ?? null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    } else {
        throw new Exception('Unsupported DB driver: ' . $driver);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo "Database connection error: " . htmlspecialchars($e->getMessage());
    exit;
}
