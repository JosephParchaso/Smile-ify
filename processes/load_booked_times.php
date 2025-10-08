<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

$branchId = $_POST['branch_id'] ?? null;
$appointmentDate = $_POST['appointment_date'] ?? null;

if ($branchId && $appointmentDate) {
    $stmt = $conn->prepare("
        SELECT at.appointment_time, s.duration_minutes
        FROM appointment_transaction AS at
        INNER JOIN services AS s ON at.service_id = s.service_id
        WHERE at.branch_id = ?
            AND at.appointment_date = ?
            AND at.status IN ('Booked','Approved','Confirmed')
    ");
    $stmt->bind_param("is", $branchId, $appointmentDate);
    $stmt->execute();
    $result = $stmt->get_result();

    $bookedTimes = [];

    while ($row = $result->fetch_assoc()) {
        $startTime = $row['appointment_time'];
        $duration = (int)$row['duration_minutes'];

        $start = new DateTime($startTime);
        $end = (clone $start)->modify("+{$duration} minutes");

        $interval = new DateInterval("PT15M");
        for ($t = clone $start; $t < $end; $t->add($interval)) {
            $bookedTimes[] = $t->format("H:i");
        }
    }

    $bookedTimes = array_values(array_unique($bookedTimes));

    echo json_encode($bookedTimes);
    $stmt->close();
}

$conn->close();
