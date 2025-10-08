<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (isset($_POST['appointmentBranch']) && isset($_POST['appointmentServices'])) {
    $branchId = intval($_POST['appointmentBranch']);
    $services = $_POST['appointmentServices'];

    if (!is_array($services)) {
        $services = [$services];
    }

    // sanitize to integers
    $services = array_map('intval', $services);
    $countServices = count($services);

    // build placeholders for the IN clause
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
    if (!$stmt) {
        // helpful debug in dev - remove/disable in production
        echo '<option disabled>Query prepare failed</option>';
        exit;
    }

    // Prepare values to bind: branchId, service IDs..., countServices
    $values = array_merge([$branchId], $services, [$countServices]);

    // Types string: all integers
    $types = str_repeat('i', count($values));

    // bind_param requires references — build array of references
    $bindParams = [];
    $bindParams[] = $types;
    foreach ($values as $i => $val) {
        $bindParams[] = & $values[$i];
    }

    // call_user_func_array with references
    call_user_func_array([$stmt, 'bind_param'], $bindParams);

    $stmt->execute();
    $result = $stmt->get_result();

    $options = '<option value="" disabled selected hidden></option>';
    // optional header option
    $options .= '<option value="none">Available Dentist</option>';

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dentistName = "Dr. " . htmlspecialchars($row['first_name'] . ' ' . $row['last_name']);
            $options .= "<option value='{$row['dentist_id']}'>{$dentistName}</option>";
        }
    } else {
        $options .= '<option disabled>No dentists available for this selection</option>';
    }

    echo $options;

    $stmt->close();
    $conn->close();
}
?>
