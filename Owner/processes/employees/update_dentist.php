<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

function isValidEmailDomain($email) {
    $domain = substr(strrchr($email, "@"), 1);
    return checkdnsrr($domain, "MX");
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    header("Location: " . BASE_URL . "/Owner/pages/employees.php?tab=dentist");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $dentistId      = intval($_POST['dentist_id']);
    $lastName       = trim($_POST['lastName']);
    $firstName      = trim($_POST['firstName']);
    $middleName     = trim($_POST['middleName']);
    $gender         = $_POST['gender'];
    $dateofBirth    = $_POST['dateofBirth'] ?? '';
    $email          = trim($_POST['email']);
    $contactNumber  = trim($_POST['contactNumber']);
    $licenseNumber  = trim($_POST['licenseNumber']);
    $dateStarted    = trim($_POST['dateStarted']);
    $status         = $_POST['status'];
    $ignoreScheduleUpdate = ($status === 'Inactive');

    $branches       = isset($_POST['branches']) ? array_map('intval', $_POST['branches']) : [];
    $services       = isset($_POST['services']) ? array_map('intval', $_POST['services']) : [];
    $schedule       = isset($_POST['schedule']) ? $_POST['schedule'] : [];

    if (!empty($email) && !isValidEmailDomain($email)) {
        $_SESSION['updateError'] = "Email domain is not valid or unreachable.";
        header("Location: " . BASE_URL . "/Owner/pages/employees.php?tab=dentist");
        exit();
    }

    $checkSql = "SELECT last_name, first_name, middle_name, gender,
                        date_of_birth, date_of_birth_iv, date_of_birth_tag,
                        email, contact_number, contact_number_iv, contact_number_tag,
                        license_number, license_number_iv, license_number_tag,
                        date_started, status, signature_image, profile_image
                    FROM dentist WHERE dentist_id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $dentistId);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    $current = $result->fetch_assoc();
    $checkStmt->close();

    if (!$current) {
        $_SESSION['updateError'] = "Dentist not found.";
        header("Location: " . BASE_URL . "/Owner/pages/employees.php?tab=dentist");
        exit();
    }

    $current_dob = decryptField($current['date_of_birth'], $current['date_of_birth_iv'], $current['date_of_birth_tag'], $ENCRYPTION_KEY);
    $current_contact = decryptField($current['contact_number'], $current['contact_number_iv'], $current['contact_number_tag'], $ENCRYPTION_KEY);
    $current_license = decryptField($current['license_number'], $current['license_number_iv'], $current['license_number_tag'], $ENCRYPTION_KEY);

    $changed = false;
    $signatureImage = $current['signature_image'];
    $profileImage   = $current['profile_image'];

    $safeLast  = strtolower(preg_replace("/[^a-zA-Z0-9]+/", "_", $lastName));

    if (!empty($_POST['profileCleared']) && $_POST['profileCleared'] === "1") {

        if (!empty($current['profile_image'])) {
            $oldPath = BASE_PATH . '/images/dentists/profile/' . $current['profile_image'];
            if (file_exists($oldPath)) unlink($oldPath);
        }
        $profileImage = null;
        $changed = true;

    } elseif (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {

        $uploadDir = BASE_PATH . '/images/dentists/profile/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $fileExt = strtolower(pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION));
        $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($fileExt, $allowedExt)) {
            $_SESSION['updateError'] = "Invalid profile image type. Only JPG, PNG, or WEBP allowed.";
            header("Location: " . BASE_URL . "/Owner/pages/employees.php?tab=dentist");
            exit();
        }

        if (!empty($current['profile_image'])) {
            $oldPath = $uploadDir . $current['profile_image'];
            if (file_exists($oldPath)) unlink($oldPath);
        }

        $fileName = "{$dentistId}_{$safeLast}_profile." . $fileExt;

        if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $uploadDir . $fileName)) {
            $profileImage = $fileName;
            $changed = true;
        }
    }

    if (!empty($_POST['signatureCleared']) && $_POST['signatureCleared'] === "1") {

        if (!empty($current['signature_image'])) {
            $oldPath = BASE_PATH . '/images/dentists/signature/' . $current['signature_image'];
            if (file_exists($oldPath)) unlink($oldPath);
        }
        $signatureImage = null;
        $changed = true;

    } elseif (isset($_FILES['signatureImage']) && $_FILES['signatureImage']['error'] === UPLOAD_ERR_OK) {

        $uploadDir = BASE_PATH . '/images/dentists/signature/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $fileExt = strtolower(pathinfo($_FILES['signatureImage']['name'], PATHINFO_EXTENSION));
        $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($fileExt, $allowedExt)) {
            $_SESSION['updateError'] = "Invalid signature image type. Only JPG, PNG, or WEBP allowed.";
            header("Location: " . BASE_URL . "/Owner/pages/employees.php?tab=dentist");
            exit();
        }

        if (!empty($current['signature_image'])) {
            $oldPath = $uploadDir . $current['signature_image'];
            if (file_exists($oldPath)) unlink($oldPath);
        }

        $fileName = "{$dentistId}_{$safeLast}_signature." . $fileExt;

        if (move_uploaded_file($_FILES['signatureImage']['tmp_name'], $uploadDir . $fileName)) {
            $signatureImage = $fileName;
            $changed = true;
        }
    }

    $hasChanges = (
        $current['last_name'] !== $lastName ||
        $current['first_name'] !== $firstName ||
        $current['middle_name'] !== $middleName ||
        $current['gender'] !== $gender ||
        $current_dob !== $dateofBirth ||
        $current['email'] !== $email ||
        $current_contact !== $contactNumber ||
        $current_license !== $licenseNumber ||
        $current['date_started'] !== $dateStarted ||
        $current['status'] !== $status ||
        $current['signature_image'] !== $signatureImage ||
        $current['profile_image'] !== $profileImage
    );

    if ($hasChanges) {

        $conn->begin_transaction();

        try {

            [$dob_enc, $dob_iv, $dob_tag]         = encryptField($dateofBirth, $ENCRYPTION_KEY);
            [$contact_enc, $contact_iv, $contact_tag] = encryptField($contactNumber, $ENCRYPTION_KEY);
            [$license_enc, $license_iv, $license_tag] = encryptField($licenseNumber, $ENCRYPTION_KEY);

            $sql = "UPDATE dentist
                    SET last_name=?, first_name=?, middle_name=?, gender=?,
                        date_of_birth=?, date_of_birth_iv=?, date_of_birth_tag=?,
                        email=?,
                        contact_number=?, contact_number_iv=?, contact_number_tag=?,
                        license_number=?, license_number_iv=?, license_number_tag=?,
                        date_started=?, status=?, signature_image=?, profile_image=?
                    WHERE dentist_id=?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "ssssssssssssssssssi",
                $lastName, $firstName, $middleName, $gender,
                $dob_enc, $dob_iv, $dob_tag,
                $email,
                $contact_enc, $contact_iv, $contact_tag,
                $license_enc, $license_iv, $license_tag,
                $dateStarted, $status, $signatureImage, $profileImage,
                $dentistId
            );
            $stmt->execute();
            $stmt->close();

            $changed = true;

            if ($current['status'] === 'Active' && $status === 'Inactive') {

                if (($_POST['confirmDentistUpdate'] ?? '0') !== '1') {
                    throw new Exception("Dentist deactivation not confirmed.");
                }

                $apptSql = "
                    SELECT 
                        at.appointment_transaction_id,
                        at.user_id,
                        u.guardian_id
                    FROM appointment_transaction at
                    JOIN users u ON u.user_id = at.user_id
                    WHERE at.dentist_id = ?
                    AND at.status = 'Booked'
                    AND at.appointment_date >= CURDATE()
                ";

                $apptStmt = $conn->prepare($apptSql);
                $apptStmt->bind_param("i", $dentistId);
                $apptStmt->execute();
                $appointments = $apptStmt->get_result()->fetch_all(MYSQLI_ASSOC);
                $apptStmt->close();

                if (!empty($appointments)) {

                    $updateAppt = $conn->prepare("
                        UPDATE appointment_transaction
                        SET status = 'Pending Reschedule'
                        WHERE appointment_transaction_id = ?
                    ");

                    $notif = $conn->prepare("
                        INSERT INTO notifications (user_id, appointment_transaction_id, message)
                        VALUES (?, ?, ?)
                    ");

                    foreach ($appointments as $appt) {

                        $appointmentTransactionId = (int)$appt['appointment_transaction_id'];

                        $updateAppt->bind_param("i", $appointmentTransactionId);
                        $updateAppt->execute();

                        $notifyUserId = !empty($appt['guardian_id'])
                            ? (int)$appt['guardian_id']
                            : (int)$appt['user_id'];

                        $message = "Your dental appointment requires action.
                                    Dr. {$current['first_name']} {$current['last_name']} is no longer available. Please reschedule or cancel.";



                        $notif->bind_param(
                            "iis",
                            $notifyUserId,
                            $appointmentTransactionId,
                            $message
                        );
                        $notif->execute();
                    }

                    $updateAppt->close();
                    $notif->close();
                }
            }

            $upd = $conn->prepare("UPDATE dentist SET date_updated = NOW() WHERE dentist_id = ?");
            $upd->bind_param("i", $dentistId);
            $upd->execute();
            $upd->close();

            $conn->commit();

            $_SESSION['updateSuccess'] = "Dentist updated successfully!";

        } catch (Exception $e) {

            $conn->rollback();
            $_SESSION['updateError'] = "Failed to update dentist and affected appointments.";
            header("Location: " . BASE_URL . "/Owner/pages/employees.php?tab=dentist");
            exit;
        }
    }

    $currentBranches = [];
    $res = $conn->prepare("SELECT branch_id FROM dentist_branch WHERE dentist_id = ?");
    $res->bind_param("i", $dentistId);
    $res->execute();
    $result = $res->get_result();
    while ($row = $result->fetch_assoc()) $currentBranches[] = (int)$row['branch_id'];
    $res->close();

    sort($currentBranches);
    sort($branches);

    if ($currentBranches !== $branches) {

        $del = $conn->prepare("DELETE FROM dentist_branch WHERE dentist_id=?");
        $del->bind_param("i", $dentistId);
        $del->execute();
        $del->close();

        if (!empty($branches)) {
            $stmt = $conn->prepare("INSERT INTO dentist_branch (dentist_id, branch_id) VALUES (?,?)");
            foreach ($branches as $b) {
                $stmt->bind_param("ii", $dentistId, $b);
                $stmt->execute();
            }
            $stmt->close();
        }

        $changed = true;
    }

    $currentServices = [];
    $res = $conn->prepare("SELECT service_id FROM dentist_service WHERE dentist_id=?");
    $res->bind_param("i", $dentistId);
    $res->execute();
    $result = $res->get_result();
    while ($row = $result->fetch_assoc()) $currentServices[] = (int)$row['service_id'];
    $res->close();

    sort($currentServices);
    sort($services);

    if ($currentServices !== $services) {

        $del = $conn->prepare("DELETE FROM dentist_service WHERE dentist_id=?");
        $del->bind_param("i", $dentistId);
        $del->execute();
        $del->close();

        if (!empty($services)) {
            $stmt = $conn->prepare("INSERT INTO dentist_service (dentist_id, service_id) VALUES (?,?)");
            foreach ($services as $s) {
                $stmt->bind_param("ii", $dentistId, $s);
                $stmt->execute();
            }
            $stmt->close();
        }

        $changed = true;
    }

    $scheduleSubmitted = array_key_exists('schedule', $_POST);

    if (!$ignoreScheduleUpdate && $scheduleSubmitted) {

        $currentSched = [];
        $res = $conn->prepare("
            SELECT day, branch_id, start_time, end_time
            FROM dentist_schedule
            WHERE dentist_id=?
            ORDER BY day, branch_id, start_time
        ");
        $res->bind_param("i", $dentistId);
        $res->execute();
        $result = $res->get_result();
        while ($row = $result->fetch_assoc()) {
            $currentSched[] = [
                "day"        => $row["day"],
                "branch_id"  => (int)$row["branch_id"],
                "start_time" => $row["start_time"],
                "end_time"   => $row["end_time"]
            ];
        }
        $res->close();

        $newSched = [];

        foreach ($schedule as $day => $entries) {
            $branchesArr = $entries["branch"] ?? [];
            $startArr    = $entries["start"] ?? [];
            $endArr      = $entries["end"] ?? [];

            for ($i = 0; $i < count($branchesArr); $i++) {
                if (empty($branchesArr[$i])) continue;

                $newSched[] = [
                    "day"        => $day,
                    "branch_id"  => (int)$branchesArr[$i],
                    "start_time" => $startArr[$i] ?? "09:00",
                    "end_time"   => $endArr[$i] ?? "16:00"
                ];
            }
        }

        $sortFn = function ($a, $b) {
            return strcmp(
                $a["day"] . $a["branch_id"] . $a["start_time"] . $a["end_time"],
                $b["day"] . $b["branch_id"] . $b["start_time"] . $b["end_time"]
            );
        };

        usort($currentSched, $sortFn);
        usort($newSched, $sortFn);

        if (json_encode($currentSched) !== json_encode($newSched)) {

            $del = $conn->prepare("DELETE FROM dentist_schedule WHERE dentist_id=?");
            $del->bind_param("i", $dentistId);
            $del->execute();
            $del->close();

            if (!empty($newSched)) {
                $stmt = $conn->prepare("
                    INSERT INTO dentist_schedule (dentist_id, day, branch_id, start_time, end_time)
                    VALUES (?, ?, ?, ?, ?)
                ");

                foreach ($newSched as $s) {
                    $stmt->bind_param(
                        "isiss",
                        $dentistId,
                        $s["day"],
                        $s["branch_id"],
                        $s["start_time"],
                        $s["end_time"]
                    );
                    $stmt->execute();
                }
                $stmt->close();
            }

            $changed = true;
        }
    }

    if ($changed) {

        $upd = $conn->prepare("UPDATE dentist SET date_updated = NOW() WHERE dentist_id = ?");
        $upd->bind_param("i", $dentistId);
        $upd->execute();
        $upd->close();

        $_SESSION['updateSuccess'] = "Dentist updated successfully!";
    }

    $conn->close();
    header("Location: " . BASE_URL . "/Owner/pages/employees.php?tab=dentist");
    exit();
}

header("Location: " . BASE_URL . "/Owner/pages/employees.php?tab=dentist");
exit();
?>
