<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (empty($_POST['appointmentBranch'])) {
    echo '<option disabled>No branch ID provided</option>';
    exit;
}

$branchId = intval($_POST['appointmentBranch']);
$services = $_POST['appointmentServices'] ?? [];
$selectedDentistId = isset($_POST['selectedDentistId']) ? intval($_POST['selectedDentistId']) : null;
$transactionId = $_POST['appointment_transaction_id'] ?? null;
$appointmentId = $_POST['appointment_id'] ?? null;

$preassignedDentistId = null;
if ($transactionId) {
    $stmtTx = $conn->prepare("
        SELECT dentist_id 
        FROM dental_transaction 
        WHERE dental_transaction_id = ?
        LIMIT 1
    ");
    $stmtTx->bind_param("i", $transactionId);
    $stmtTx->execute();
    $resultTx = $stmtTx->get_result();
    if ($row = $resultTx->fetch_assoc()) {
        $preassignedDentistId = intval($row['dentist_id']);
    }
    $stmtTx->close();
} elseif ($appointmentId) {
    $stmtApp = $conn->prepare("
        SELECT dentist_id 
        FROM appointment_transaction 
        WHERE appointment_transaction_id = ?
        LIMIT 1
    ");
    $stmtApp->bind_param("i", $appointmentId);
    $stmtApp->execute();
    $resultApp = $stmtApp->get_result();
    if ($row = $resultApp->fetch_assoc()) {
        $preassignedDentistId = intval($row['dentist_id']);
    }
    $stmtApp->close();
}

if (!$selectedDentistId && $preassignedDentistId) {
    $selectedDentistId = $preassignedDentistId;
}

if (!is_array($services)) {
    $services = [$services];
}

if (empty($services)) {
    $sql = "
        SELECT d.dentist_id, d.first_name, d.last_name
        FROM dentist d
        INNER JOIN dentist_branch db ON d.dentist_id = db.dentist_id
        WHERE db.branch_id = ? AND d.status = 'Active'
        ORDER BY d.first_name ASC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $branchId);
} else {
    $services = array_map('intval', $services);
    $countServices = count($services);
    $placeholders = implode(',', array_fill(0, $countServices, '?'));

    $sql = "
        SELECT d.dentist_id, d.first_name, d.last_name
        FROM dentist d
        INNER JOIN dentist_branch db ON d.dentist_id = db.dentist_id
        INNER JOIN dentist_service ds ON d.dentist_id = ds.dentist_id
        WHERE db.branch_id = ?
            AND ds.service_id IN ($placeholders)
            AND d.status = 'Active'
        GROUP BY d.dentist_id
        HAVING COUNT(DISTINCT ds.service_id) = ?
        ORDER BY d.first_name ASC
    ";

    $stmt = $conn->prepare($sql);
    $values = array_merge([$branchId], $services, [$countServices]);
    $types = str_repeat('i', count($values));
    $bindParams = [];
    $bindParams[] = $types;
    foreach ($values as $i => $val) {
        $bindParams[] = &$values[$i];
    }
    call_user_func_array([$stmt, 'bind_param'], $bindParams);
}

$stmt->execute();
$result = $stmt->get_result();

$dentists = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dentists[$row['dentist_id']] = [
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name']
        ];
    }
}

$fallbackAdded = false;
if ($preassignedDentistId && !array_key_exists($preassignedDentistId, $dentists)) {
    $stmtExtra = $conn->prepare("
        SELECT dentist_id, first_name, last_name
        FROM dentist
        WHERE dentist_id = ?
        LIMIT 1
    ");
    $stmtExtra->bind_param("i", $preassignedDentistId);
    $stmtExtra->execute();
    $resultExtra = $stmtExtra->get_result();
    if ($row = $resultExtra->fetch_assoc()) {
        $dentists[$row['dentist_id']] = [
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name']
        ];
        $fallbackAdded = true;
    }
    $stmtExtra->close();
}

if (!empty($_POST['forTransaction'])) {
    $options = '<option value="" disabled hidden></option>';
} else {
    $options = '<option value="" disabled selected hidden></option>';
    $options .= '<option value="none">Available Dentist</option>';
}

if (!empty($dentists)) {
    foreach ($dentists as $id => $info) {
        $dentistName = "Dr. " . htmlspecialchars($info['first_name'] . ' ' . $info['last_name']);
        $selected = ($selectedDentistId && $id == $selectedDentistId) ? 'selected' : '';
        $options .= "<option value='{$id}' {$selected}>{$dentistName}</option>";
    }
} else {
    $options .= '<option disabled>No dentists available</option>';
}

if (empty($selectedDentistId)) {
    $options = preg_replace('/selected/', '', $options);
    $options = '<option value="" disabled selected>Select Dentist</option>' . $options;
}

echo $options;

$stmt->close();
$conn->close();
?>
