<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <title>Welcome!</title>
    <link rel="icon" href="images/logo/logo_white.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
    <script src="js/openBookingModal.js"></script>
    <script src="js/togglePassword.js"></script>
    <script src="js/openEducationalModal.js?v=1.1"></script>
</head>
<body>

<div class="main-container">
    <div class="motto-container">
        <p class="motto">Creating vibrant smile for healthy lifestyle!</p>
    </div>

    <div class="login-container">
        <img src="images/logo/logo_default.png" alt="Logo" class="logo" />
        <form action="pages/home.php" method="get">
            <div class="form-group">
                <input type="text" id="userName" class="form-control" placeholder=" " />
                <label for="userName" class="form-label">Username</label>
            </div>

            <div class="form-group">
                <input type="password" id="passWord" class="form-control" placeholder=" " />
                <label for="passWord" class="form-label">Password</label>
                <span onclick="togglePassword()" style="position: absolute; top: 50%; right: 12px; transform: translateY(-50%); cursor: pointer; font-size: 14px;">👁</span>
            </div>

            <div style="text-align: right; margin-bottom: 10px;">
                <a href="#" style="font-size: 14px; color: #2196f3; text-decoration: none;">Forgot password?</a>
            </div>

            <button type="submit" class="form-button">Sign In</button>
            <div class="divider"><span>or</span></div>
            <button type="button" class="form-button"  onclick="openBookingModal()">Book an Appointment</button>
        </form>
    </div>
</div>

    <div id="bookingModal" class="booking-modal">
        <div class="booking-modal-content">
            <form id="bookingForm">
            <span class="close-button" onclick="closeModal()">&times;</span>
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

                <div class="form-group phone-group">
                    <input type="tel" id="mobileNumber" class="form-control" name="mobileNumber" oninput="this.value = this.value.replace(/[^0-9]/g, '')" pattern="[0-9]{10}" title="Mobile number must be 10 digits" required />
                    <label for="mobileNumber" class="form-label">Mobile Number <span class="required">*</span></label>
                    <span class="phone-prefix">+63</span>
                </div>
                
                <div class="form-group">
                    <select id="gender" class="form-control" name="gender" required>
                        <option value="" disabled selected hidden></option>
                        <option value="female">Female</option>
                        <option value="male">Male</option>
                        <option value="other">Other</option>
                    </select>
                    <label for="gender" class="form-label">Gender <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <select id="service" class="form-control" name="service" required>
                        <option value="" disabled selected hidden></option>
                        <option value="consultation">Consultation</option>
                        <option value="cleaning">Cleaning</option>
                        <option value="whitening">Whitening</option>
                    </select>
                    <label for="service" class="form-label">Service <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="date" id="appointmentDate" class="form-control" name="appointmentDate" required />
                    <label for="appointmentDate" class="form-label">Date <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <select id="appointmentTime" name="appointmentTime" class="form-control" required>
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
                    <select id="branch" class="form-control" name="branch" required>
                        <option value="" disabled selected hidden></option>
                        <option value="downtown">Downtown</option>
                        <option value="uptown">Uptown</option>
                        <option value="suburb">Suburb</option>
                    </select>
                    <label for="branch" class="form-label">Branch <span class="required">*</span></label>
                </div>
                <button type="submit" class="form-button">Confirm</button>
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

<?php include 'includes/footer.php'; ?>
</body>
</html>

<script>
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    const minDate = `${yyyy}-${mm}-${dd}`;
    document.getElementById("appointmentDate").setAttribute("min", minDate);
</script>