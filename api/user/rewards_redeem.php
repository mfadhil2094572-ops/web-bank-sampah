<?php
require_once __DIR__ . '/../../app/middleware/auth.php';
require_login();

$user = bs_get_current_user();
if (!$user) { http_response_code(401); header('Content-Type: application/json'); echo json_encode(['success' => false, 'message' => 'Unauthorized']); exit; }

header('Content-Type: application/json');

$points = intval($_POST['points'] ?? 0);
$creditCash = intval($_POST['credit_cash'] ?? 0); // optional cash to add when redeeming

if ($points <= 0) {
    $msg = 'Jumlah poin tidak valid';
    echo json_encode(['success'=>false,'message'=>$msg]); exit;
}

try {
    // Lock wallet row and check points
    $pdo->beginTransaction();
    $stmt = $pdo->prepare('SELECT total_points, cash_balance FROM wallets WHERE user_id = ? FOR UPDATE');
    $stmt->execute([$user['id']]);
    $wallet = $stmt->fetch();
    if (!$wallet) throw new Exception('Wallet tidak ditemukan');
    if ($wallet['total_points'] < $points) throw new Exception('Poin tidak cukup');

    $newPoints = $wallet['total_points'] - $points;
    $newCash = $wallet['cash_balance'] + $creditCash;
    $pdo->prepare('UPDATE wallets SET total_points = ?, cash_balance = ? WHERE user_id = ?')->execute([$newPoints, $newCash, $user['id']]);
    $pdo->commit();

    $msg = 'Penukaran poin berhasil';
    echo json_encode(['success'=>true,'message'=>$msg,'remaining_points'=>$newPoints,'cash_balance'=>$newCash]); exit;
} catch (Exception $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    http_response_code(400);
    $msg = $e->getMessage();
    echo json_encode(['success'=>false,'message'=>$msg]); exit;
}

?>
