<?php
require_once __DIR__ . '/../../app/middleware/auth.php';
require_login('admin');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->prepare('SELECT * FROM waste_types ORDER BY name');
    $stmt->execute();
    $rows = $stmt->fetchAll();
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'data' => $rows]);
    exit;
}

$action = $_POST['action'] ?? '';
try {
    if ($action === 'create') {
        $name = trim($_POST['name'] ?? '');
        $price = intval($_POST['price_per_kg'] ?? 0);
        $points = intval($_POST['point_per_kg'] ?? 0);
        if ($name === '') throw new Exception('Nama wajib diisi');
        $stmt = $pdo->prepare('INSERT INTO waste_types (name, price_per_kg, point_per_kg) VALUES (?, ?, ?)');
        $stmt->execute([$name, $price, $points]);
        $msg = 'Jenis sampah ditambahkan';
        echo json_encode(['success'=>true,'message'=>$msg]); exit;
    }

    if ($action === 'update') {
        $id = intval($_POST['id'] ?? 0);
        if (!$id) throw new Exception('ID tidak valid');
        $name = trim($_POST['name'] ?? '');
        $price = intval($_POST['price_per_kg'] ?? 0);
        $points = intval($_POST['point_per_kg'] ?? 0);
        $stmt = $pdo->prepare('UPDATE waste_types SET name = ?, price_per_kg = ?, point_per_kg = ? WHERE id = ?');
        $stmt->execute([$name, $price, $points, $id]);
        $msg = 'Jenis sampah diperbarui';
        echo json_encode(['success'=>true,'message'=>$msg]); exit;
    }

    if ($action === 'delete') {
        $id = intval($_POST['id'] ?? 0);
        if (!$id) throw new Exception('ID tidak valid');
        $pdo->prepare('DELETE FROM waste_types WHERE id = ?')->execute([$id]);
        $msg = 'Jenis sampah dihapus';
        echo json_encode(['success'=>true,'message'=>$msg]); exit;
    }

    throw new Exception('Aksi tidak dikenali');
} catch (Exception $e) {
    http_response_code(400);
    $msg = $e->getMessage();
    echo json_encode(['success'=>false,'message'=>$msg]); exit;
}

?>
