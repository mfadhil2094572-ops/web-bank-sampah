<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../config/db.php';

function require_login($role = null) {
    if (empty($_SESSION['user_id'])) {
        // not logged in -> for API/JSON requests return 401 JSON, otherwise redirect to login
        $acceptsJson = (strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false) || (!empty($_SERVER['HTTP_X_REQUESTED_WITH']));
        if ($acceptsJson) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }
        header('Location: /login');
        exit;
    }
    if ($role) {
        if (empty($_SESSION['role']) || $_SESSION['role'] !== $role) {
            http_response_code(403);
            echo 'Forbidden';
            exit;
        }
    }
}

// Provide a project-specific current user helper to avoid conflict with PHP's built-in get_current_user()
function bs_get_current_user() {
    global $pdo;
    if (empty($_SESSION['user_id'])) return null;
    $stmt = $pdo->prepare('SELECT id, full_name, email, role FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}

// Backwards-compatible alias only if the name is not already the built-in
if (!function_exists('get_current_user')) {
    function get_current_user() {
        return bs_get_current_user();
    }
}
