<?php

// ===== Load .env file =====
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    $env = parse_ini_file($envPath);
    foreach ($env as $key => $value) {
        putenv("$key=$value");
    }
}

// ===== Encryption key setup =====
define('APP_ENC_KEY', getenv('APP_ENC_KEY'));
$ENCRYPTION_KEY = base64_decode(APP_ENC_KEY);

// ===== SMTP CONFIG =====
define('SMTP_HOST', getenv('SMTP_HOST') ?: 'smtp.gmail.com');
define('SMTP_PORT', getenv('SMTP_PORT') ?: 587);
define('SMTP_SECURE', getenv('SMTP_SECURE') ?: 'tls');
define('SMTP_AUTH', filter_var(getenv('SMTP_AUTH'), FILTER_VALIDATE_BOOLEAN));
define('SMTP_USER', getenv('SMTP_USER'));
define('SMTP_PASS', getenv('SMTP_PASS'));

// ===== AES-256-GCM ENCRYPTION/DECRYPTION FUNCTIONS =====
if (!function_exists('encryptField')) {
    function encryptField($plaintext, $key)
    {
        if ($plaintext === null || $plaintext === '') {
            return [null, null, null];
        }

        $iv = random_bytes(12); // 96-bit IV for GCM
        $tag = '';
        $ciphertext = openssl_encrypt(
            $plaintext,
            'aes-256-gcm',
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        return [
            base64_encode($ciphertext),
            base64_encode($iv),
            base64_encode($tag)
        ];
    }
}

if (!function_exists('decryptField')) {
    function decryptField($data, $iv, $tag, $key)
    {
        if (empty($data) || empty($iv) || empty($tag)) {
            return null;
        }

        return openssl_decrypt(
            base64_decode($data),
            'aes-256-gcm',
            $key,
            OPENSSL_RAW_DATA,
            base64_decode($iv),
            base64_decode($tag)
        );
    }
}

// ===== Default timezone =====
date_default_timezone_set('Asia/Manila');

// ===== Session setup =====
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ===== Token setup =====
if (!isset($_SESSION['tab_token'])) {
    $_SESSION['tab_token'] = bin2hex(random_bytes(16));
}

// ===== Define constants =====
$baseUrl = (strpos($_SERVER['REQUEST_URI'], '/Smile-ify') !== false || $_SERVER['HTTP_HOST'] === 'localhost') ? '/Smile-ify' : '';
define('BASE_URL', $baseUrl);
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . BASE_URL);

// ===== Session timeout =====
$timeout_duration = 1800;

if (isset($_SESSION['LAST_ACTIVITY']) &&
    (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {

    session_unset();
    session_destroy();

    session_start();
    $_SESSION['timeoutError'] = "Your session has expired due to inactivity. Please log in again.";

    header("Location: " . BASE_URL . "/index.php");
    exit();
}

$_SESSION['LAST_ACTIVITY'] = time();
