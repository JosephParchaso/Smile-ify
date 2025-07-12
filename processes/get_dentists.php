<?php
include '../includes/db.php';

if (isset($_POST['appointmentBranch']) && isset($_POST['appointmentService'])) {
    $branchId = $_POST['appointmentBranch'];
    $serviceId = $_POST['appointmentService'];

    $stmt = $conn->prepare("
        SELECT d.dentist_id, d.last_name, d.first_name
        FROM dentist d
        INNER JOIN dentist_branch db ON d.dentist_id = db.dentist_id
        INNER JOIN dentist_service ds ON d.dentist_id = ds.dentist_id
        WHERE db.branch_id = ? AND ds.service_id = ? AND d.status = 'Active'
        ORDER BY d.first_name ASC
    ");
    $stmt->bind_param("ii", $branchId, $serviceId);
    $stmt->execute();
    $result = $stmt->get_result();

    $options = '<option value="" disabled selected hidden></option>';
    $options .= '<option value="none">Available Dentist</option>';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $options .= "<option value='" . $row['dentist_id'] . "'>Dr. " . htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) . "</option>";
        }
    } else {
        $options .= '<option disabled>No dentists available for this selection</option>';
    }

    echo $options;

    $stmt->close();
    $conn->close();
}
?>
