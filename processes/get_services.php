<?php
include '../includes/db.php';

if (isset($_POST['appointmentBranch'])) {
    $branchId = $_POST['appointmentBranch'];

    $stmt = $conn->prepare("
        SELECT s.service_id, s.name
        FROM service s
        INNER JOIN branch_service bs ON s.service_id = bs.service_id
        WHERE bs.branch_id = ? AND s.status = 'Active'
        ORDER BY s.name ASC
    ");
    $stmt->bind_param("i", $branchId);
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<option value="" disabled selected hidden></option>';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['service_id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
        }
    } else {
        echo '<option disabled>No services available for this branch</option>';
    }

    $stmt->close();
    $conn->close();
}
?>
