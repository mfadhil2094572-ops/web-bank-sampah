<?php
require_once __DIR__ . '/../../config/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json');
if (empty($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['ok' => false, 'error' => 'Unauthorized']);
    exit;
}

$userId = $_SESSION['user_id'];
$waste_type_id = $_POST['waste_type_id'] ?? null;
$weight = $_POST['weight'] ?? null;

if (!$waste_type_id || !$weight) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Missing parameters']);
    exit;
}

$stmt = $pdo->prepare('SELECT price_per_kg, point_per_kg FROM waste_types WHERE id = ?');
$stmt->execute([$waste_type_id]);
$type = $stmt->fetch();
if (!$type) {
    http_response_code(404);
    echo 'Waste type not found';
    exit;
}

$price = intval($type['price_per_kg'] * floatval($weight));
$points = intval($type['point_per_kg'] * floatval($weight));

try {
    $pdo->beginTransaction();
    $ins = $pdo->prepare('INSERT INTO waste_transactions (user_id, total_weight, total_price, total_points, status) VALUES (?, ?, ?, ?, "pending")');
    $ins->execute([$userId, $weight, $price, $points]);
    $txId = $pdo->lastInsertId();

    $it = $pdo->prepare('INSERT INTO waste_transaction_items (transaction_id, waste_type_id, weight, price, points) VALUES (?, ?, ?, ?, ?)');
    $it->execute([$txId, $waste_type_id, $weight, $price, $points]);

    $pdo->commit();
    // respond differently for XHR/JSON clients
    echo json_encode(['ok' => true, 'transaction_id' => $txId]);
    exit;
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Could not create transaction']);
    exit;
}
