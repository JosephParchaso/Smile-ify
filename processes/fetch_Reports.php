<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 0); 
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
header('Content-Type: application/json');


if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'owner' && $_SESSION['role'] !== 'admin')) {
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

try {
    $branch_id = $_GET['branch_id'] ?? null;
    $mode = $_GET['mode'] ?? 'daily'; 

  
    if ($mode === 'daily') {
        $startDate = $endDate = date('Y-m-d');
    } elseif ($mode === 'weekly') {
        $startDate = date('Y-m-d', strtotime('monday this week'));
        $endDate   = date('Y-m-d', strtotime('sunday this week'));
    } elseif ($mode === 'monthly') {
        $startDate = date('Y-m-01');
        $endDate   = date('Y-m-t');
    } else {
        $startDate = $endDate = date('Y-m-d');
    }

   
    $totalServices = 0;
    $totalIncome = 0;
    $baseServiceIncome = 0;
    $extraCharges = 0;
    $topService = "-";
    $newPatients = 0;

    if ($branch_id) {
      
        $sql = "SELECT COUNT(*) AS cnt 
                FROM appointment_transaction 
                WHERE branch_id = ? AND appointment_date BETWEEN ? AND ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $branch_id, $startDate, $endDate);
        $stmt->execute();
        $totalServices = $stmt->get_result()->fetch_assoc()['cnt'] ?? 0;
        $stmt->close();

        
        $sql = "SELECT 
                    SUM(dt.amount_paid) AS total_income,
                    SUM(s.price) AS base_service_income,
                    SUM(dt.amount_paid - s.price) AS extra_charges
                FROM dental_transaction AS dt
                JOIN appointment_transaction AS at 
                    ON dt.appointment_transaction_id = at.appointment_transaction_id
                JOIN service AS s 
                    ON at.service_id = s.service_id
                WHERE at.branch_id = ?
                AND DATE(dt.date_created) BETWEEN ? AND ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $branch_id, $startDate, $endDate);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        $totalIncome = $res['total_income'] ?? 0;
        $baseServiceIncome = $res['base_service_income'] ?? 0;
        $extraCharges = $res['extra_charges'] ?? 0;

        
        $sql = "SELECT s.name AS service_name, COUNT(*) AS cnt
                FROM appointment_transaction AS at
                JOIN service AS s ON at.service_id = s.service_id
                WHERE at.branch_id = ? 
                AND at.appointment_date BETWEEN ? AND ?
                GROUP BY s.name
                ORDER BY cnt DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $branch_id, $startDate, $endDate);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        if ($res) {
            $topService = $res['service_name'] . " — " . $res['cnt'];
        }
        $stmt->close();

     
        $sql = "SELECT COUNT(*) AS cnt 
                FROM users 
                WHERE branch_id = ? AND DATE(date_created) BETWEEN ? AND ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $branch_id, $startDate, $endDate);
        $stmt->execute();
        $newPatients = $stmt->get_result()->fetch_assoc()['cnt'] ?? 0;
        $stmt->close();
    }

    $appointments = ["booked" => 0, "completed" => 0, "cancelled" => 0];
    $sql = "SELECT status, COUNT(*) as cnt 
            FROM appointment_transaction
            WHERE branch_id = ? AND appointment_date BETWEEN ? AND ?
            GROUP BY status";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $branch_id, $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $appointments[strtolower($row['status'])] = (int)$row['cnt'];
    }
    $stmt->close();


    $servicesTrend = [];
    $incomeTrend = [];
    $labels = [];

    if ($mode === 'daily') {
        for ($i = 6; $i >= 0; $i--) {
            $day = date('Y-m-d', strtotime("-$i days"));
            $labels[] = $day;

          
            $sql = "SELECT COUNT(*) as cnt 
                    FROM appointment_transaction 
                    WHERE branch_id = ? AND DATE(appointment_date) = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $branch_id, $day);
            $stmt->execute();
            $servicesTrend[] = (int)$stmt->get_result()->fetch_assoc()['cnt'];
            $stmt->close();

         
            $sql = "SELECT SUM(dt.amount_paid) as total 
                    FROM dental_transaction AS dt
                    JOIN appointment_transaction AS at 
                      ON dt.appointment_transaction_id = at.appointment_transaction_id
                    WHERE at.branch_id = ? 
                      AND DATE(dt.date_created) = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $branch_id, $day);
            $stmt->execute();
            $incomeTrend[] = (float)($stmt->get_result()->fetch_assoc()['total'] ?? 0);
            $stmt->close();
        }
    } elseif ($mode === 'weekly') {
        $days = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];
        foreach ($days as $d) {
            $labels[] = $d;

            $sql = "SELECT COUNT(*) as cnt 
                    FROM appointment_transaction 
                    WHERE branch_id = ? 
                      AND YEARWEEK(appointment_date,1) = YEARWEEK(CURDATE(),1)
                      AND DAYNAME(appointment_date) = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $branch_id, $d);
            $stmt->execute();
            $servicesTrend[] = (int)($stmt->get_result()->fetch_assoc()['cnt'] ?? 0);
            $stmt->close();

            $sql = "SELECT SUM(dt.amount_paid) as total 
                    FROM dental_transaction AS dt
                    JOIN appointment_transaction AS at 
                      ON dt.appointment_transaction_id = at.appointment_transaction_id
                    WHERE at.branch_id = ? 
                      AND YEARWEEK(dt.date_created,1) = YEARWEEK(CURDATE(),1)
                      AND DAYNAME(dt.date_created) = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $branch_id, $d);
            $stmt->execute();
            $incomeTrend[] = (float)($stmt->get_result()->fetch_assoc()['total'] ?? 0);
            $stmt->close();
        }
    } elseif ($mode === 'monthly') {
        $daysInMonth = date('t');
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $labels[] = $d;

            $sql = "SELECT COUNT(*) as cnt 
                    FROM appointment_transaction 
                    WHERE branch_id = ? 
                      AND YEAR(appointment_date) = YEAR(CURDATE()) 
                      AND MONTH(appointment_date) = MONTH(CURDATE()) 
                      AND DAY(appointment_date) = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $branch_id, $d);
            $stmt->execute();
            $servicesTrend[] = (int)($stmt->get_result()->fetch_assoc()['cnt'] ?? 0);
            $stmt->close();

            $sql = "SELECT SUM(dt.amount_paid) as total 
                    FROM dental_transaction AS dt
                    JOIN appointment_transaction AS at 
                      ON dt.appointment_transaction_id = at.appointment_transaction_id
                    WHERE at.branch_id = ? 
                      AND YEAR(dt.date_created) = YEAR(CURDATE()) 
                      AND MONTH(dt.date_created) = MONTH(CURDATE()) 
                      AND DAY(dt.date_created) = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $branch_id, $d);
            $stmt->execute();
            $incomeTrend[] = (float)$stmt->get_result()->fetch_assoc()['total'];
            $stmt->close();
        }
    }

 
    $branchComparison = [];
    $sql = "SELECT b.name, SUM(dt.amount_paid) as total_income
            FROM dental_transaction AS dt
            JOIN appointment_transaction AS at 
              ON dt.appointment_transaction_id = at.appointment_transaction_id
            JOIN branch AS b ON at.branch_id = b.branch_id
            WHERE DATE(dt.date_created) BETWEEN ? AND ?
            GROUP BY b.branch_id";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $branchComparison[$row['name']] = (float)$row['total_income'];
    }
    $stmt->close();

    $staffPerformance = [];
    $sql = "SELECT 
                CONCAT(d.first_name, ' ', d.last_name) AS dentist_name,
                b.name AS branch_name,
                COUNT(dt.dental_transaction_id) AS services_rendered,
                SUM(dt.amount_paid) AS total_income
            FROM dental_transaction AS dt
            JOIN appointment_transaction AS at ON dt.appointment_transaction_id = at.appointment_transaction_id
            JOIN dentist AS d ON dt.dentist_id = d.dentist_id
            JOIN branch AS b ON at.branch_id = b.branch_id
            WHERE DATE(dt.date_created) BETWEEN ? AND ?
            GROUP BY d.dentist_id, b.branch_id
            ORDER BY total_income DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $staffPerformance[] = $row;
    }
    $stmt->close();

    $patientMix = ["new" => 0, "returning" => 0];

    $sql = "SELECT 
                CASE 
                    WHEN DATEDIFF(at.appointment_date, u.date_created) <= 7 THEN 'new'
                    ELSE 'returning'
                END AS patient_type,
                COUNT(*) AS count
            FROM appointment_transaction AS at
            JOIN users AS u ON at.user_id = u.user_id
            WHERE at.branch_id = ?
            AND at.appointment_date BETWEEN ? AND ?
            GROUP BY patient_type";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $branch_id, $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $patientMix[$row['patient_type']] = (int)$row['count'];
    }
    $stmt->close();

    $patientMix = ["new" => 0, "returning" => 0];

    $sql = "SELECT COUNT(*) AS new_patients 
            FROM users 
            WHERE branch_id = ? 
            AND DATE(date_created) BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $branch_id, $startDate, $endDate);
    $stmt->execute();
    $patientMix['new'] = (int)$stmt->get_result()->fetch_assoc()['new_patients'];
    $stmt->close();

    $sql = "SELECT COUNT(DISTINCT a.user_id) AS returning_patients
            FROM appointment_transaction AS a
            JOIN users AS u ON a.user_id = u.user_id
            WHERE a.branch_id = ?
            AND a.appointment_date BETWEEN ? AND ?
            AND DATE(u.date_created) < ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $branch_id, $startDate, $endDate, $startDate);
    $stmt->execute();
    $patientMix['returning'] = (int)$stmt->get_result()->fetch_assoc()['returning_patients'];
    $stmt->close();



    $peakHours = [];
    $sql = "SELECT 
                HOUR(at.appointment_time) AS hour_slot, 
                COUNT(*) AS total_appointments
            FROM appointment_transaction AS at
            WHERE DATE(at.appointment_date) BETWEEN ? AND ?
            GROUP BY HOUR(at.appointment_time)
            ORDER BY hour_slot ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $hourLabel = str_pad($row['hour_slot'], 2, "0", STR_PAD_LEFT) . ":00";
        $peakHours[$hourLabel] = (int)$row['total_appointments'];
    }
    $stmt->close();

    $avgServices = 0;
    $dateCondition = "";

    if ($mode === 'daily') {
        $dateCondition = "DATE(at.appointment_date) = CURDATE()";
    } elseif ($mode === 'weekly') {
        $dateCondition = "YEAR(at.appointment_date) = YEAR(CURDATE()) AND WEEK(at.appointment_date, 1) = WEEK(CURDATE(), 1)";
    } elseif ($mode === 'monthly') {
        $dateCondition = "YEAR(at.appointment_date) = YEAR(CURDATE()) AND MONTH(at.appointment_date) = MONTH(CURDATE())";
    }

    $avgQuery = $conn->prepare("
        SELECT AVG(service_count) AS avgServices
        FROM (
            SELECT at.appointment_transaction_id, COUNT(dts.service_id) AS service_count
            FROM appointment_transaction at
            JOIN dental_transaction dt ON dt.appointment_transaction_id = at.appointment_transaction_id
            JOIN dental_transaction_service dts ON dts.dental_transaction_id = dt.dental_transaction_id
            WHERE at.branch_id = ? AND at.status = 'completed' AND $dateCondition
            GROUP BY at.appointment_transaction_id
        ) AS sub
    ");
    $avgQuery->bind_param("i", $branch_id);
    $avgQuery->execute();
    $avgResult = $avgQuery->get_result()->fetch_assoc();
    if ($avgResult && $avgResult['avgServices'] !== null) {
        $avgServices = round((float)$avgResult['avgServices'], 2);
    }

    $kpi['avgServices'] = $avgServices;
    

    $conn->close();

    echo json_encode([
        "kpi" => [
            "totalServices" => $totalServices,
            "totalIncome" => $totalIncome,
            "baseServiceIncome" => $baseServiceIncome,
            "extraCharges" => $extraCharges,
            "topService" => $topService,
            "newPatients" => $newPatients,
            "avgServices" => $avgServices
        ],
        "appointments" => $appointments,
        "trend" => [
            "labels" => $labels,
            "services" => $servicesTrend,
            "income" => $incomeTrend
        ],
        "branchComparison" => $branchComparison,
        "staffPerformance" => $staffPerformance,
        "patientMix" => $patientMix,
        "peakHours" => $peakHours
    ]);

} catch (Throwable $e) {
    echo json_encode([
        "error" => "Server error",
        "details" => $e->getMessage()
    ]);
    exit;
}
