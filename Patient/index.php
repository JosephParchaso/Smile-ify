<?php 
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: " . BASE_URL . "/index.php");
    exit();
}

$currentPage = 'index';
$error_msg = '';

if (isset($_SESSION['error_msg'])) {
    $error_msg = $_SESSION['error_msg'];
    unset($_SESSION['error_msg']);
}

require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/Patient/includes/navbar.php';

?>

<body>
    <title>Home</title>

    <div class="dashboard">
        <div class="top-section">
            <div class="welcome">
                <h1>👋 Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</h1>
            </div>

            <div class="promos swiper promo-slider">
                <div class="swiper-wrapper" id="promoWrapper">
                    <!-- promos will be loaded here via JS -->
                </div>

                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>

        <div class="cards">
            <div class="card">
                <h2><span class="material-symbols-outlined">calendar_month</span> Upcoming Appointments</h2>
                <div id="patientUpcomingAppointments">
                    <div class="appointment">Loading...</div>
                </div>
            </div>

            <div class="card">
                <h2><span class="material-symbols-outlined">campaign</span> Announcements</h2>
                <div id="patientAnnouncements">
                    <div class="announcement">Loading ...</div>
                </div>
            </div>

            <div class="card">
                <h2><span class="material-symbols-outlined">dentistry</span> Dental Care Tips</h2>
                <div id="patientTips">
                    <div class="tip">Loading...</div>
                </div>
            </div>

            <div class="card">
                <h2><span class="material-symbols-outlined">bolt</span> Quick Links</h2>
                <div class="quick-links">
                    <a href="#" onclick="openBookingModal()"><span class="material-symbols-outlined">calendar_add_on</span> Book Appointment</a>
                    <a href="<?= BASE_URL ?>/Patient/pages/profile.php"><span class="material-symbols-outlined">manage_accounts</span> Profile Settings</a><br>
                    <a href="#" onclick="openEducationalModal()"><span class="material-symbols-outlined">info</span> About</a>
                </div>
            </div>
            <?php if (!empty($error_msg)): ?>
                <div class="error"><?php echo htmlspecialchars($error_msg); ?></div>
            <?php endif; ?>
        </div>
    </div>

    <div id="bookingModal" class="booking-modal">
        <div class="booking-modal-content">
            
            <form action="<?= BASE_URL ?>/Patient/processes/insert_appointment.php" method="POST" autocomplete="off">
                <div class="form-group">
                    <select id="appointmentBranch" class="form-control" name="appointmentBranch" required>
                        <option value="" disabled selected hidden></option>
                        <?php

                        $sql = "SELECT branch_id, name, status FROM branch WHERE status = 'Active' ";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["branch_id"] . "'>" . htmlspecialchars($row["name"]) . "</option>";
                            }
                        } else {
                            echo "<option disabled>No branches available</option>";
                        }
                        ?>
                    </select>
                    <label for="appointmentBranch" class="form-label">Branch <span class="required">*</span></label>
                </div>

            <div class="form-group">
                <div id="services-container">
                    <select id="appointmentService" class="form-control" name="appointmentService[]" multiple required>
                        <!-- Options will be populated via AJAX -->
                    </select>
                    <label for="appointmentService" class="form-label">Services <span class="required">*</span></label>
                    <small class="form-hint">Hold <b>Ctrl</b> (Windows) or <b>Cmd</b> (Mac) to select multiple</small>
                </div>
            </div>

                <div class="form-group">
                    <select id="appointmentDentist" class="form-control" name="appointmentDentist" required>
                        <option value="" disabled selected hidden></option>
                    </select>
                    <label for="appointmentDentist" class="form-label">Dentist <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="date" id="appointmentDate" name="appointmentDate" class="form-control" required />
                    <label for="appointmentDate" class="form-label">Date <span class="required">*</span></label>
                    <span id="dateError" class="error-msg-calendar error">
                        Sundays are not available for appointments. Please select another date.
                    </span>
                </div>

                <div class="form-group">
                    <select id="appointmentTime" class="form-control" name="appointmentTime" required>
                        <option value="" disabled selected hidden></option>
                        <option value="09:00">9:00 AM</option>
                        <option value="09:45">9:45 AM</option>
                        <option value="10:30">10:30 AM</option>
                        <option value="11:15">11:15 AM</option>
                        <option value="12:00">12:00 PM</option>
                        <option value="12:45">12:45 PM</option>
                        <option value="13:30">1:30 PM</option>
                        <option value="14:15">2:15 PM</option>
                        <option value="15:00">3:00 PM</option>
                    </select>
                    <label for="appointmentTime" class="form-label">Time <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <textarea id="notes" class="form-control" name="notes" rows="3" placeholder=" "autocomplete="off"></textarea>
                    <label for="notes" class="form-label">Add a note...</label>
                </div>

                <div class="button-group">
                    <button type="submit" class="form-button confirm-btn">Confirm</button>
                    <button type="button" class="form-button cancel-btn" onclick="closeBookingModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div id="promoModal" class="promo-modal">
        <div class="promo-modal-content">
            <img id="promoModalImg" src="" alt="Promo Image" class="modal-img">
            <div class="modal-details">
                <h3 id="promoTitle"></h3>
                <p id="promoDesc"></p>
                <p id="promoDate"></p>
            </div>
        </div>
    </div>

    <div id="educationalModal" class="educational-modal">
        <div class="educational-modal-content" id="educationalModalContent">
        </div>
    </div>

    <?php require_once BASE_PATH . '/includes/footer.php'; ?>

</body>
