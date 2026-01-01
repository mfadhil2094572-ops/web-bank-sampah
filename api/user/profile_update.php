<?php
require_once __DIR__ . '/../../app/middleware/auth.php';
require_login();

$user = bs_get_current_user();
if (!$user) {
    http_response_code(401);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

header('Content-Type: application/json');

$full_name = trim($_POST['full_name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$address = trim($_POST['address'] ?? '');
$city = trim($_POST['city'] ?? '');
$zip_code = trim($_POST['zip_code'] ?? '');

if ($full_name === '') {
    $msg = 'Nama lengkap tidak boleh kosong';
    echo json_encode(['success'=>false,'message'=>$msg]); exit;
}

try {
    $stmt = $pdo->prepare('UPDATE users SET full_name = ?, phone = ?, address = ?, city = ?, zip_code = ? WHERE id = ?');
    $stmt->execute([$full_name, $phone, $address, $city, $zip_code, $user['id']]);

    $msg = 'Profil berhasil diperbarui';
    echo json_encode(['success'=>true,'message'=>$msg]);
    exit;
} catch (Exception $e) {
    http_response_code(500);
    $msg = 'Terjadi kesalahan server';
    echo json_encode(['success'=>false,'message'=>$msg]);
    exit;
}

?>
