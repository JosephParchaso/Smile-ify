<?php 
session_start(); 
require 'db.php'; 
require 'header.php'; 

$error = '';
if (isset($_SESSION['otp_error'])) {
    $error = $_SESSION['otp_error'];
    unset($_SESSION['otp_error']);
}

if (isset($_SESSION['verified_data'])) { 
    $verified_data = $_SESSION['verified_data']; 
} 
?>

<head>
    <title>OTP Verification</title>
</head>
<body>

<div class="otp-verification-modal">
    <div class="otp-verification-modal-content">
        <h2>OTP Verification</h2>

        <?php if (!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php else: ?>
            <p>We’ve sent a 6-digit code to your email.</p>
        <?php endif; ?>

        <div id="resendMessage" class="error" style="display: none;"></div>

        <form action="../processes/insert_appointment.php" method="POST" autocomplete="off">
            <div class="form-group">
                <input type="text" id="otpCode" class="form-control" name="otpCode" placeholder=" " required maxlength="6" pattern="\d{6}" />
                <label for="otpCode" class="form-label">OTP <span class="required">*</span></label>
            </div>

            <div class="timer">
                Time remaining: <span id="timer"></span>
            </div>

            <div class="button-group">
                <button type="button" id="resendOTPButton" class="form-button cancel-btn" disabled>Resend</button>
                <button type="button" onclick="sessionStorage.clear(); window.location.href='../index.php'" class="form-button cancel-btn">Cancel</button>
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
    const storageKey = "otpExpiryTimestamp_" + "<?php echo $_SESSION['otp_created']; ?>";

    Object.keys(sessionStorage).forEach(key => {
        if (key.startsWith("otpExpiryTimestamp_")) {
            const ts = parseInt(sessionStorage.getItem(key));
            if (Date.now() > ts) {
                sessionStorage.removeItem(key);
            }
        }
    });

    if (phpOtpCreated !== null && !isNaN(phpOtpCreated) && !sessionStorage.getItem(storageKey)) {
        const expiryTime = phpOtpCreated + (expiryLimit * 1000);
        sessionStorage.setItem(storageKey, expiryTime);
    }

    function updateTimerUI() {
        const expiryTime = parseInt(sessionStorage.getItem(storageKey));
        if (!expiryTime) {
            timerEl.innerText = "Time expired";
            resendBtn.disabled = false;
            return;
        }

        const now = Date.now();
        const remaining = Math.floor((expiryTime - now) / 1000);

        if (remaining <= 0) {
            timerEl.innerText = "Time expired";
            resendBtn.disabled = false;
            return;
        }

        resendBtn.disabled = true;
        timerEl.innerText = "0:" + (remaining < 10 ? "0" : "") + remaining;
    }

    function startCountdown() {
        clearInterval(countdown);
        countdown = setInterval(() => {
            const expiryTime = parseInt(sessionStorage.getItem(storageKey));
            const now = Date.now();
            const remaining = Math.floor((expiryTime - now) / 1000);

            if (remaining <= 0) {
                clearInterval(countdown);
                timerEl.innerText = "Time expired";
                resendBtn.disabled = false;
                return;
            }

            timerEl.innerText = "0:" + (remaining < 10 ? "0" : "") + remaining;
            resendBtn.disabled = true;
        }, 1000);
    }

    const expiry = sessionStorage.getItem(storageKey);
    if (expiry && Date.now() < parseInt(expiry)) {
        startCountdown();
    } else {
        updateTimerUI();
    }

    $('#resendOTPButton').click(function () {
        if (this.disabled) return;

        $.ajax({
            url: '../processes/resend_otp.php',
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                const messageDiv = $('#resendMessage');
                if (response.success) {
                    messageDiv.removeClass('error').addClass('success').text(response.message).show();
                    const newExpiry = Date.now() + expiryLimit * 1000;
                    const newKey = "otpExpiryTimestamp_" + Math.floor(Date.now() / 1000);
                    Object.keys(sessionStorage).forEach(key => {
                        if (key.startsWith("otpExpiryTimestamp_")) {
                            sessionStorage.removeItem(key);
                        }
                    });
                    sessionStorage.setItem(newKey, newExpiry);
                    location.reload();
                } else {
                    messageDiv.removeClass('success').addClass('error').text(response.message).show();
                }
            },
            error: function () {
                $('#resendMessage').addClass('error').text('Error resending OTP. Please try again.').show();
            }
        });
    });

    document.querySelector('button[onclick*="index.php"]').addEventListener('click', () => {
        sessionStorage.clear();
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

