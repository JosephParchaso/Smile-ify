<?php
session_start();

$currentPage = 'patients';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    session_unset();
    session_destroy();
    header("Location: " . BASE_URL . "/index.php");
    exit();
}

require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/Admin/includes/navbar.php';

$appointmentId = $_GET['id'] ?? null;
if (!$appointmentId) {
    echo "<p>No appointment selected.</p>";
    require_once BASE_PATH . '/includes/footer.php';
    exit();
}
$updateSuccess = $_SESSION['updateSuccess'] ?? "";
$updateError   = $_SESSION['updateError'] ?? "";

$backTab = $_GET['tab'] ?? 'recent';
?>
<title>Appointment Details</title>

<div class="profile-container">
    <div class="profile-section">

        <div class="back-button-container">
            <a href="<?= BASE_URL ?>/Admin/pages/patients.php?tab=<?= htmlspecialchars($backTab) ?>" class="back-button-icon">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
        </div>
        
        <div class="profile-card" id="appointmentCard">
            <p>Loading profile...</p>
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

    <div id="recordVitalsModal" class="edit-profile-modal">
        <div class="edit-profile-modal-content">
            <form id="recordVitals" method="POST" action="<?= BASE_URL ?>/Admin/processes/manage_appointment/record_vitals.php" autocomplete="off">
                
                <div class="form-group">
                    <input type="number" step="0.1" id="bodyTemp" class="form-control" name="body_temp" required />
                    <label for="bodyTemp" class="form-label">Body Temperature (°C) <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="number" id="pulseRate" class="form-control" name="pulse_rate" required />
                    <label for="pulseRate" class="form-label">Pulse Rate (bpm) <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="number" id="respiratoryRate" class="form-control" name="respiratory_rate" required />
                    <label for="respiratoryRate" class="form-label">Respiratory Rate (breaths/min) <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="text" id="bloodPressure" class="form-control" name="blood_pressure" placeholder="e.g. 120/80" required />
                    <label for="bloodPressure" class="form-label">Blood Pressure <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="number" step="0.1" id="height" class="form-control" name="height" required />
                    <label for="height" class="form-label">Height (cm) <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="number" step="0.1" id="weight" class="form-control" name="weight" required />
                    <label for="weight" class="form-label">Weight (kg) <span class="required">*</span></label>
                </div>

                <div class="button-group">
                    <button type="submit" class="form-button confirm-btn">Save Vitals</button>
                    <button type="button" class="form-button cancel-btn" onclick="closeRecordVitalsModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div id="recordPrescriptionModal" class="edit-profile-modal">
        <div class="edit-profile-modal-content">
            <form id="recordPrescription" method="POST" action="<?= BASE_URL ?>/Admin/processes/manage_appointment/record_prescription.php" autocomplete="off">
                
                <div class="form-group">
                    <input type="text" id="drug" class="form-control" name="drug" required />
                    <label for="drug" class="form-label">Drug <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="text" id="route" class="form-control" name="route" required />
                    <label for="route" class="form-label">Route <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="text" id="frequency" class="form-control" name="frequency" required />
                    <label for="frequency" class="form-label">Frequency <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="text" id="dosage" class="form-control" name="dosage" required />
                    <label for="dosage" class="form-label">Dosage <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="text" id="duration" class="form-control" name="duration" required />
                    <label for="duration" class="form-label">Duration <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <textarea id="instructions" class="form-control" name="instructions" rows="3" required></textarea>
                    <label for="instructions" class="form-label">Instructions <span class="required">*</span></label>
                </div>

                <div class="button-group">
                    <button type="submit" class="form-button confirm-btn">Save Prescription</button>
                    <button type="button" class="form-button cancel-btn" onclick="closeRecordPrescriptionModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const appointmentId = "<?= htmlspecialchars($appointmentId) ?>";
</script>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>
