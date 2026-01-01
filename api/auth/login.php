<?php
require_once __DIR__ . '/../../config/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$acceptsJson = (strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false) || (!empty($_SERVER['HTTP_X_REQUESTED_WITH'] ?? ''));

$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if (!$email || !$password) {
    if ($acceptsJson) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Missing credentials']);
        exit;
    }
    $_SESSION['flash_error'] = 'Email atau password harus diisi.';
    header('Location: /login');
    exit;
}

$stmt = $pdo->prepare('SELECT id, password_hash, role, full_name FROM users WHERE email = ?');
$stmt->execute([$email]);
$user = $stmt->fetch();
if (!$user || !password_verify($password, $user['password_hash'])) {
    if ($acceptsJson) {
        http_response_code(401);
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
        exit;
    }
    $_SESSION['flash_error'] = 'Email atau password salah.';
    header('Location: /login');
    exit;
}

// set session
$_SESSION['user_id'] = $user['id'];
$_SESSION['role'] = $user['role'];
$_SESSION['full_name'] = $user['full_name'];

// ensure wallet row exists
$w = $pdo->prepare('SELECT user_id FROM wallets WHERE user_id = ?');
$w->execute([$user['id']]);
if (!$w->fetch()) {
    $ins = $pdo->prepare('INSERT INTO wallets (user_id, cash_balance, total_points) VALUES (?, 0, 0)');
    $ins->execute([$user['id']]);
}

if ($acceptsJson) {
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'message' => 'Login successful', 'redirect' => '/dashboard']);
    exit;
}

// Non-AJAX: set flash and redirect to dashboard
$_SESSION['flash_success'] = 'Anda berhasil masuk.';
header('Location: /dashboard');
exit;
