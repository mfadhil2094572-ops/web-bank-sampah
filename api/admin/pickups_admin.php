<?php
require_once __DIR__ . '/../../app/middleware/auth.php';
require_once __DIR__ . '/../../app/Helpers/notify.php';
require_login('admin');
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $page = max(1, intval($_GET['page'] ?? 1));
        $perPage = max(1, min(100, intval($_GET['per_page'] ?? 20)));
        $q = trim($_GET['q'] ?? '');
        $status = trim($_GET['status'] ?? '');

        $where = [];
        $params = [];
        if ($q !== '') {
            $where[] = '(u.full_name LIKE ? OR u.email LIKE ? OR p.types LIKE ? )';
            $like = "%{$q}%";
            $params[] = $like; $params[] = $like; $params[] = $like;
        }
        if ($status !== '') {
            $where[] = 'p.status = ?';
            $params[] = $status;
        }

        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

        // total count
        $countSql = "SELECT COUNT(*) FROM pickups p JOIN users u ON p.user_id = u.id {$whereSql}";
        $stmt = $pdo->prepare($countSql);
        $stmt->execute($params);
        $total = intval($stmt->fetchColumn());

        $offset = ($page - 1) * $perPage;

        $sql = "SELECT p.*, u.full_name, u.email FROM pickups p JOIN users u ON p.user_id = u.id {$whereSql} ORDER BY p.created_at DESC LIMIT ? OFFSET ?";
        $stmt = $pdo->prepare($sql);
        $executeParams = array_merge($params, [$perPage, $offset]);
        $stmt->execute($executeParams);
        $rows = $stmt->fetchAll();

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $rows,
            'pagination' => [
                'total' => $total,
                'page' => $page,
                'per_page' => $perPage,
                'total_pages' => (int)ceil($total / $perPage)
            ]
        ]);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        $id = intval($_POST['id'] ?? 0);
        if (!$id) throw new Exception('ID tidak valid');

        if ($action === 'update_status') {
            $status = $_POST['status'] ?? '';
            if (!in_array($status, ['pending','scheduled','completed','cancelled'])) throw new Exception('Status tidak valid');

            // fetch pickup and user contact
            $stmt = $pdo->prepare('SELECT p.*, u.full_name, u.email FROM pickups p JOIN users u ON p.user_id = u.id WHERE p.id = ?');
            $stmt->execute([$id]);
            $pickup = $stmt->fetch();
            if (!$pickup) throw new Exception('Permintaan jemput tidak ditemukan');

            $pdo->prepare('UPDATE pickups SET status = ? WHERE id = ?')->execute([$status, $id]);

            // notify user (best effort)
            $email = $pickup['email'] ?? '';
            $subject = "Status Permintaan Jemput Anda: " . ucfirst($status);
            $msg = sprintf("Halo %s, permintaan jemput pada %s (%s) saat ini berstatus: %s.", $pickup['full_name'] ?? '', $pickup['pickup_date'] ?? '', $pickup['time_slot'] ?? '', $status);
            @bs_notify_user($email, $subject, $msg);

            $msg2 = 'Status diperbarui';
            echo json_encode(['success'=>true,'message'=>$msg2]); exit;
        }

        if ($action === 'delete') {
            $pdo->prepare('DELETE FROM pickups WHERE id = ?')->execute([$id]);
            $msg = 'Permintaan jemput dihapus';
            echo json_encode(['success'=>true,'message'=>$msg]); exit;
        }

        throw new Exception('Aksi tidak dikenali');
    }

    throw new Exception('Method not allowed');
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success'=>false,'message'=>$e->getMessage()]); exit;
}

?>
