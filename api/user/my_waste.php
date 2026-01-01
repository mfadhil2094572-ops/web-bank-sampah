<?php
require_once __DIR__ . '/../../app/middleware/auth.php';
require_login();
$user = bs_get_current_user();
if (!$user) { http_response_code(401); echo json_encode(['success'=>false,'message'=>'Unauthorized']); exit; }

$isJson = (strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false) || (!empty($_SERVER['HTTP_X_REQUESTED_WITH']));

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $q = trim($_GET['q'] ?? '');
        $status = trim($_GET['status'] ?? '');
        $sql = 'SELECT wti.id, wti.transaction_id, wti.waste_type_id, wt.name as waste_name, wti.weight, wti.price, wti.points, trx.status, trx.created_at
                FROM waste_transaction_items wti
                JOIN waste_transactions trx ON wti.transaction_id = trx.id
                JOIN waste_types wt ON wti.waste_type_id = wt.id
                WHERE trx.user_id = ?';
        $params = [$user['id']];
        if ($q !== '') { $sql .= ' AND wt.name LIKE ?'; $params[] = "%$q%"; }
        if ($status !== '' && in_array($status, ['pending','approved','rejected'])) { $sql .= ' AND trx.status = ?'; $params[] = $status; }
        $sql .= ' ORDER BY trx.created_at DESC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();
        header('Content-Type: application/json');
        echo json_encode(['success'=>true,'data'=>$rows]);
        exit;
    }

    // POST actions: update/delete
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        if ($action === 'update') {
            $itemId = intval($_POST['id'] ?? 0);
            $newWeight = floatval($_POST['weight'] ?? 0);
            if (!$itemId || $newWeight <= 0) throw new Exception('Invalid input');

            // Verify ownership and pending status
            $stmt = $pdo->prepare('SELECT wti.*, trx.status FROM waste_transaction_items wti JOIN waste_transactions trx ON wti.transaction_id = trx.id WHERE wti.id = ? AND trx.user_id = ?');
            $stmt->execute([$itemId, $user['id']]);
            $item = $stmt->fetch();
            if (!$item) throw new Exception('Item tidak ditemukan');
            if ($item['status'] !== 'pending') throw new Exception('Hanya item dengan status pending dapat diubah');

            // Recalculate price and points from waste_types
            $stmt = $pdo->prepare('SELECT price_per_kg, point_per_kg FROM waste_types WHERE id = ?');
            $stmt->execute([$item['waste_type_id']]);
            $wt = $stmt->fetch();
            if (!$wt) throw new Exception('Jenis sampah tidak ada');
            $price = (int)round($wt['price_per_kg'] * $newWeight);
            $points = (int)round($wt['point_per_kg'] * $newWeight);

            $pdo->beginTransaction();
            $pdo->prepare('UPDATE waste_transaction_items SET weight = ?, price = ?, points = ? WHERE id = ?')->execute([$newWeight, $price, $points, $itemId]);

            // Recalc transaction totals
            $stmt = $pdo->prepare('SELECT IFNULL(SUM(price),0) as total_price, IFNULL(SUM(points),0) as total_points, IFNULL(SUM(weight),0) as total_weight FROM waste_transaction_items WHERE transaction_id = ?');
            $stmt->execute([$item['transaction_id']]);
            $tot = $stmt->fetch();
            $pdo->prepare('UPDATE waste_transactions SET total_price = ?, total_points = ?, total_weight = ? WHERE id = ?')->execute([$tot['total_price'], $tot['total_points'], $tot['total_weight'], $item['transaction_id']]);
            $pdo->commit();

            echo json_encode(['success'=>true,'message'=>'Item diperbarui','item'=>['id'=>$itemId,'weight'=>$newWeight,'price'=>$price,'points'=>$points]]);
            exit;
        }

        if ($action === 'delete') {
            $itemId = intval($_POST['id'] ?? 0);
            if (!$itemId) throw new Exception('Invalid id');
            $stmt = $pdo->prepare('SELECT wti.transaction_id, trx.status FROM waste_transaction_items wti JOIN waste_transactions trx ON wti.transaction_id = trx.id WHERE wti.id = ? AND trx.user_id = ?');
            $stmt->execute([$itemId, $user['id']]);
            $item = $stmt->fetch();
            if (!$item) throw new Exception('Item tidak ditemukan');
            if ($item['status'] !== 'pending') throw new Exception('Hanya item pending dapat dihapus');

            $pdo->beginTransaction();
            $pdo->prepare('DELETE FROM waste_transaction_items WHERE id = ?')->execute([$itemId]);
            // recalc
            $stmt = $pdo->prepare('SELECT IFNULL(SUM(price),0) as total_price, IFNULL(SUM(points),0) as total_points, IFNULL(SUM(weight),0) as total_weight, COUNT(*) as cnt FROM waste_transaction_items WHERE transaction_id = ?');
            $stmt->execute([$item['transaction_id']]);
            $tot = $stmt->fetch();
            if ($tot['cnt'] == 0) {
                // delete transaction
                $pdo->prepare('DELETE FROM waste_transactions WHERE id = ?')->execute([$item['transaction_id']]);
            } else {
                $pdo->prepare('UPDATE waste_transactions SET total_price = ?, total_points = ?, total_weight = ? WHERE id = ?')->execute([$tot['total_price'], $tot['total_points'], $tot['total_weight'], $item['transaction_id']]);
            }
            $pdo->commit();

            echo json_encode(['success'=>true,'message'=>'Item dihapus']);
            exit;
        }
    }

    throw new Exception('Method not allowed');
} catch (Exception $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    http_response_code(400);
    echo json_encode(['success'=>false,'message'=>$e->getMessage()]);
    exit;
}

?>
