<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

header('Content-Type: application/json');

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

$cleanupBuffer = 15;
$totalDurationWithBuffer = $totalDuration + $cleanupBuffer;

$sql = "
    SELECT at.appointment_time, SUM(s.duration_minutes) AS total_duration
    FROM appointment_transaction AS at
    INNER JOIN appointment_services AS ats 
        ON at.appointment_transaction_id = ats.appointment_transaction_id
    INNER JOIN service AS s 
        ON ats.service_id = s.service_id
    WHERE at.branch_id = ? 
        AND at.appointment_date = ?
        AND at.status IN ('Booked', 'Approved', 'Confirmed')
    GROUP BY at.appointment_transaction_id, at.appointment_time
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $branchId, $appointmentDate);
$stmt->execute();
$result = $stmt->get_result();

$bookedIntervals = [];
$blocked = [];
while ($row = $result->fetch_assoc()) {
    $start = new DateTime($row['appointment_time']);
    $end   = (clone $start)->modify("+{$row['total_duration']} minutes +{$cleanupBuffer} minutes");
    $bookedIntervals[] = ['start' => $start, 'end' => $end];
    $blocked[] = $start->format('H:i');
}
$stmt->close();

$open  = new DateTime('09:00');
$close = new DateTime('16:30');

$step  = new DateInterval('PT15M');

$available = [];
for ($slot = clone $open; $slot < $close; $slot->add($step)) {
    $slotEnd = (clone $slot)->modify("+{$totalDurationWithBuffer} minutes");
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

echo json_encode([
    'times' => $available,
    'blocked' => $blocked
]);

$conn->close();
