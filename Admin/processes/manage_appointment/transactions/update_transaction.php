<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . BASE_URL . "/index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $dental_transaction_id = intval($_POST['dental_transaction_id']);
    $appointment_transaction_id = intval($_POST['appointment_transaction_id']);
    $dentist_id = intval($_POST['dentist_id']);
    $promo_id = !empty($_POST['promo_id']) ? intval($_POST['promo_id']) : null;
    $payment_method = $_POST['payment_method'] ?? null;
    $notes = trim($_POST['notes'] ?? '');
    $total_payment = floatval($_POST['total_payment'] ?? 0);
    $additional_payment = floatval($_POST['additional_payment'] ?? 0);
    $admin_user_id = intval($_SESSION['user_id']);
    $services = $_POST['appointmentServices'] ?? [];
    $quantities = $_POST['serviceQuantity'] ?? [];
    $fitness_status = trim($_POST['fitness_status'] ?? '');
    $diagnosis = trim($_POST['diagnosis'] ?? '');
    $remarks = trim($_POST['remarks'] ?? '');

    try {
        $stmt = $conn->prepare("
            SELECT dentist_id, promo_id, payment_method, total, additional_payment,
                    notes, fitness_status, diagnosis, remarks
            FROM dental_transaction 
            WHERE dental_transaction_id = ? AND appointment_transaction_id = ?
        ");
        $stmt->bind_param("ii", $dental_transaction_id, $appointment_transaction_id);
        $stmt->execute();
        $existing = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$existing) {
            $_SESSION['updateError'] = "Transaction not found.";
            header("Location: " . BASE_URL . "/Admin/pages/manage_appointment.php?id=" . $appointment_transaction_id);
            exit();
        }

        $hasChanges =
            $existing['dentist_id'] != $dentist_id ||
            $existing['promo_id'] != $promo_id ||
            $existing['payment_method'] !== $payment_method ||
            $existing['total'] != $total_payment ||
            $existing['additional_payment'] != $additional_payment ||
            trim($existing['notes']) !== $notes ||
            trim($existing['fitness_status']) !== $fitness_status ||
            trim($existing['diagnosis']) !== $diagnosis ||
            trim($existing['remarks']) !== $remarks;

        $servicesChanged = false;

        $oldServices = [];
        $resOld = $conn->query("
            SELECT service_id, quantity
            FROM dental_transaction_services
            WHERE dental_transaction_id = {$dental_transaction_id}
        ");

        while ($row = $resOld->fetch_assoc()) {
            $oldServices[$row['service_id']] = intval($row['quantity']);
        }

        if (count($oldServices) !== count($services)) {
            $servicesChanged = true;
        } else {
            foreach ($services as $svcId) {
                $svcId = intval($svcId);
                if (!isset($oldServices[$svcId])) {
                    $servicesChanged = true;
                    break;
                }
                $oldQty = $oldServices[$svcId];
                $newQty = isset($quantities[$svcId]) ? intval($quantities[$svcId]) : 1;
                if ($oldQty != $newQty) {
                    $servicesChanged = true;
                    break;
                }
            }
        }

        $xrayChanged = false;
        if (isset($_FILES['xray_file']['name'])) {
            foreach ($_FILES['xray_file']['name'] as $serviceId => $files) {
                foreach ($files as $fileName) {
                    if (!empty($fileName)) {
                        $xrayChanged = true;
                        break 2;
                    }
                }
            }
        }

        $conn->begin_transaction();

        $receiptChanged = false; 

        $removed_receipt = $_POST['removed_receipt'] ?? "0";

        if ($removed_receipt !== "0") {
            $oldPath = BASE_PATH . $removed_receipt;
            if (is_file($oldPath)) unlink($oldPath);

            $clr = $conn->prepare("
                UPDATE dental_transaction 
                SET cashless_receipt = NULL, date_updated = NOW()
                WHERE dental_transaction_id = ?
            ");
            $clr->bind_param("i", $dental_transaction_id);
            $clr->execute();
            $clr->close();

            $receiptChanged = true;
        }

        $removed_xrays = json_decode($_POST['removed_xrays'] ?? "[]", true);

        if (!empty($removed_xrays)) {
            foreach ($removed_xrays as $rx) {
                $svc = intval($rx['service_id']);
                $filepath = $rx['file_path'];

                $full = BASE_PATH . "/" . $filepath;
                if (is_file($full)) unlink($full);

                $conn->query("
                    DELETE FROM transaction_xrays 
                    WHERE dental_transaction_id = {$dental_transaction_id}
                    AND service_id = {$svc}
                    AND file_path = '{$filepath}'
                ");

                $xrayChanged = true;
            }
        }

        if ($hasChanges) {
            $promo_name_snapshot = null;
            $promo_type_snapshot = null;
            $promo_value_snapshot = null;

            if (!empty($promo_id)) {
                $p = $conn->prepare("SELECT name, discount_type, discount_value FROM promo WHERE promo_id = ?");
                $p->bind_param("i", $promo_id);
                $p->execute();
                $promo = $p->get_result()->fetch_assoc();
                $p->close();
                if ($promo) {
                    $promo_name_snapshot = $promo['name'];
                    $promo_type_snapshot = $promo['discount_type'];
                    $promo_value_snapshot = $promo['discount_value'];
                }
            }

            $u = $conn->prepare("
                UPDATE dental_transaction 
                SET dentist_id=?, promo_id=?, payment_method=?, total=?, additional_payment=?, 
                    notes=?, fitness_status=?, diagnosis=?, remarks=?, admin_user_id=?, 
                    date_updated=NOW(), promo_name=?, promo_type=?, promo_value=?
                WHERE dental_transaction_id=? AND appointment_transaction_id=?
            ");
            $u->bind_param(
                "iisddssssisssii",
                $dentist_id, $promo_id, $payment_method, $total_payment, $additional_payment,
                $notes, $fitness_status, $diagnosis, $remarks, $admin_user_id,
                $promo_name_snapshot, $promo_type_snapshot, $promo_value_snapshot,
                $dental_transaction_id, $appointment_transaction_id
            );
            $u->execute();
            $u->close();

            if (strtolower($payment_method) === 'cash') {
                $rc = $conn->prepare("SELECT cashless_receipt FROM dental_transaction WHERE dental_transaction_id=?");
                $rc->bind_param("i", $dental_transaction_id);
                $rc->execute();
                $receipt = $rc->get_result()->fetch_assoc();
                $rc->close();

                if (!empty($receipt['cashless_receipt'])) {
                    $oldPath = BASE_PATH . $receipt['cashless_receipt'];
                    if (is_file($oldPath)) unlink($oldPath);
                    $clr = $conn->prepare("UPDATE dental_transaction SET cashless_receipt=NULL, date_updated=NOW() WHERE dental_transaction_id=?");
                    $clr->bind_param("i", $dental_transaction_id);
                    $clr->execute();
                    $clr->close();
                }
            }
        }

        if ($servicesChanged) {
            $conn->query("DELETE FROM dental_transaction_services WHERE dental_transaction_id={$dental_transaction_id}");

            if (!empty($services)) {
                $idStr = implode(',', array_map('intval', $services));
                $srv = $conn->query("SELECT service_id, name, price FROM service WHERE service_id IN ($idStr)");
                $map = [];
                while ($r = $srv->fetch_assoc()) {
                    $map[$r['service_id']] = ['name' => $r['name'], 'price' => $r['price']];
                }

                $ins = $conn->prepare("
                    INSERT INTO dental_transaction_services
                    (dental_transaction_id, service_id, service_name, service_price, quantity)
                    VALUES (?, ?, ?, ?, ?)
                ");

                foreach ($services as $sid) {
                    $q = isset($quantities[$sid]) ? intval($quantities[$sid]) : 1;
                    $ins->bind_param("iisdi", $dental_transaction_id, $sid, $map[$sid]['name'], $map[$sid]['price'], $q);
                    $ins->execute();
                }
                $ins->close();
            }
        }

        $receiptChanged = false;
        if (strtolower($payment_method) === 'cashless' &&
            isset($_FILES['receipt_upload']) &&
            $_FILES['receipt_upload']['error'] === UPLOAD_ERR_OK) {

            $receiptChanged = true;

            $gp = $conn->prepare("
                SELECT u.last_name 
                FROM appointment_transaction at
                JOIN users u ON u.user_id = at.user_id
                WHERE at.appointment_transaction_id=?
            ");
            $gp->bind_param("i", $appointment_transaction_id);
            $gp->execute();
            $p = $gp->get_result()->fetch_assoc();
            $gp->close();
            $last_name_clean = $p ? preg_replace('/[^a-zA-Z0-9_-]/', '', strtolower($p['last_name'])) : 'unknown';

            $fileTmpPath = $_FILES['receipt_upload']['tmp_name'];
            $fileExt = strtolower(pathinfo($_FILES['receipt_upload']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            if (!in_array($fileExt, $allowed)) {
                $_SESSION['updateError'] = "Invalid file type.";
                header("Location: " . BASE_URL . "/Admin/pages/manage_appointment.php?id={$appointment_transaction_id}&backTab=recent&tab=transaction");
                exit();
            }

            $dir = BASE_PATH . '/images/payments/cashless_payments/';
            if (!is_dir($dir)) mkdir($dir, 0777, true);

            foreach (glob($dir . $dental_transaction_id . "_*.*") as $old) {
                unlink($old);
            }

            $fileName = "{$dental_transaction_id}_{$last_name_clean}.{$fileExt}";
            $target = $dir . $fileName;
            move_uploaded_file($fileTmpPath, $target);

            $path = "/images/payments/cashless_payments/" . $fileName;
            $ur = $conn->prepare("UPDATE dental_transaction SET cashless_receipt=?, date_updated=NOW() WHERE dental_transaction_id=?");
            $ur->bind_param("si", $path, $dental_transaction_id);
            $ur->execute();
            $ur->close();
        }

        $xrayDir = BASE_PATH . "/images/transactions/xrays/";
        if (!is_dir($xrayDir)) mkdir($xrayDir, 0777, true);

        $gp = $conn->prepare("
            SELECT u.last_name 
            FROM appointment_transaction at
            JOIN users u ON u.user_id = at.user_id
            WHERE at.appointment_transaction_id=?
        ");
        $gp->bind_param("i", $appointment_transaction_id);
        $gp->execute();
        $p = $gp->get_result()->fetch_assoc();
        $gp->close();
        $last_name_clean = $p ? preg_replace('/[^a-zA-Z0-9_-]/', '', strtolower($p['last_name'])) : 'unknown';

        $gname = $conn->prepare("SELECT name FROM service WHERE service_id=?");

        if ($xrayChanged) {
            foreach ($_FILES['xray_file']['name'] as $serviceId => $files) {
                $svcId = intval($serviceId);
                $newExists = false;
                foreach ($files as $f) {
                    if (!empty($f)) {
                        $newExists = true;
                        break;
                    }
                }
                if (!$newExists) continue;

                $old = $conn->prepare("SELECT file_path FROM transaction_xrays WHERE dental_transaction_id=? AND service_id=?");
                $old->bind_param("ii", $dental_transaction_id, $svcId);
                $old->execute();
                $res = $old->get_result();
                while ($row = $res->fetch_assoc()) {
                    $p = BASE_PATH . "/" . $row['file_path'];
                    if (is_file($p)) unlink($p);
                }
                $conn->query("DELETE FROM transaction_xrays WHERE dental_transaction_id={$dental_transaction_id} AND service_id={$svcId}");

                $gname->bind_param("i", $svcId);
                $gname->execute();
                $s = $gname->get_result()->fetch_assoc();
                $cleanService = $s ? preg_replace('/[^a-zA-Z0-9_-]/', '', $s['name']) : "service{$svcId}";

                foreach ($files as $i => $orig) {
                    if (empty($orig)) continue;

                    $tmp = $_FILES['xray_file']['tmp_name'][$serviceId][$i];
                    $ext = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
                    $ext = preg_replace('/[^a-z0-9]/', '', $ext);

                    $new = "{$dental_transaction_id}_{$last_name_clean}_{$cleanService}_" . ($i + 1) . ".{$ext}";
                    $target = $xrayDir . $new;
                    move_uploaded_file($tmp, $target);
                    $rel = "images/transactions/xrays/" . $new;

                    $ix = $conn->prepare("
                        INSERT INTO transaction_xrays (dental_transaction_id, service_id, file_path, date_created)
                        VALUES (?, ?, ?, NOW())
                    ");
                    $ix->bind_param("iis", $dental_transaction_id, $svcId, $rel);
                    $ix->execute();
                    $ix->close();
                }
            }
        }

        $gname->close();

        $conn->commit();

        if ($hasChanges || $servicesChanged || $receiptChanged || $xrayChanged) {
            $_SESSION['updateSuccess'] = "Transaction updated successfully!";
        }

    } catch (Exception $e) {
        if ($conn->in_transaction()) $conn->rollback();
        $_SESSION['updateError'] = "Failed to update transaction.";
    }

    header("Location: " . BASE_URL . "/Admin/pages/manage_appointment.php?id={$appointment_transaction_id}&backTab=recent&tab=transaction");
    exit();
}
?>
