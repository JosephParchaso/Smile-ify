<?php

require_once __DIR__ . '/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (php_sapi_name() !== 'cli') {
    exit("Run this script in CLI only.\n");
}

$check = $conn->query("SELECT COUNT(*) AS c FROM users WHERE role='owner'");
$count = $check->fetch_assoc()['c'];

if ($count > 0) {
    exit("Owner already exists. Aborting.\n");
}

echo "=== Smile-ify Owner Setup (Simplified) ===\n\n";

function prompt($label, $required = true)
{
    do {
        echo "$label: ";
        $input = trim(fgets(STDIN));
        if ($required && $input === '') {
            echo "This field is required.\n";
        }
    } while ($required && $input === '');
    return $input;
}

function promptPassword($label)
{
    if (strncasecmp(PHP_OS, 'WIN', 3) === 0) {
        echo "$label: ";
        return trim(fgets(STDIN));
    } else {
        echo "$label: ";
        system('stty -echo');
        $password = trim(fgets(STDIN));
        system('stty echo');
        echo "\n";
        return $password;
    }
}

$username       = prompt("Enter username");
$contact_number = prompt("Enter contact number");
$first_name     = prompt("Enter first name");
$middle_name    = prompt("Enter middle name (optional)", false);
$last_name      = prompt("Enter last name");

do {
    $password = promptPassword("Enter password");
    $confirm  = promptPassword("Confirm password");
    if ($password !== $confirm) {
        echo "Passwords do not match. Try again.\n";
    }
} while ($password !== $confirm);

$email = prompt("Enter email");
while (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format. Try again.\n";
    $email = prompt("Enter email");
}

$middle_name = ($middle_name === '') ? NULL : $middle_name;

$role = 'owner';
$status = 'Active';
$date_started = date('Y-m-d');
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

list($cn_encrypted, $cn_iv, $cn_tag) = encryptField($contact_number);

$stmt = $conn->prepare("
    INSERT INTO users (
        username, password, first_name, middle_name, last_name, email,
        contact_number, contact_number_iv, contact_number_tag,
        role, status, date_started, date_created
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
");

if (!$stmt) {
    exit("Prepare failed: " . $conn->error . "\n");
}

$stmt->bind_param(
    "ssssssssssss",
    $username,
    $hashed_password,
    $first_name,
    $middle_name,
    $last_name,
    $email,
    $cn_encrypted,
    $cn_iv,
    $cn_tag,
    $role,
    $status,
    $date_started
);

if ($stmt->execute()) {
    echo "\nOwner account created successfully.\n";
    echo "Username: $username\n";
    echo "Email: $email\n";
} else {
    echo "Error inserting record: " . $stmt->error . "\n";
}

$stmt->close();
$conn->close();

echo "\nDelete this script after use for security.\n";
