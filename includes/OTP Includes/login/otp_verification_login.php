<?php 
session_start(); 

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';
require_once BASE_PATH . '/includes/header.php';

$error = '';
if (isset($_SESSION['otp_error'])) {
    $error = $_SESSION['otp_error'];
    unset($_SESSION['otp_error']);
}

$pendingUser = $_SESSION['pending_login_user'] ?? null;

function maskEmail($email, $visibleCount = 3) {
    if (strpos($email, '@') === false) return $email;
    list($local, $domain) = explode('@', $email);
    $visible = substr($local, 0, $visibleCount);
    $masked = $visible . str_repeat('*', max(0, strlen($local) - $visibleCount));
    return $masked . '@' . $domain;
}

$maskedEmail = $pendingUser && !empty($pendingUser['email'])
    ? maskEmail($pendingUser['email'])
    : '(no email found)';
?>

<head>
    <title>OTP Verification - Login</title>
</head>
<body>

<div class="otp-verification-modal">
    <div class="otp-verification-modal-content">
        <h2>Login OTP Verification</h2>
        <p>
            We’ve sent a 6-digit code to your email:
            <strong><?= htmlspecialchars($maskedEmail) ?></strong>
        </p>

        <?php if (!empty($error)): ?>
            <div class="error" id="otpError"><?= htmlspecialchars($error) ?></div>
            <script>
                setTimeout(() => {
                    const el = document.getElementById("otpError");
                    if (el) {
                        el.style.transition = "opacity 0.5s ease";
                        el.style.opacity = "0";
                        setTimeout(() => el.remove(), 500);
                    }
                }, 10000);
            </script>
        <?php endif; ?>

        <div id="resendMessage" class="error" style="display: none;"></div>

        <form action="<?= BASE_URL ?>/processes/OTP Processes/login/verify_otp_login.php" method="POST" autocomplete="off">
            <div class="form-group">
                <input type="text" id="otpCode" class="form-control" name="otpCode" placeholder=" " required maxlength="6" pattern="[0-9]{6}" inputmode="numeric" title="Please enter a 6-digit number" oninput="this.value=this.value.replace(/[^0-9]/g,'')" />
                <label for="otpCode" class="form-label">OTP <span class="required">*</span></label>
            </div>

            <div class="timer">
                Time remaining: <span id="timer"></span>
            </div>

            <div class="button-group">
                <button type="button" id="resendOTPButton" class="form-button cancel-btn" disabled>Resend</button>
                <button type="button" onclick="sessionStorage.clear(); window.location.href='<?= BASE_URL ?>/index.php'" class="form-button cancel-btn">Cancel</button>
                <button type="submit" name="verify" class="form-button confirm-btn" id="confirmButton">Confirm</button>
            </div>
        </form>
    </div>
</div>
</body>

<script>

document.addEventListener('DOMContentLoaded', function () {
    const timerEl = document.getElementById("timer");
    const resendBtn = document.getElementById("resendOTPButton");
    const expiryLimit = 60;
    let countdown;

    const phpOtpCreated = <?php echo isset($_SESSION['otp_created']) ? ($_SESSION['otp_created'] * 1000) : 'null'; ?>;
    let storageKey = "otpExpiryTimestamp_" + "<?php echo $_SESSION['otp_created']; ?>";

    Object.keys(sessionStorage).forEach(key => {
        if (key.startsWith("otpExpiryTimestamp_") && Date.now() > parseInt(sessionStorage.getItem(key))) {
            sessionStorage.removeItem(key);
        }
    });

    if (phpOtpCreated && !sessionStorage.getItem(storageKey)) {
        const expiryTime = phpOtpCreated + expiryLimit * 1000;
        sessionStorage.setItem(storageKey, expiryTime);
    }

    function updateTimerUI() {
        const expiryTime = parseInt(sessionStorage.getItem(storageKey));
        if (!expiryTime || Date.now() >= expiryTime) {
            timerEl.innerText = "Time expired";
            resendBtn.disabled = false;
            return;
        }

        const remaining = Math.floor((expiryTime - Date.now()) / 1000);
        resendBtn.disabled = true;
        timerEl.innerText = "0:" + (remaining < 10 ? "0" : "") + remaining;
    }

    function startCountdown() {
        clearInterval(countdown);
        countdown = setInterval(() => {
            updateTimerUI();
        }, 1000);
    }

    if (sessionStorage.getItem(storageKey)) {
        startCountdown();
    } else {
        updateTimerUI();
    }

    $('#resendOTPButton').click(function () {
        if (this.disabled) return;

        const messageDiv = $('#resendMessage');
        
        messageDiv.removeClass('error')
                .addClass('success')
                .text('Resending OTP')
                .show();

        $.ajax({
            url: BASE_URL + '/processes/OTP Processes/resend_otp.php',
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    messageDiv.removeClass('error')
                            .addClass('success')
                            .text('OTP resent successfully.')
                            .show();

                    setTimeout(() => {
                        messageDiv.fadeOut();
                    }, 10000);

                    const newTimestamp = Math.floor(Date.now() / 1000);
                    const newKey = "otpExpiryTimestamp_" + newTimestamp;
                    const newExpiry = Date.now() + expiryLimit * 1000;

                    Object.keys(sessionStorage).forEach(key => {
                        if (key.startsWith("otpExpiryTimestamp_")) {
                            sessionStorage.removeItem(key);
                        }
                    });
                    sessionStorage.setItem(newKey, newExpiry);
                    storageKey = newKey;
                    startCountdown();
                } else {
                    messageDiv.removeClass('success')
                            .addClass('error')
                            .text(response.message)
                            .show();
                }
            },
            error: function () {
                messageDiv.removeClass('success')
                        .addClass('error')
                        .text('Error resending OTP. Please try again.')
                        .show();
            }
        });
    });

    const confirmBtn = document.getElementById("confirmButton");
    confirmBtn.addEventListener("click", function (e) {
        const keys = Object.keys(sessionStorage).filter(k => k.startsWith("otpExpiryTimestamp_"));
        const expiryTime = keys.length > 0 ? parseInt(sessionStorage.getItem(keys[0])) : null;

        if (!expiryTime || Date.now() > expiryTime) {
            e.preventDefault();
            $('#resendMessage')
                .removeClass('success')
                .addClass('error')
                .text('OTP expired. Please resend to get a new code.')
                .show();
        }
    });
});
</script>
