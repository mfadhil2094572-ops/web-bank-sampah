<?php
// Run once to seed waste types. Delete or protect this file after use.
require_once __DIR__ . '../../../config/db.php';

$wasteTypes = [
    ['Plastik Botol', 3000, 3],
    ['Plastik Kemasan', 2500, 2],
    ['Kertas', 2000, 2],
    ['Kardus', 2200, 2],
    ['Logam', 5000, 5],
    ['Kaca', 1500, 1],
];

$stmt = $pdo->prepare('SELECT COUNT(*) FROM waste_types');
$stmt->execute();
if ($stmt->fetchColumn() > 0) {
    echo "Waste types already seeded\n";
    exit;
}

$insert = $pdo->prepare(
    'INSERT INTO waste_types (name, price_per_kg, point_per_kg) VALUES (?, ?, ?)'
);

foreach ($wasteTypes as $wt) {
    $insert->execute($wt);
}

echo "Waste types seeded successfully\n";
