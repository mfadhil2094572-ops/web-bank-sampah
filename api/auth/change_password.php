<?php
require_once __DIR__ . '/../../app/middleware/auth.php';
require_login();
$user = bs_get_current_user();
if (!$user) { http_response_code(401); header('Content-Type: application/json'); echo json_encode(['success'=>false,'message'=>'Unauthorized']); exit; }

header('Content-Type: application/json');
$current = $_POST['current_password'] ?? '';
$new = $_POST['new_password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';

if (!$current || !$new) {
    $msg = 'Field tidak lengkap';
    echo json_encode(['success'=>false,'message'=>$msg]); exit;
}
if ($new !== $confirm) {
    $msg = 'Konfirmasi password tidak cocok';
    echo json_encode(['success'=>false,'message'=>$msg]); exit;
}

try {
    $stmt = $pdo->prepare('SELECT password_hash FROM users WHERE id = ?');
    $stmt->execute([$user['id']]);
    $row = $stmt->fetch();
    if (!$row || !password_verify($current, $row['password_hash'])) {
        throw new Exception('Password saat ini salah');
    }
    $hash = password_hash($new, PASSWORD_DEFAULT);
    $pdo->prepare('UPDATE users SET password_hash = ? WHERE id = ?')->execute([$hash, $user['id']]);
    $msg = 'Password berhasil diubah';
    echo json_encode(['success'=>true,'message'=>$msg]); exit;
} catch (Exception $e) {
    $msg = $e->getMessage();
    echo json_encode(['success'=>false,'message'=>$msg]); exit;
}

?>
