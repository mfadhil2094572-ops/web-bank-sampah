<?php
require_once __DIR__ . '/../../app/middleware/auth.php';
require_once __DIR__ . '/../../config/db.php';
require_login('admin');

header('Content-Type: application/json');

$txId = $_POST['transaction_id'] ?? null;
$action = $_POST['action'] ?? null; // approve or reject
if (!$txId || !$action) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM waste_transactions WHERE id = ?');
$stmt->execute([$txId]);
$tx = $stmt->fetch();
if (!$tx) { http_response_code(404); echo json_encode(['success'=>false,'message'=>'Not found']); exit; }
if ($tx['status'] !== 'pending') { echo json_encode(['success'=>false,'message'=>'Already processed']); exit; }

try {
    $pdo->beginTransaction();
    if ($action === 'approve') {
        // update transaction status
        $u = $pdo->prepare('UPDATE waste_transactions SET status = "approved" WHERE id = ?');
        $u->execute([$txId]);

        // credit wallet
        $w = $pdo->prepare('SELECT * FROM wallets WHERE user_id = ? FOR UPDATE');
        $w->execute([$tx['user_id']]);
        $wallet = $w->fetch();
        if (!$wallet) {
            $ins = $pdo->prepare('INSERT INTO wallets (user_id, cash_balance, total_points) VALUES (?, ?, ?)');
            $ins->execute([$tx['user_id'], $tx['total_price'], $tx['total_points']]);
        } else {
            $up = $pdo->prepare('UPDATE wallets SET cash_balance = cash_balance + ?, total_points = total_points + ? WHERE user_id = ?');
            $up->execute([$tx['total_price'], $tx['total_points'], $tx['user_id']]);
        }
    } else {
        $u = $pdo->prepare('UPDATE waste_transactions SET status = "rejected" WHERE id = ?');
        $u->execute([$txId]);
    }
    $pdo->commit();
    echo json_encode(['success' => true, 'message' => 'Transaction updated']);
    exit;
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['success'=>false,'message'=>'Could not update transaction']);
    exit;
}
