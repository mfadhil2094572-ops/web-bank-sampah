<?php
require_once __DIR__ . '/../../config/db.php';

$type = $_GET['type_id'] ?? null;
$weight = $_GET['weight'] ?? null;
if (!$type || !$weight) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}

$stmt = $pdo->prepare('SELECT price_per_kg, point_per_kg FROM waste_types WHERE id = ?');
$stmt->execute([$type]);
$row = $stmt->fetch();
if (!$row) {
    http_response_code(404);
    echo json_encode(['error' => 'Waste type not found']);
    exit;
}

$price = intval($row['price_per_kg'] * floatval($weight));
$points = intval($row['point_per_kg'] * floatval($weight));

header('Content-Type: application/json');
echo json_encode(['price' => $price, 'points' => $points]);
exit;
