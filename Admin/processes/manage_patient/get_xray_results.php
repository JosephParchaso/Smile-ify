<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

$transactionId = $_GET['id'] ?? null;

$response = ["success" => false];

if (!$transactionId) {
    echo json_encode($response);
    exit;
}

$stmt = $conn->prepare("
    SELECT dx.file_path, s.name AS service_name, dx.date_created
    FROM transaction_xrays dx
    LEFT JOIN service s ON dx.service_id = s.service_id
    WHERE dx.dental_transaction_id = ?
");
$stmt->bind_param("i", $transactionId);
$stmt->execute();
$result = $stmt->get_result();

$results = [];
while ($row = $result->fetch_assoc()) {
    $results[] = [
        "file_path" => $row['file_path'],
        "service_name" => $row['service_name'],
        "date_created" => $row['date_created']
    ];
}

if (!empty($results)) {
    $response["success"] = true;
    $response["files"] = $results;
}
if ($conn->error) {
    echo $conn->error;
    exit;
}
echo json_encode($response);
