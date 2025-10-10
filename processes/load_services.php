<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (isset($_POST['appointmentBranch'])) {
    $branchId = $_POST['appointmentBranch'];

    $stmt = $conn->prepare("
        SELECT s.service_id, s.name, s.price, s.duration_minutes
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
            $formattedPrice = number_format((float)$row['price'], 2);
            $serviceId = htmlspecialchars($row['service_id']);
            $serviceName = htmlspecialchars($row['name']);
            $duration = htmlspecialchars($row['duration_minutes']);

            echo "
            <div class='checkbox-item'>
                <input 
                    type='checkbox' 
                    id='service_{$serviceId}' 
                    name='appointmentServices[]' 
                    value='{$serviceId}' 
                    data-duration='{$duration}'>
                <label for='service_{$serviceId}'>
                    {$serviceName}
                    <span class='price'>₱{$formattedPrice}</span>
                    <small class='duration'>({$duration} mins)</small>
                </label>
            </div>";
        }
    } else {
        echo '<p class="error-msg">No services available for this branch</p>';
    }

    $stmt->close();
    $conn->close();
}
?>
