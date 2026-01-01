<?php
// Create SQLite-compatible schema for local development
require_once __DIR__ . '../../../config/db.php';

try {
    $pdo->exec('PRAGMA foreign_keys = ON');

    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        full_name TEXT,
        email TEXT UNIQUE,
        phone TEXT,
        address TEXT,
        city TEXT,
        zip_code TEXT,
        password_hash TEXT,
        role TEXT DEFAULT 'member',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );");

    $pdo->exec("CREATE TABLE IF NOT EXISTS waste_types (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT,
        price_per_kg INTEGER,
        point_per_kg INTEGER
    );");

    $pdo->exec("CREATE TABLE IF NOT EXISTS waste_transactions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER,
        total_weight REAL,
        total_price INTEGER,
        total_points INTEGER,
        status TEXT DEFAULT 'pending',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    );");

    $pdo->exec("CREATE TABLE IF NOT EXISTS waste_transaction_items (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        transaction_id INTEGER,
        waste_type_id INTEGER,
        weight REAL,
        price INTEGER,
        points INTEGER,
        FOREIGN KEY (transaction_id) REFERENCES waste_transactions(id)
    );");

    $pdo->exec("CREATE TABLE IF NOT EXISTS wallets (
        user_id INTEGER PRIMARY KEY,
        cash_balance INTEGER DEFAULT 0,
        total_points INTEGER DEFAULT 0,
        FOREIGN KEY (user_id) REFERENCES users(id)
    );");

    $pdo->exec("CREATE TABLE IF NOT EXISTS pickups (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER,
        pickup_date TEXT,
        time_slot TEXT,
        estimated_weight REAL,
        types TEXT,
        status TEXT DEFAULT 'pending',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    );");

    echo "SQLite schema created\n";
} catch (Exception $e) {
    echo "Schema creation error: " . $e->getMessage() . "\n";
    exit(1);
}
