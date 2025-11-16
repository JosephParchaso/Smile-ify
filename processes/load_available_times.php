<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

header('Content-Type: application/json');

$branchId        = $_POST['branch_id'] ?? null;
$appointmentDate = $_POST['appointment_date'] ?? null;
$services        = $_POST['services'] ?? [];
$dentistId       = $_POST['dentist_id'] ?? null;

if (!$branchId || !$appointmentDate || empty($services) || !$dentistId) {
    echo json_encode(['error' => 'Missing required inputs.']);
    exit;
}

$services = array_map('intval', $services);
$dentistId = intval($dentistId);
$branchId  = intval($branchId);

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

$cleanupBuffer = 15;
$blockDuration = $totalDuration + $cleanupBuffer;

if ($blockDuration <= 0) {
    echo json_encode(['error' => 'Invalid service duration.']);
    exit;
}

$dayName = date('l', strtotime($appointmentDate));

$sql = "
    SELECT start_time, end_time
    FROM dentist_schedule
    WHERE dentist_id = ?
        AND branch_id = ?
        AND day = ?
    LIMIT 1
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $dentistId, $branchId, $dayName);
$stmt->execute();
$schedule = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$schedule) {
    echo json_encode(['error' => 'Dentist is not scheduled on this day.']);
    exit;
}

$open  = new DateTime($schedule['start_time']);
$close = new DateTime($schedule['end_time']);

$sql = "
    SELECT at.appointment_time,
            SUM(s.duration_minutes) AS total_duration
    FROM appointment_transaction AS at
    INNER JOIN appointment_services AS ats 
        ON at.appointment_transaction_id = ats.appointment_transaction_id
    INNER JOIN service AS s 
        ON ats.service_id = s.service_id
    WHERE at.branch_id = ?
        AND at.dentist_id = ?
        AND at.appointment_date = ?
        AND at.status IN ('Booked', 'Approved', 'Confirmed')
    GROUP BY at.appointment_transaction_id, at.appointment_time
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $branchId, $dentistId, $appointmentDate);
$stmt->execute();
$result = $stmt->get_result();

$bookedIntervals = [];
$blocked = [];

while ($row = $result->fetch_assoc()) {
    $start = new DateTime($row['appointment_time']);
    $end   = (clone $start)->modify("+" . ($row['total_duration'] + $cleanupBuffer) . " minutes");

    $bookedIntervals[] = ['start' => $start, 'end' => $end];
    $blocked[] = $start->format('H:i');
}

$stmt->close();

$available = [];
$step = new DateInterval('PT15M');

for ($slot = clone $open; $slot < $close; $slot->add($step)) {

    $slotEnd = (clone $slot)->modify("+{$blockDuration} minutes");

    if ($slotEnd > $close) {
        continue;
    }

    $overlap = false;
    foreach ($bookedIntervals as $b) {
        if ($slot < $b['end'] && $slotEnd > $b['start']) {
            $overlap = true;
            break;
        }
    }

    if (!$overlap) {
        $available[] = $slot->format('H:i');
    }
}

echo json_encode([
    'times'   => $available,
    'blocked' => $blocked
]);

$conn->close();
?>
