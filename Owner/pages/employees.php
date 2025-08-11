<?php
session_start();

$currentPage = 'employees';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/Owner/includes/navbar.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    header("Location: " . BASE_URL . "/index.php");
    exit();
}
?>
<title>Employees</title>

<div class="tabs-container">
    <div class="tabs">
        <div class="tab active" onclick="switchTab('admin')">Admins</div>
        <div class="tab" onclick="switchTab('dentist')">Dentists</div>
    </div>

    <div class="tab-content active" id="admin">
        <table class="transaction-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Branch</th>
                    <th>Date Started</th>
                    <th>Status</th>
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

    <div class="tab-content" id="dentist">
        <table class="transaction-table">
        <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Branch</th>
                    <th>Service</th>
                    <th>Branch</th>
                    <th>Date Started</th>
                    <th>Status</th>
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

<?php require_once BASE_PATH . '/includes/footer.php'; ?>
