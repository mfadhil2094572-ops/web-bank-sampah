<?php
require_once __DIR__ . '/../../app/middleware/auth.php';
require_login('admin');

header('Content-Type: application/json; charset=utf-8');
$isJson = true; // API always returns JSON

// List members
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->prepare('SELECT id, full_name, email, phone, city, role, created_at FROM users ORDER BY created_at DESC');
    $stmt->execute();
    $rows = $stmt->fetchAll();
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'data' => $rows]);
    exit;
}

$action = $_POST['action'] ?? '';
try {
    if ($action === 'create') {
        $full_name = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] === 'admin' ? 'admin' : 'member';

        if ($full_name === '' || $email === '' || $password === '') {
            throw new Exception('Semua field wajib diisi');
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (full_name, email, password_hash, role) VALUES (?, ?, ?, ?)');
        $stmt->execute([$full_name, $email, $hash, $role]);
        $userId = $pdo->lastInsertId();
        $pdo->prepare('INSERT INTO wallets (user_id) VALUES (?)')->execute([$userId]);

        $msg = 'Member berhasil dibuat';
        echo json_encode(['success'=>true,'message'=>$msg]); exit;
    }

    if ($action === 'update') {
        $id = intval($_POST['id'] ?? 0);
        if (!$id) throw new Exception('ID tidak valid');
        $fields = [];
        $params = [];
        foreach (['full_name','phone','city','role'] as $f) {
            if (isset($_POST[$f])) { $fields[] = "$f = ?"; $params[] = $_POST[$f]; }
        }
        if (!empty($fields)) {
            $params[] = $id;
            $stmt = $pdo->prepare('UPDATE users SET ' . implode(', ', $fields) . ' WHERE id = ?');
            $stmt->execute($params);
        }
        $msg = 'Member berhasil diperbarui';
        echo json_encode(['success'=>true,'message'=>$msg]); exit;
    }

    if ($action === 'delete') {
        $id = intval($_POST['id'] ?? 0);
        if (!$id) throw new Exception('ID tidak valid');
        $pdo->prepare('DELETE FROM wallets WHERE user_id = ?')->execute([$id]);
        $pdo->prepare('DELETE FROM waste_transaction_items WHERE transaction_id IN (SELECT id FROM waste_transactions WHERE user_id = ?)')->execute([$id]);
        $pdo->prepare('DELETE FROM waste_transactions WHERE user_id = ?')->execute([$id]);
        $pdo->prepare('DELETE FROM users WHERE id = ?')->execute([$id]);
        $msg = 'Member dihapus';
        echo json_encode(['success'=>true,'message'=>$msg]); exit;
    }

    throw new Exception('Aksi tidak dikenali');
} catch (Exception $e) {
    http_response_code(400);
    $msg = $e->getMessage();
    echo json_encode(['success'=>false,'message'=>$msg]); exit;
}

?>
