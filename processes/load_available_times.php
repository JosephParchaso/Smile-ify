<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

$branchId        = $_POST['branch_id'] ?? null;
$appointmentDate = $_POST['appointment_date'] ?? null;
$services        = $_POST['services'] ?? [];

if (!$branchId || !$appointmentDate || empty($services)) {
    echo json_encode([]);
    exit;
}

$placeholders = implode(',', array_fill(0, count($services), '?'));
$sql = "SELECT SUM(duration_minutes) AS total_duration 
        FROM service 
        WHERE service_id IN ($placeholders)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('i', count($services)), ...$services);
$stmt->execute();

$row = $stmt->get_result()->fetch_assoc();
$totalDuration = (int)($row['total_duration'] ?? 0);
$stmt->close();

if ($totalDuration <= 0) {
    echo json_encode(['error' => 'Invalid service duration.']);
    exit;
}

$sql = "
    SELECT at.appointment_time, s.duration_minutes
    FROM appointment_transaction AS at
    INNER JOIN service AS s ON at.service_id = s.service_id
    WHERE at.branch_id = ? 
        AND at.appointment_date = ?
        AND at.status IN ('Booked', 'Approved', 'Confirmed')
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $branchId, $appointmentDate);
$stmt->execute();

$result = $stmt->get_result();
$bookedIntervals = [];

while ($row = $result->fetch_assoc()) {
    $start = new DateTime($row['appointment_time']);
    $end   = (clone $start)->modify("+{$row['duration_minutes']} minutes");
    $bookedIntervals[] = ['start' => $start, 'end' => $end];
}
$stmt->close();

$open  = new DateTime('09:00');
$close = new DateTime('17:00');
$step  = new DateInterval("PT{$totalDuration}M");

$available = [];

for ($slot = clone $open; $slot < $close; $slot->add($step)) {
    $slotEnd = (clone $slot)->modify("+{$totalDuration} minutes");

    if ($slotEnd > $close) break;

    $overlaps = false;
    foreach ($bookedIntervals as $b) {
        if ($slot < $b['end'] && $slotEnd > $b['start']) {
            $overlaps = true;
            break;
        }
    }

    if (!$overlaps) {
        $available[] = $slot->format('H:i');
    }
}

echo json_encode($available);
$conn->close();
