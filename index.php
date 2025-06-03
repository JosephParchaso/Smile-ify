<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <title>Welcome!</title>
    <link rel="icon" href="images/Logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/index/style.css">
</head>
<body>

    <div class="main-container">
        <div class="motto-container">
            <p class="motto">Creating vibrant smile for healthy lifestyle!</p>
        </div>

        <div class="login-container">
            <img src="images/Logo.png" alt="Logo" class="logo" />
            <form>
                <div class="form-group">
                    <input type="text" id="userName" class="form-control" name="username" placeholder=" " required />
                    <label for="userName" class="form-label">Username</label>
                </div>

                <div class="form-group">
                    <input type="password" id="passWord" class="form-control" name="password" placeholder=" " required />
                    <label for="passWord" class="form-label">Password</label>
                    <span onclick="togglePassword()" style="position: absolute; top: 50%; right: 12px; transform: translateY(-50%); cursor: pointer; font-size: 14px;">👁</span>
                </div>

                <div style="text-align: right; margin-bottom: 10px;">
                    <a href="#" style="font-size: 14px; color: #2196f3; text-decoration: none;">Forgot password?</a>
                </div>

                <button type="submit" class="form-button">Sign In</button>
                <div class="divider"><span>or</span></div>
                <button type="submit" class="form-button">Book an Appointment</button>
            </form>
        </div>
    </div>

    <div class="tagline-container">
        <div class="column1" style="background-color: #e7c6ff">
            <img src="images/ExperiencedDentist.png" alt="Experienced Dentist">
            <h2>Experienced Dentist</h2>
            <p>With the team's expertise, your smile is in the best hands possible.</p>
        </div>
        <div class="column2" style="background-color: #c8b6ff">
            <img src="images/advanceTreament.png" alt="Advance Treatment">
            <h2>Advance Treatment</h2>
            <p>Backed by expertise and advanced technology, our team ensures your satisfaction.</p>
        </div>
        <div class="column3" style="background-color: #b8c0ff">
            <img src="images/guaranteedResults.png" alt="Guaranteed Results">
            <h2>Guaranteed Results</h2>
            <p>Skilled team and techniques ensure your smile transformation is delivered.</p>
        </div>
        <div class="column4" style="background-color: #bbd0ff">
            <img src="images/affordableRates.png" alt="Affordable Rates">
            <h2>Affordable Rates</h2>
            <p>Offers affordable rates and top-notch care, so you get the best of both worlds.</p>
        </div>
    </div>

    <script src="js/togglePassword.js"></script>
</body>
</html>
