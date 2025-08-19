<?php
session_start();

$currentPage = 'profile';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/Patient/includes/navbar.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: " . BASE_URL . "/index.php");
    exit();
}
$updateSuccess = $_SESSION['updateSuccess'] ?? "";
$updateError = $_SESSION['updateError'] ?? "";
?>
<title>Profile</title>

<div class="profile-container">
    <div class="profile-section">
    <div class="profile-card" id="profileCard">
        <p>Loading profile...</p>
    </div>
    
    <?php if (!empty($updateSuccess) || !empty($updateError)): ?>
        <div class="message-box">
            <?php if (!empty($updateSuccess)): ?>
                <div class="alert success" id="alertMessage"><?= htmlspecialchars($updateSuccess) ?></div>
                <?php unset($_SESSION['updateSuccess']); ?>
            <?php endif; ?>

            <?php if (!empty($updateError)): ?>
                <div class="alert error" id="alertMessage"><?= htmlspecialchars($updateError) ?></div>
                <?php unset($_SESSION['updateError']); ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    </div>

    <div id="editProfileModal" class="booking-modal">
        <div class="booking-modal-content">

            <form id="editProfileForm" method="POST" action="<?= BASE_URL ?>/processes/Patient/update_profile.php" autocomplete="off">
                
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

    <div class="tabs-container">
    <div class="tabs-header">
        <div class="tabs">
            <div class="tab active" onclick="switchTab('appointment_history')">Appointment History</div>
            <div class="tab" onclick="switchTab('dental_transaction')">Dental Transactions</div>
        </div>
    </div>  

        <div class="tab-content active" id="appointment_history">
            <table id="appointmentTable" class="transaction-table">
                
                <thead>
                    <tr>
                        <th>Dentist</th>
                        <th>Branch</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be loaded via AJAX -->
                </tbody>
            </table>
        </div>

        <div class="tab-content" id="dental_transaction">
            <table class="transaction-table">
            <thead>
                    <tr>
                        <th>Dentist</th>
                        <th>Branch</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>