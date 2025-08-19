<?php
session_start();

$currentPage = 'profile';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/Owner/includes/navbar.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
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

                <form id="editProfileForm" method="POST" action="<?= BASE_URL ?>/processes/Owner/update_profile.php" autocomplete="off">
                    
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
    </div>


<?php require_once BASE_PATH . '/includes/footer.php'; ?>
