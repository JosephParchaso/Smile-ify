<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (isset($_POST['appointmentBranch'])) {
    $branchId = $_POST['appointmentBranch'];

    $stmt = $conn->prepare("
        SELECT s.service_id, s.name
        FROM service s
        INNER JOIN branch_service bs ON s.service_id = bs.service_id
        WHERE bs.branch_id = ? AND bs.status = 'Active'
        ORDER BY s.name ASC
    ");
    $stmt->bind_param("i", $branchId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "
            <div class='checkbox-item'>
                <input type='checkbox' id='service_" . $row['service_id'] . "' 
                    name='appointmentServices[]' value='" . $row['service_id'] . "' required>
                <label for='service_" . $row['service_id'] . "'>" . htmlspecialchars($row['name']) . "</label>
            </div>";
        }
    } else {
        echo '<p class="error-msg">No services available for this branch</p>';
    }

    $stmt->close();
    $conn->close();
}
?>
