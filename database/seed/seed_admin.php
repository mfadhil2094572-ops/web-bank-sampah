<?php
// Run once to create an admin account. Delete or protect this file after use.
require_once __DIR__ . '../../../config/db.php';

$email = 'admin@gmail.com';
$password = 'admin123';
$name = 'Administrator';

$stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
$stmt->execute([$email]);
if ($stmt->fetch()) {
    echo "Admin already exists\n";
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);
$ins = $pdo->prepare('INSERT INTO users (full_name, email, phone, address, city, zip_code, password_hash, role) VALUES (?, ?, ?, ?, ?, ?, ?, "admin")');
$ins->execute([$name, $email, '', '', '', '', $hash]);
$id = $pdo->lastInsertId();
$w = $pdo->prepare('INSERT INTO wallets (user_id, cash_balance, total_points) VALUES (?, 0, 0)');
$w->execute([$id]);

echo "Created admin {$email} with password {$password}\n";
