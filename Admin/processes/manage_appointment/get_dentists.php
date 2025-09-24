<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (isset($_GET['appointment_id'])) {
    $appointmentId = intval($_GET['appointment_id']);

    $stmt = $conn->prepare("
                            SELECT 
                                d.dentist_id AS id,
                                CONCAT('Dr. ', d.first_name, ' ', d.last_name) AS name
                            FROM appointment_transaction a
                            INNER JOIN dentist_branch db ON a.branch_id = db.branch_id
                            INNER JOIN dentist d ON db.dentist_id = d.dentist_id
                            WHERE a.appointment_transaction_id = ? 
                            AND d.status = 'Active'
                            ORDER BY d.first_name ASC, d.last_name ASC;
    ");
    $stmt->bind_param("i", $appointmentId);
    $stmt->execute();
    $result = $stmt->get_result();

    $dentists = [];
    while ($row = $result->fetch_assoc()) {
        $dentists[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($dentists);

    $stmt->close();
    $conn->close();
}
?>
