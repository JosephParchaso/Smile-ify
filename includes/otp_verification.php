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
                Time remaining: <span id="timer">1:00</span>
            </div>

            <div class="button-group">
                <button type="button" id="resendOTPButton" class="form-button cancel-btn">Resend</button>
                <button type="button" onclick="window.location.href='../index.php'" class="form-button cancel-btn">Cancel</button>
                <button type="submit" name="verify" class="form-button confirm-btn">Confirm</button>
            </div>
        </form>
    </div>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var timerEl = document.getElementById("timer");
        var minutes = 1;
        var seconds = 0;

        function startCountdown() {
            var countdown = setInterval(function () {
                if (minutes === 0 && seconds === 0) {
                    clearInterval(countdown);
                    timerEl.innerText = "Time expired";
                    return;
                }

                timerEl.innerText = minutes + ":" + (seconds < 10 ? "0" : "") + seconds;

                if (seconds === 0) {
                    minutes--;
                    seconds = 59;
                } else {
                    seconds--;
                }
            }, 1000);
        }

        startCountdown();

        $('#resendOTPButton').click(function () {
            $.ajax({
                url: '../processes/resend_otp.php',
                type: 'POST',
                dataType: 'json',
                success: function (response) {
                    const messageDiv = $('#resendMessage');

                    if (response.success) {
                        messageDiv
                            .removeClass('error') // Remove red styling
                            .addClass('success') // Optional: use a `.success` class if you want
                            .text(response.message)
                            .css({ color: 'green', background: '#e6ffe6', border: '1px solid green' }) // optional inline
                            .show();

                        // Reset the timer
                        minutes = 1;
                        seconds = 0;
                        startCountdown();
                    } else {
                        messageDiv
                            .removeClass('success') // In case it was previously success
                            .addClass('error')
                            .text(response.message)
                            .show();
                    }
                },
                error: function () {
                    $('#resendMessage')
                        .removeClass('success')
                        .addClass('error')
                        .text('Error resending OTP. Please try again.')
                        .show();
                }
            });
        });
    });
</script>

</body>
</html>
