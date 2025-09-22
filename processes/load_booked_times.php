<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

$branchId = $_POST['branch_id'] ?? null;
$appointmentDate = $_POST['appointment_date'] ?? null;

if ($branchId && $appointmentDate) {
    $stmt = $conn->prepare("
        SELECT appointment_time
        FROM appointment_transaction
        WHERE branch_id = ?
            AND appointment_date = ?
            AND status IN ('Pending','Approved','Confirmed')
    ");
    $stmt->bind_param("is", $branchId, $appointmentDate);

    $stmt->execute();
    $result = $stmt->get_result();

    $times = [];
    while ($row = $result->fetch_assoc()) {
        $times[] = substr($row['appointment_time'], 0, 5);
    }

    echo json_encode($times);
    $stmt->close();
}

$conn->close();
