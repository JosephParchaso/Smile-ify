<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$appointmentId = $_GET['id'] ?? null;
if (!$appointmentId) {
    http_response_code(400);
    echo json_encode(['error' => 'No appointment ID provided.']);
    exit();
}

$sql = "SELECT 
            u.first_name, 
            u.middle_name, 
            u.last_name, 
            u.gender, 
            u.date_of_birth, 
            u.email, 
            u.contact_number, 
            u.address,
            u.date_created AS user_created,
            u.date_updated,
            a.appointment_date,
            a.appointment_time,
            a.status,
            a.notes,
            a.date_created,
            b.name AS branch_name,
            s.name AS service_name,
            d.first_name AS dentist_first,
            d.last_name AS dentist_last
        FROM appointment_transaction a
        INNER JOIN users u ON a.user_id = u.user_id
        INNER JOIN branch b ON a.branch_id = b.branch_id
        INNER JOIN service s ON a.service_id = s.service_id
        LEFT JOIN dentist d ON a.dentist_id = d.dentist_id
        WHERE a.appointment_transaction_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $appointmentId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $profile = [
        'full_name'       => trim($row['first_name'] . ' ' . ($row['middle_name'] ?? '') . ' ' . $row['last_name']),
        'gender'          => ucfirst($row['gender']),
        'date_of_birth'   => $row['date_of_birth'],
        'email'           => $row['email'],
        'contact_number'  => $row['contact_number'],
        'address'         => $row['address'],
        'joined'          => date("F d, Y", strtotime($row['user_created'])),
        "date_updated"    => $row['date_updated'] ? date("F d, Y", strtotime($row['date_updated'])) : "-",

        'appointment_date' => $row['appointment_date'],
        'appointment_time' => $row['appointment_time'],
        'status'           => $row['status'],
        'notes'            => $row['notes'] ?? '-',

        'branch'          => $row['branch_name'],
        'service'         => $row['service_name'],
        'dentist'         => $row['dentist_first']
                            ? 'Dr. ' . trim($row['dentist_first'] . ' ' . $row['dentist_last'])
                            : 'Not Assigned',
        'date_created'         => $row['date_created'],
        ];

    header('Content-Type: application/json');
    echo json_encode($profile);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Appointment not found or no user linked.']);
}

$conn->close();
