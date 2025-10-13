<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (isset($_POST['appointmentBranch'])) {
    $branchId = $_POST['appointmentBranch'];
    $transactionId = $_POST['appointment_transaction_id'] ?? null;
    $appointmentId = $_POST['appointment_id'] ?? null;
    $selectedServices = [];

    if ($transactionId) {
        $stmtSel = $conn->prepare("
            SELECT service_id 
            FROM appointment_services 
            WHERE appointment_transaction_id = ?
        ");
        $stmtSel->bind_param("i", $transactionId);
        $stmtSel->execute();
        $resultSel = $stmtSel->get_result();

        while ($row = $resultSel->fetch_assoc()) {
            $selectedServices[] = $row['service_id'];
        }
        $stmtSel->close();
    }

    elseif ($appointmentId) {
        $stmtApp = $conn->prepare("
            SELECT service_id 
            FROM appointment_services 
            WHERE appointment_transaction_id = ?
        ");
        $stmtApp->bind_param("i", $appointmentId);
        $stmtApp->execute();
        $resultApp = $stmtApp->get_result();

        while ($row = $resultApp->fetch_assoc()) {
            $selectedServices[] = $row['service_id'];
        }
        $stmtApp->close();
    }

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
            $serviceId = htmlspecialchars($row['service_id']);
            $serviceName = htmlspecialchars($row['name']);
            $formattedPrice = number_format((float)$row['price'], 2);
            $duration = htmlspecialchars($row['duration_minutes']);
            $isChecked = in_array($serviceId, $selectedServices) ? "checked" : "";
            $durationHtml = empty($_POST['hide_duration'])
                ? "<small class='duration'>({$duration} mins)</small>"
                : "";
                
            echo "
            <div class='checkbox-item'>
                <label>
                    <input 
                        type='checkbox' 
                        id='service_{$serviceId}' 
                        name='appointmentServices[]' 
                        value='{$serviceId}' 
                        data-duration='{$duration}' 
                        {$isChecked}
                    >
                    {$serviceName}
                    <span class='price'>₱{$formattedPrice}</span>
                    {$durationHtml}
                </label>

                <input 
                    type='number' 
                    name='serviceQuantity[{$serviceId}]' 
                    class='service-quantity' 
                    min='1' 
                    value='1' 
                    style='display: " . ($isChecked ? 'inline-block' : 'none') . "; width: 60px; margin-left: 10px;'
                >
            </div>";
        }
    } else {
        echo '<p class="error-msg">No services available for this branch</p>';
    }

    $stmt->close();
    $conn->close();
}
?>
