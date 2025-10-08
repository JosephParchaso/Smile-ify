<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_GET['appointment_id'])) {
    echo json_encode(["error" => "No appointment ID provided"]);
    exit();
}

$appointmentId = intval($_GET['appointment_id']);

$sql = "SELECT s.name AS service_name, s.price AS service_price
        FROM appointment_transaction a
        INNER JOIN service s ON a.service_id = s.service_id
        WHERE a.appointment_transaction_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $appointmentId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(["error" => "Service not found"]);
}

$conn->close();
