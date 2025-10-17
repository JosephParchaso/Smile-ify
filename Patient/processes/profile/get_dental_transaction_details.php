<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "No transaction ID provided"]);
    exit();
}

$transactionId = intval($_GET['id']);
$userId = $_SESSION['user_id'];

$sql = "
    SELECT 
        b.name AS branch,
        GROUP_CONCAT(DISTINCT CONCAT(s.name, ' × ', dts.quantity) ORDER BY s.name SEPARATOR '\n') AS services,
        CONCAT('Dr. ', d.last_name, ', ', d.first_name, ' ', IFNULL(d.middle_name, '')) AS dentist,
        d.last_name AS dentist_last_name,
        d.first_name AS dentist_first_name,
        d.middle_name AS dentist_middle_name,
        d.license_number,
        d.signature_image,

        u.last_name AS patient_last_name,
        u.first_name AS patient_first_name,
        u.middle_name AS patient_middle_name,
        u.date_of_birth AS patient_dob,
        u.gender AS gender,

        a.appointment_transaction_id,
        a.appointment_date,
        a.appointment_time,
        dt.dental_transaction_id,
        dt.notes,
        dt.total,
        dt.payment_method,
        dt.date_created,
        dt.prescription_downloaded,

        dv.body_temp,
        dv.pulse_rate,
        dv.respiratory_rate,
        dv.blood_pressure,
        dv.height,
        dv.weight,
        dv.is_swelling,
        dv.is_sensitive,
        dv.is_bleeding
    FROM dental_transaction dt
    INNER JOIN appointment_transaction a 
        ON dt.appointment_transaction_id = a.appointment_transaction_id
    LEFT JOIN branch b 
        ON a.branch_id = b.branch_id
    LEFT JOIN dental_transaction_services dts 
        ON dts.dental_transaction_id = dt.dental_transaction_id
    LEFT JOIN service s 
        ON dts.service_id = s.service_id
    LEFT JOIN dentist d 
        ON d.dentist_id = COALESCE(dt.dentist_id, a.dentist_id)
    LEFT JOIN dental_vital dv
        ON dv.appointment_transaction_id = a.appointment_transaction_id
    LEFT JOIN users u 
        ON a.user_id = u.user_id
    WHERE dt.dental_transaction_id = ? 
        AND a.user_id = ?
    GROUP BY dt.dental_transaction_id
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $transactionId, $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $row['services'] = $row['services'] ?: '-';

    $appointmentTransactionId = $row['appointment_transaction_id'];

    $prescriptionsSql = "
        SELECT drug, frequency, dosage, duration, quantity, instructions 
        FROM dental_prescription 
        WHERE appointment_transaction_id = ?
    ";
    $stmt2 = $conn->prepare($prescriptionsSql);
    $stmt2->bind_param("i", $appointmentTransactionId);
    $stmt2->execute();
    $prescriptionsResult = $stmt2->get_result();

    $prescriptions = [];
    while ($p = $prescriptionsResult->fetch_assoc()) {
        $prescriptions[] = $p;
    }

    $row['dental_transaction_id'] = $transactionId;
    $row['prescriptions'] = $prescriptions;

    echo json_encode($row);
} else {
    echo json_encode(["error" => "Transaction not found"]);
}

$conn->close();
?>
