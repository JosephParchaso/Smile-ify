<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once BASE_PATH . '/includes/db.php';
require_once BASE_PATH . '/includes/header.php';

if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    header("Location: " . BASE_URL . "/index.php");
    exit;
}

$emailError = '';
if (isset($_SESSION['updateError'])) {
    $emailError = $_SESSION['updateError'];
    unset($_SESSION['updateError']);
}

$role = $_SESSION['role'] ?? 'patient';
$redirects = [
    'admin' => BASE_URL . '/Admin/pages/profile.php',
    'owner' => BASE_URL . '/Owner/pages/profile.php',
    'patient' => BASE_URL . '/Patient/pages/profile.php'
];

$cancelRedirect = $redirects[$role] ?? BASE_URL . '/Patient/pages/profile.php';
?>

<head>
    <title>Email Reset</title>
</head>
<body>
    <div class="reset-password-modal">
        <div class="reset-password-modal-content">
            <h2>Email Reset</h2>

            <?php if (!empty($emailError)): ?>
                <div class="error"><?= htmlspecialchars($emailError) ?></div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>/processes/OTP Processes/change_email/reset_email.php" method="POST" autocomplete="off">
                <div class="form-group">
                    <input type="email" id="newEmail" name="new_email" class="form-control" placeholder=" " required
                        title="Please enter a valid email address" />
                    <label for="newEmail" class="form-label">Enter New Email <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="email" id="confirmEmail" name="confirm_email" class="form-control" placeholder=" " required
                        pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                        title="Please enter a valid email address" />
                    <label for="confirmEmail" class="form-label">Confirm New Email <span class="required">*</span></label>
                </div>

                <div class="button-group">
                    <button type="submit" name="verify" class="form-button confirm-btn" id="confirmButton">Confirm</button>
                    <button type="button" onclick="sessionStorage.clear(); window.location.href='<?= $cancelRedirect ?>'" class="form-button cancel-btn">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</body>
