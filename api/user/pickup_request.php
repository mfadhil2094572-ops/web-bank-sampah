<?php
require_once __DIR__ . '/../../app/middleware/auth.php';
require_login();
$user = bs_get_current_user();
if (!$user) { http_response_code(401); header('Content-Type: application/json'); echo json_encode(['success'=>false,'message'=>'Unauthorized']); exit; }

header('Content-Type: application/json');

$date = $_POST['pickup_date'] ?? '';
$time = $_POST['time_slot'] ?? '';
$weight = floatval($_POST['estimated_weight'] ?? 0);
$types = $_POST['types'] ?? '';

if (!$date || !$time || $weight <= 0) {
    $msg = 'Field tidak lengkap atau berat tidak valid';
    echo json_encode(['success'=>false,'message'=>$msg]); exit;
}

try {
    $stmt = $pdo->prepare('INSERT INTO pickups (user_id, pickup_date, time_slot, estimated_weight, types) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$user['id'], $date, $time, $weight, $types]);
    $msg = 'Permintaan jemput berhasil dikirim';
    echo json_encode(['success'=>true,'message'=>$msg]); exit;
} catch (Exception $e) {
    http_response_code(500);
    $msg = 'Terjadi kesalahan server';
    echo json_encode(['success'=>false,'message'=>$msg]); exit;
}

?>
