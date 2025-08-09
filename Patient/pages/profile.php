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
?>
<title>Profile</title>

<div class="profile-container">
    <div class="profile-card" id="profileCard">
        <p>Loading profile...</p>
    </div>

    <div class="tabs-container">
        <div class="tabs">
            <div class="tab active" onclick="switchTab('appointment_history')">Appointment History</div>
            <div class="tab" onclick="switchTab('dental_transaction')">Dental Transactions</div>
        </div>

        <div class="tab-content active" id="appointment_history">
            <table class="transaction-table">
                <thead>
                    <tr>
                        <th>Dentist</th>
                        <th>Branch</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
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
