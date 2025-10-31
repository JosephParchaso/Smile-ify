<?php
session_start();

$currentPage = 'profile';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    session_unset();
    session_destroy();
    header("Location: " . BASE_URL . "/index.php");
    exit();
}
require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/Patient/includes/navbar.php';
$updateSuccess = $_SESSION['updateSuccess'] ?? "";
$updateError = $_SESSION['updateError'] ?? "";

$expireSql = "
    UPDATE dental_transaction
    SET med_cert_status = 'Expired', date_updated = NOW()
    WHERE med_cert_status NOT IN ('None')
        AND DATEDIFF(NOW(), date_created) >= 3
";
$conn->query($expireSql);
?>
<title>Profile</title>

<div class="profile-container">
    <div class="profile-section">
        <div class="profile-card" id="profileCard">
            <p>Loading profile</p>
        </div>
    
        <?php if (!empty($updateSuccess) || !empty($updateError)): ?>
            <div id="toastContainer">
                <?php if (!empty($updateSuccess)): ?>
                    <div class="toast success"><?= htmlspecialchars($updateSuccess) ?></div>
                    <?php unset($_SESSION['updateSuccess']); ?>
                <?php endif; ?>

                <?php if (!empty($updateError)): ?>
                    <div class="toast error"><?= htmlspecialchars($updateError) ?></div>
                    <?php unset($_SESSION['updateError']); ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="tabs-container">
        <div class="tabs">
            <div class="tab active" onclick="switchTab('appointment_history')">Appointment History</div>
            <div class="tab" onclick="switchTab('dental_transaction')">Dental Transactions</div>
        </div> 

        <div class="tab-content active" id="appointment_history">
            <table id="appointmentTable" class="transaction-table">
            </table>
        </div>

        <div class="tab-content" id="dental_transaction">
            <table id="transactionTable" class="transaction-table">
            </table>
        </div>
    </div>
</div>

<div id="editProfileModal" class="edit-profile-modal">
    <div class="edit-profile-modal-content">
        <form id="editProfileForm" method="POST" action="<?= BASE_URL ?>/Patient/processes/profile/update_profile.php" autocomplete="off">
            <div class="form-group phone-group">
                <input type="tel" id="contactNumber" class="form-control" name="contactNumber" oninput="this.value = this.value.replace(/[^0-9]/g, '')" pattern="[0-9]{10}" title="Mobile number must be 10 digits" required maxlength="10" />
                <label for="contactNumber" class="form-label">Mobile Number <span class="required">*</span></label>
                <span class="phone-prefix">+63</span>
            </div>

            <div class="form-group">
                <textarea id="address" class="form-control" name="address" rows="3" required placeholder=" "autocomplete="off"></textarea>
                <label for="address" class="form-label">Address <span class="required">*</span></label>
            </div>

            <div class="button-group">
                <button type="submit" class="form-button confirm-btn">Save Changes</button>
                <button type="button" class="form-button cancel-btn" onclick="closeEditProfileModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<div id="changePasswordModal" class="change-password-modal">
    <div class="change-password-modal-content">
        <form id="requestOtpForm" method="POST" action="<?= BASE_URL ?>/processes/OTP Processes/change_password/request_otp_change_password.php">
            <p style="text-align:center;">Click below to request an OTP for password change.</p>
            <div class="button-group">
                <button type="submit" class="form-button confirm-btn">Send OTP</button>
                <button type="button" class="form-button cancel-btn" onclick="closeChangePasswordModal()">Cancel</button>
            </div>
        </form> 
    </div>
</div>

<div id="changeEmailModal" class="change-password-modal">
    <div class="change-password-modal-content">
        <form id="requestOtpForm" method="POST" action="<?= BASE_URL ?>/processes/OTP Processes/change_email/request_otp_change_email.php">
            <p style="text-align:center;">Click below to request an OTP for email change.</p>
            <div class="button-group">
                <button type="submit" class="form-button confirm-btn">Send OTP</button>
                <button type="button" class="form-button cancel-btn" onclick="closeChangeEmailModal()">Cancel</button>
            </div>
        </form> 
    </div>
</div>

<div id="manageModal" class="manage-calendar-modal">
    <div class="manage-calendar-modal-content">
        <div id="modalBody" class="manage-calendar-modal-content-body">
            <!-- Appointment info will be loaded here -->
        </div>
    </div>
</div>

<div id="transactionModal" class="transaction-record-modal">
    <div class="transaction-record-modal-content">
        <div id="transactionModalBody">
            <!-- Transaction info will be loaded here -->
        </div>
    </div>
</div>

<div id="medCertModal" class="booking-modal" data-transaction-id="">
    <div class="booking-modal-content">
        <h2>Request Medical Certificate</h2>
        <p>Please scan the QR code below to pay for the medical certificate fee.</p>

        <div style="text-align: center; margin: 15px 0;">
        <img src="<?= BASE_URL ?>/images/qr/qr_payment.jpg" alt="Payment QR Code" style="width: 210px; height: 300px;">
        <p><strong>Amount:</strong> ₱150</p>
        </div>

        <form action="<?= BASE_URL ?>/Patient/processes/profile/upload_medcert_payment.php"
            method="POST"
            enctype="multipart/form-data"
            id="medCertForm">

        <input type="hidden" name="dental_transaction_id" id="transactionIdInput">

        <label for="paymentReceipt" style="font-weight: bold;">Upload Payment Screenshot:</label>
        <input type="file" id="paymentReceipt" name="payment_receipt" accept="image/*" required style="margin-top: 10px; width: 100%;">

        <div class="button-group">
            <button type="submit" class="confirm-btn">Submit</button>
            <button type="button" class="cancel-btn" id="cancelMedCertRequest">Cancel</button>
        </div>
        </form>
    </div>
</div>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>