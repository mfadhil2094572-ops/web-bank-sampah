<?php
require_once __DIR__ . '/../inc/db.php';
require_once __DIR__ . '/../inc/notify.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    http_response_code(403);
    echo json_encode(['success'=>false,'message'=>'Forbidden']);
    exit;
}

$action = $_POST['action'] ?? ($_GET['action'] ?? '');
header('Content-Type: application/json');
try {
    if ($action === 'approve_next_tx') {
        $stmt = $pdo->prepare('SELECT * FROM waste_transactions WHERE status = "pending" ORDER BY created_at ASC LIMIT 1');
        $stmt->execute();
        $tx = $stmt->fetch();
        if (!$tx) throw new Exception('No pending transaction');

        $pdo->beginTransaction();
        $u = $pdo->prepare('UPDATE waste_transactions SET status = "approved" WHERE id = ?');
        $u->execute([$tx['id']]);

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
        $pdo->commit();
        echo json_encode(['success'=>true,'message'=>'Transaction approved','id'=>$tx['id']]);
        exit;
    }

    if ($action === 'reject_next_tx') {
        $stmt = $pdo->prepare('SELECT * FROM waste_transactions WHERE status = "pending" ORDER BY created_at ASC LIMIT 1');
        $stmt->execute();
        $tx = $stmt->fetch();
        if (!$tx) throw new Exception('No pending transaction');
        $pdo->prepare('UPDATE waste_transactions SET status = "rejected" WHERE id = ?')->execute([$tx['id']]);
        echo json_encode(['success'=>true,'message'=>'Transaction rejected','id'=>$tx['id']]);
        exit;
    }

    if ($action === 'schedule_next_pickup' || $action === 'complete_next_pickup' || $action === 'cancel_next_pickup') {
        $stmt = $pdo->prepare('SELECT p.*, u.email, u.full_name FROM pickups p JOIN users u ON p.user_id = u.id WHERE p.status = "pending" ORDER BY p.created_at ASC LIMIT 1');
        $stmt->execute();
        $p = $stmt->fetch();
        if (!$p) throw new Exception('No pending pickup');
        $newStatus = 'scheduled';
        if ($action === 'complete_next_pickup') $newStatus = 'completed';
        if ($action === 'cancel_next_pickup') $newStatus = 'cancelled';
        $pdo->prepare('UPDATE pickups SET status = ? WHERE id = ?')->execute([$newStatus, $p['id']]);
        // notify user (best effort)
        $subject = 'Status Jemput Anda: ' . ucfirst($newStatus);
        $message = sprintf("Halo %s, permintaan jemput pada %s (%s) sekarang: %s", $p['full_name'] ?? '', $p['pickup_date'] ?? '', $p['time_slot'] ?? '', $newStatus);
        @bs_notify_user($p['email'] ?? '', $subject, $message);
        echo json_encode(['success'=>true,'message'=>'Pickup updated','id'=>$p['id'],'status'=>$newStatus]);
        exit;
    }

    throw new Exception('Unknown action');
} catch (Exception $e) {
    if ($pdo && $pdo->inTransaction()) $pdo->rollBack();
    http_response_code(400);
    echo json_encode(['success'=>false,'message'=>$e->getMessage()]);
    exit;
}

?>
