<?php
require_once __DIR__ . '/../../config/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$acceptsJson = (strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false) || (!empty($_SERVER['HTTP_X_REQUESTED_WITH'] ?? ''));

$full_name = trim($_POST['fullName'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$address = trim($_POST['address'] ?? '');
$city = trim($_POST['city'] ?? '');
$zip = trim($_POST['zipCode'] ?? '');
$password = $_POST['password'] ?? '';

if (!$full_name || !$email || !$password) {
    if ($acceptsJson) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['success'=>false,'message'=>'Missing fields']);
        exit;
    }
    $_SESSION['flash_error'] = 'Semua field wajib diisi.';
    header('Location: /register');
    exit;
}

// basic validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    if ($acceptsJson) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['success'=>false,'message'=>'Invalid email']);
        exit;
    }
    $_SESSION['flash_error'] = 'Email tidak valid.';
    header('Location: /register');
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);
try {
    $stmt = $pdo->prepare('INSERT INTO users (full_name, email, phone, address, city, zip_code, password_hash, role) VALUES (?, ?, ?, ?, ?, ?, ?, "member")');
    $stmt->execute([$full_name, $email, $phone, $address, $city, $zip, $hash]);
    $userId = $pdo->lastInsertId();

    $w = $pdo->prepare('INSERT INTO wallets (user_id, cash_balance, total_points) VALUES (?, 0, 0)');
    $w->execute([$userId]);

    $msg = 'Akun berhasil dibuat. Silakan masuk menggunakan email dan password Anda.';
    if ($acceptsJson) {
        header('Content-Type: application/json');
        echo json_encode(['success'=>true,'message'=>$msg, 'redirect' => '/login']);
        exit;
    }
    $_SESSION['flash_success'] = $msg;
    header('Location: /login');
    exit;
} catch (PDOException $e) {
    if ($e->errorInfo[1] === 1062) {
        if ($acceptsJson) {
            http_response_code(409);
            header('Content-Type: application/json');
            echo json_encode(['success'=>false,'message'=>'Email sudah terdaftar']);
            exit;
        }
        $_SESSION['flash_error'] = 'Email sudah terdaftar';
        header('Location: /register');
        exit;
    }
    if ($acceptsJson) {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode(['success'=>false,'message'=>'Server error']);
        exit;
    }
    $_SESSION['flash_error'] = 'Terjadi kesalahan server.';
    header('Location: /register');
    exit;
}
