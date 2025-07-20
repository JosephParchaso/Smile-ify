<?php 
session_start();
$baseUrl = $_SERVER['HTTP_HOST'] === 'localhost' ? '/Smile-ify' : '';

if (!isset($_SESSION['username'])) {
    header("Location: $baseUrl/index.php");
    exit;
}
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$currentPage = 'index';

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/header.php';
?>

<body>
    <title>Home</title>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/Patient/includes/navbar.php'; ?>

    <div class="dashboard">
        <div class="welcome">
            <h1>👋 Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p>You are logged in as <strong><?php echo htmlspecialchars($_SESSION['role']); ?></strong>.</p>
        </div>

        <div class="cards">
            <div class="card">
                <h2>📅 Upcoming Appointments</h2>
                <div class="appointment">
                    <strong>July 25, 2025</strong> at 10:00 AM<br>
                    with Dr. Smith (Mandaue Branch)
                </div>
                <div class="appointment">
                    <strong>August 5, 2025</strong> at 2:30 PM<br>
                    with Dr. Cruz (Babag Branch)
                </div>
            </div>

            <div class="card">
                <h2>📢 Announcements</h2>
                <div class="announcement">Get 10% off on Root Canal Treatment until August 31!</div>
                <div class="announcement">We’re closed on August 21 for National Holiday.</div>
            </div>

            <div class="card">
                <h2>🦷 Dental Care Tips</h2>
                <div class="tip">Brush at least twice a day with fluoride toothpaste.</div>
                <div class="tip">Floss daily to remove plaque between your teeth.</div>
                <div class="tip">Avoid sugary drinks and snacks between meals.</div>
            </div>

            <div class="card">
                <h2>⚡ Quick Links</h2>
                <div class="quick-links">
                    <a href="#" onclick="openBookingModal()"><span class="material-symbols-outlined">calendar_add_on</span> Book Appointment</a>
                    <a href="/Smile-ify/Patient/pages/profile.php"><span class="material-symbols-outlined">manage_accounts</span> Edit Profile</a>
                </div>
            </div>
        </div>
    </div>

    <div id="bookingModal" class="booking-modal">
        <div class="booking-modal-content" style="margin: 20vh auto;">
            
            <form action="" method="POST" id="bookingForm" autocomplete="off">
                <div class="form-group">
                    <select id="appointmentBranch" class="form-control" name="appointmentBranch" required>
                        <option value="" disabled selected hidden></option>
                        <?php

                        $sql = "SELECT branch_id, name FROM branch";
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
                        <select id="appointmentService" class="form-control" name="appointmentService" required>
                            <option value="" disabled selected hidden></option>
                            <!-- Options will be populated here via AJAX -->
                        </select>
                    <label for="appointmentService" class="form-label">Service <span class="required">*</span></label>
                    </div>
                    
                    <!-- <div class="button-wrapper">
                        <button type="button" class="add-service-btn">Add Another Service</button>
                    </div> -->
                </div>

                <div class="form-group">
                    <input type="date" id="appointmentDate" class="form-control" name="appointmentDate" required />
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
                    <select id="appointmentDentist" class="form-control" name="appointmentDentist" required>
                        <option value="" disabled selected hidden></option>
                    </select>
                    <label for="appointmentDentist" class="form-label">Dentist <span class="required">*</span></label>
                </div>

                <div class="button-group">
                    <button type="submit" class="form-button confirm-btn" id="confirmBooking">Confirm</button>
                    <button type="button" class="form-button cancel-btn" onclick="closeModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/footer.php'; ?>
</body>
