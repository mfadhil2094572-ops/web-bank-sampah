<?php
require_once __DIR__ . '/../../app/middleware/auth.php';
require_login();
$user = bs_get_current_user();
if (!$user) { http_response_code(401); header('Content-Type: application/json'); echo json_encode(['success'=>false,'message'=>'Unauthorized']); exit; }

header('Content-Type: application/json');
$password = $_POST['password'] ?? '';
if (!$password) {
    $msg = 'Password konfirmasi dibutuhkan';
    echo json_encode(['success'=>false,'message'=>$msg]); exit;
}

try {
    $stmt = $pdo->prepare('SELECT password_hash FROM users WHERE id = ?');
    $stmt->execute([$user['id']]);
    $row = $stmt->fetch();
    if (!$row || !password_verify($password, $row['password_hash'])) {
        throw new Exception('Password tidak cocok');
    }

    $pdo->beginTransaction();
    $pdo->prepare('DELETE FROM wallets WHERE user_id = ?')->execute([$user['id']]);
    // delete transaction items and transactions
    $pdo->prepare('DELETE wti FROM waste_transaction_items wti JOIN waste_transactions wt ON wti.transaction_id = wt.id WHERE wt.user_id = ?')->execute([$user['id']]);
    $pdo->prepare('DELETE FROM waste_transactions WHERE user_id = ?')->execute([$user['id']]);
    $pdo->prepare('DELETE FROM users WHERE id = ?')->execute([$user['id']]);
    $pdo->commit();

    // destroy session
    session_unset(); session_destroy();

    $msg = 'Akun berhasil dihapus';
    echo json_encode(['success'=>true,'message'=>$msg, 'redirect' => '/']); exit;
} catch (Exception $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    $msg = $e->getMessage();
    echo json_encode(['success'=>false,'message'=>$msg]); exit;
}

?>
