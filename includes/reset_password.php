<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';
require_once BASE_PATH . '/includes/header.php';

if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    header("Location: " . BASE_URL . "/index.php");
    exit;
}
?>

<head>
    <title>Password Reset</title>
</head>
<body>
    <div class="reset-password-modal">
        <div class="reset-password-modal-content">
            <h2>Password Reset</h2>
            <?php if (!empty($error)): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="<?= BASE_URL ?>/processes/process_reset_password.php" method="POST">
                <div class="form-group">
                    <input type="password" name="new_password" class="form-control" placeholder=" " required autocomplete="off"/>
                    <label for="new_password" class="form-label">Enter Password <span class="required">*</span></label>
                </div>
                <div class="form-group">
                    <input type="password" name="confirm_password" class="form-control" placeholder=" " required autocomplete="off"/>
                    <label for="confirm_password" class="form-label">Confirm Password <span class="required">*</span></label>
                </div>
                <div class="button-group">
                    <button type="submit" name="verify" class="form-button confirm-btn" id="confirmButton">Confirm</button>
                    <button type="button" onclick="sessionStorage.clear(); window.location.href='<?= BASE_URL ?>/index.php'" class="form-button cancel-btn">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</body>