<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/includes/db.php';

$loginSuccess = '';
$loginError = '';
$otpError = '';
$usernameError = '';
$showForgotPasswordModal = false;
if (isset($_SESSION['show_forgot_modal'])) {
    $showForgotPasswordModal = true;
    unset($_SESSION['show_forgot_modal']);
}

if (isset($_SESSION['login_success'])) {
    $loginSuccess = $_SESSION['login_success'];
    unset($_SESSION['login_success']);
}
if (isset($_SESSION['login_error'])) {
    $loginError = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}

if (isset($_SESSION['otp_error'])) {
    $otpError = $_SESSION['otp_error'];
    unset($_SESSION['otp_error']);
}

if (isset($_SESSION['username_error'])) {
    $usernameError = $_SESSION['username_error'];
    unset($_SESSION['username_error']);
}
if (isset($_GET['timeout'])) {
    $timeoutError = "Your session has expired due to inactivity. Please log in again.";
}
?>
<head>    
    <title>Welcome!</title>
</head>
<body>

<div class="main-container">
    <div class="motto-container">
        <p class="motto">Creating vibrant smile for healthy lifestyle!</p>
    </div>

    <div class="login-container">
        <img src="images/logo/logo_default.png" alt="Logo" class="logo" />
        
        <?php if (!empty($loginSuccess)): ?>
            <div class="success"><?php echo htmlspecialchars($loginSuccess); ?></div>
        <?php endif; ?>

        <?php if (!empty($loginError)): ?>
            <div class="error"><?php echo htmlspecialchars($loginError); ?></div>
        <?php endif; ?>

        <?php if (!empty($otpError)): ?>
            <div class="error"><?php echo htmlspecialchars($otpError); ?></div>
        <?php endif; ?>

    <?php if (!empty($_SESSION['timeoutError'])): ?>
        <div class="error"><?php echo htmlspecialchars($_SESSION['timeoutError']); ?></div>
        <?php unset($_SESSION['timeoutError']); ?>
    <?php endif; ?>

        <form action="<?= BASE_URL ?>/processes/login.php" method="POST" autocomplete="off">
            <div class="form-group">
                <input type="text" id="userName" name="userName" class="form-control" placeholder=" " required autocomplete="off"/>
                <label for="userName" class="form-label">Username</label>
            </div>

            <div class="form-group">
                <input type="password" id="passWord" name="passWord" class="form-control" placeholder=" " required/>
                <label for="passWord" class="form-label">Password</label>
                <span onclick="togglePassword('passWord')" style="position: absolute; top: 50%; right: 12px; transform: translateY(-50%); cursor: pointer; font-size: 14px;">👁</span>
            </div>

            <div style="text-align: right; margin-bottom: 10px;">
                <button type="button" class="forgot-password-link" onclick="openForgotPasswordModal()">
                    Forgot password?
                </button>
            </div>

            <button type="submit" class="form-button">Sign In</button>
            <div class="divider"><span>or</span></div>
            <button type="button" class="form-button"  onclick="openBookingModal()">Book an Appointment</button>
        </form>
    </div>
</div>

<div id="bookingModal" class="booking-modal">
    <div class="booking-modal-content">
        
        <form action="<?= BASE_URL ?>/processes/OTP Processes/request_otp.php" method="POST" autocomplete="off">
            <div class="form-group">
                <input type="text" id="lastName" class="form-control" name="lastName" placeholder=" " required />
                <label for="lastName" class="form-label">Last Name <span class="required">*</span></label>
            </div>

            <div class="form-group">
                <input type="text" id="firstName" class="form-control" name="firstName" placeholder=" " required />
                <label for="firstName" class="form-label">First Name <span class="required">*</span></label>
            </div>

            <div class="form-group">
                <input type="text" id="middleName" class="form-control" name="middleName" placeholder=" " />
                <label for="middleName" class="form-label">Middle Name</label>
            </div>

            <div class="form-group">
                <input type="email" id="email" class="form-control" name="email" placeholder=" " required autocomplete="off"/>
                <label for="email" class="form-label">Email Address <span class="required">*</span></label>
            </div>
            
            <div class="form-group">
                <select id="gender" class="form-control" name="gender" required>
                    <option value="" disabled selected hidden></option>
                    <option value="female">Female</option>
                    <option value="male">Male</option>
                </select>
                <label for="gender" class="form-label">Gender <span class="required">*</span></label>
            </div>

            <div class="form-group phone-group">
                <input type="tel" id="contactNumber" class="form-control" name="contactNumber" oninput="this.value = this.value.replace(/[^0-9]/g, '')" pattern="[0-9]{10}" title="Mobile number must be 10 digits" required maxlength="10" />
                <label for="contactNumber" class="form-label">Mobile Number <span class="required">*</span></label>
                <span class="phone-prefix">+63</span>
            </div>

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

            <div class="form-group">
                <textarea id="notes" class="form-control" name="notes" rows="3" required placeholder=" "autocomplete="off"></textarea>
                <label for="notes" class="form-label">Add a note...</label>
            </div>

            <div class="button-group">
                <button type="submit" class="form-button confirm-btn">Confirm</button>
                <button type="button" class="form-button cancel-btn" onclick="closeBookingModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<div id="forgotpasswordModal" class="forgot-password-modal">
    <div class="forgot-password-modal-content">
        <?php if (!empty($usernameError)): ?>
            <div class="error"><?php echo htmlspecialchars($usernameError); ?></div>
        <?php endif; ?>
        <form action="<?= BASE_URL ?>/processes/OTP Processes/request_otp_forgot_password.php" method="POST">
            <div class="form-group">
                <input type="text" id="username" class="form-control" name="username" placeholder=" " required autocomplete="off"/>
                <label for="username" class="form-label">Enter Username <span class="required">*</span></label>
            </div>

            <div class="button-group">
                <button type="submit" class="form-button confirm-btn">Confirm</button>
                <button type="button" class="form-button cancel-btn" onclick="closeForgotPasswordModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<div class="tagline-container">
    <div class="column1" style="background-color: #e7c6ff">
        <img src="images/icons/experienced_dentist.png" alt="Experienced Dentist">
        <h2>Experienced Dentist</h2>
        <p>With the team's expertise, your smile is in the best hands possible.</p>
    </div>
    <div class="column2" style="background-color: #c8b6ff">
        <img src="images/icons/advance_treament.png" alt="Advance Treatment">
        <h2>Advance Treatment</h2>
        <p>Backed by expertise and advanced technology, our team ensures your satisfaction.</p>
    </div>
    <div class="column3" style="background-color: #b8c0ff">
        <img src="images/icons/guaranteed_results.png" alt="Guaranteed Results">
        <h2>Guaranteed Results</h2>
        <p>Skilled team and techniques ensure your smile transformation is delivered.</p>
    </div>
    <div class="column4" style="background-color: #bbd0ff">
        <img src="images/icons/affordable_rates.png" alt="Affordable Rates">
        <h2>Affordable Rates</h2>
        <p>Offers affordable rates and top-notch care, so you get the best of both worlds.</p>
    </div>
</div>

<div class="welcome-container">
    <div class="welcome-text">We are open and welcoming, Patients!</div>
</div>

<p class="description">
    Make the best choice for your dental health – choose us.
</p>

<div class="service-container">
    <div class="grid">
        <div class="image-column">
            <img src="images/services/checkup.jpg" alt="Check Up and Cleaning">
            <p>Check Up and Cleaning</p>
        </div>
        <div class="image-column">
            <img src="images/services/root_canal.jpg" alt="Root Canal">
            <p>Root Canal</p>
        </div>
        <div class="image-column">
            <img src="images/services/crown.jpg" alt="Crown">
            <p>Crown</p>
        </div>
        <div class="image-column">
            <img src="images/services/veneers.jpg" alt="Veneers">
            <p>Veneers</p>
        </div>
        <div class="image-column">
            <img src="images/services/index_brace.jpg" alt="Braces">
            <p>Braces</p>
        </div>
        <div class="image-column">
            <img src="images/services/denture.jpg" alt="Dentures and Porcelain">
            <p>Dentures and Porcelain</p>
        </div>
    </div>
</div>

<div class="aboutus-wrapper">
    <div class="aboutus-info">
        <p class="aboutus-heading">About Us</p>
            <p class="aboutus-paragraph">
                Arriesgado Dental Clinic is a busy dental practice that serves a large patient population in Cebu City, Philippines. We have three (3) branches located in Babag Lapu-Lapu City, Pusok Lapu-Lapu City and Mandaue City. We offer a wide range of dental services, including general dentistry and orthodontics. <br><br>
                Our commitment to quality means that we use only the best materials and techniques to ensure that our services meet your expectations and exceed them. <br><br>
                Our convenient location means that you won't have to travel far to take advantage of our services, making it easy for you to fit us into your busy schedule. <br><br>
                So whether you're looking for a regular dental check up or a complete dental rehabilitation, we've got you covered.
            </p>
        <div class="educational-container">
            <button onclick="openEducationalModal()" class="educational-button" id="openEducationalModal">Learn More</button>
        </div>
    </div>

    <div class="branch-list">
        <div class="branch-column">
            <img src="images/logo/mandaue.png">
            <a href="https://www.google.com/maps?s=web&..." onclick="window.open(this.href,'_blank');return false;">
            <h2>Mandaue</h2>
            </a>
            <p>8XW6+G37, 42 Zone Ube, Mandaue City, 6014 Cebu</p>
        </div>

        <div class="branch-column">
            <img src="images/logo/babag.png">
            <a href="https://www.google.com/maps/dir//7WHV..." onclick="window.open(this.href,'_blank');return false;">
            <h2>Babag</h2>
            </a>
            <p>7WHV+RP3, Babang II Rd, Lapu-Lapu City, 6015 Cebu</p>
        </div>

        <div class="branch-column">
            <img src="images/logo/branch_default.jpg">
            <a href="https://www.google.com/maps/dir//Mondejar..." onclick="window.open(this.href,'_blank');return false;">
            <h2>Pusok</h2>
            </a>
            <p>Room 306, Mondejar Bldg., Pusok, Lapu-Lapu City, Cebu</p>
        </div>
    </div>
</div>

<div id="educationalModal" class="educational-modal">
    <div class="educational-modal-content" id="educationalModalContent">
    </div>
</div>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>
</body>
</html>

<script>
document.addEventListener('DOMContentLoaded', function () {
    <?php if ($showForgotPasswordModal): ?>
        openForgotPasswordModal();
    <?php endif; ?>
    });
</script>