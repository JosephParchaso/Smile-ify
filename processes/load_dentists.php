<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (empty($_POST['appointmentBranch'])) {
    echo '<option disabled>No branch selected</option>';
    exit;
}

if (empty($_POST['appointmentDate'])) {
    echo '<option disabled>No date selected</option>';
    exit;
}

if (empty($_POST['appointmentTime'])) {
    echo '<option disabled>No time selected</option>';
    exit;
}

$branchId = intval($_POST['appointmentBranch']);
$appointmentDate = $_POST['appointmentDate'];
$appointmentTime = $_POST['appointmentTime'];
$dayName = date('l', strtotime($appointmentDate));

$services = $_POST['appointmentServices'] ?? [];
if (!is_array($services)) {
    $services = [$services];
}
$services = array_map('intval', $services);

$selectedDentistId = isset($_POST['selectedDentistId']) ? intval($_POST['selectedDentistId']) : null;
$transactionId     = $_POST['appointment_transaction_id'] ?? null;
$appointmentId     = $_POST['appointment_id'] ?? null;
$preassignedDentistId = null;

if ($transactionId) {
    $stmtTx = $conn->prepare("
        SELECT dentist_id 
        FROM dental_transaction 
        WHERE dental_transaction_id = ? LIMIT 1
    ");
    if ($stmtTx) {
        $stmtTx->bind_param("i", $transactionId);
        $stmtTx->execute();
        $resultTx = $stmtTx->get_result();
        if ($row = $resultTx->fetch_assoc()) {
            $preassignedDentistId = intval($row['dentist_id']);
        }
        $stmtTx->close();
    }
} elseif ($appointmentId) {
    $stmtApp = $conn->prepare("
        SELECT dentist_id 
        FROM appointment_transaction 
        WHERE appointment_transaction_id = ? LIMIT 1
    ");
    if ($stmtApp) {
        $stmtApp->bind_param("i", $appointmentId);
        $stmtApp->execute();
        $resultApp = $stmtApp->get_result();
        if ($row = $resultApp->fetch_assoc()) {
            $preassignedDentistId = intval($row['dentist_id']);
        }
        $stmtApp->close();
    }
}

if (!$selectedDentistId && $preassignedDentistId) {
    $selectedDentistId = $preassignedDentistId;
}

$stmt = null;

if (empty($services)) {

    $sql = "
        SELECT d.dentist_id, d.first_name, d.last_name
        FROM dentist d
        INNER JOIN dentist_branch db 
            ON d.dentist_id = db.dentist_id
        INNER JOIN dentist_schedule sch
            ON sch.dentist_id = d.dentist_id
            AND sch.branch_id = db.branch_id
            AND sch.day = ?
            AND (
                    (sch.start_time IS NULL AND sch.end_time IS NULL)
                    OR (sch.start_time <= ? AND sch.end_time > ?)
                )
        WHERE db.branch_id = ?
            AND d.status = 'Active'
        ORDER BY d.first_name ASC
    ";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo '<option disabled>SQL prepare error: ' . htmlspecialchars($conn->error) . '</option>';
        exit;
    }

    $stmt->bind_param("sssi", $dayName, $appointmentTime, $appointmentTime, $branchId);

} else {

    $countServices = count($services);
    $placeholders = implode(',', array_fill(0, $countServices, '?'));

    $sql = "
        SELECT d.dentist_id, d.first_name, d.last_name
        FROM dentist d
        INNER JOIN dentist_branch db 
            ON d.dentist_id = db.dentist_id
        INNER JOIN dentist_schedule sch
            ON sch.dentist_id = d.dentist_id
            AND sch.branch_id = db.branch_id
            AND sch.day = ?
            AND (
                    (sch.start_time IS NULL AND sch.end_time IS NULL)
                    OR (sch.start_time <= ? AND sch.end_time > ?)
                )
        INNER JOIN dentist_service ds 
            ON d.dentist_id = ds.dentist_id
        WHERE db.branch_id = ?
            AND ds.service_id IN ($placeholders)
            AND d.status = 'Active'
        GROUP BY d.dentist_id
        HAVING COUNT(DISTINCT ds.service_id) = ?
        ORDER BY d.first_name ASC
    ";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo '<option disabled>SQL prepare error: ' . htmlspecialchars($conn->error) . '</option>';
        exit;
    }

    $types = 'sss' . 'i' . str_repeat('i', $countServices) . 'i';

    $values = array_merge(
        [$dayName, $appointmentTime, $appointmentTime, $branchId],
        $services,
        [$countServices]
    );

    $bind_names[] = $types;
    for ($i = 0; $i < count($values); $i++) {
        $bind_name = 'bind' . $i;
        $$bind_name = $values[$i];
        $bind_names[] = &$$bind_name;
    }

    call_user_func_array([$stmt, 'bind_param'], $bind_names);
}

if (! $stmt->execute()) {
    echo '<option disabled>SQL execute error: ' . htmlspecialchars($stmt->error) . '</option>';
    exit;
}

$result = $stmt->get_result();

$dentists = [];
while ($row = $result->fetch_assoc()) {
    $dentists[$row['dentist_id']] = [
        'first_name' => $row['first_name'],
        'last_name'  => $row['last_name']
    ];
}

$stmt->close();

if ($preassignedDentistId && !isset($dentists[$preassignedDentistId])) {

    $stmtExtra = $conn->prepare("
        SELECT dentist_id, first_name, last_name
        FROM dentist
        WHERE dentist_id = ? LIMIT 1
    ");
    if ($stmtExtra) {
        $stmtExtra->bind_param("i", $preassignedDentistId);
        $stmtExtra->execute();
        $resultExtra = $stmtExtra->get_result();
        if ($row = $resultExtra->fetch_assoc()) {
            $dentists[$row['dentist_id']] = [
                'first_name' => $row['first_name'],
                'last_name'  => $row['last_name']
            ];
        }
        $stmtExtra->close();
    }
}

$options = '<option value="" disabled selected>Select Dentist</option>';
$options .= '<option value="none">Available Dentist</option>';

if (!empty($dentists)) {
    foreach ($dentists as $id => $info) {
        $dentistName = "Dr. " . htmlspecialchars($info['first_name'] . " " . $info['last_name']);
        $selected = ($selectedDentistId === $id) ? 'selected' : '';
        $options .= "<option value='$id' $selected>$dentistName</option>";
    }
}

echo $options;

$conn->close();
?>
