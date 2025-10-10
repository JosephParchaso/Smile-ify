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

<div id="manageModal" class="manage-appointment-modal">
    <div class="manage-appointment-modal-content">
        <div id="modalBody" class="manage-appointment-modal-content-body">
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

<?php require_once BASE_PATH . '/includes/footer.php'; ?>