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
$ENCRYPTION_KEY = hex2bin(APP_ENC_KEY);

// ===== AES-256-GCM ENCRYPTION / DECRYPTION =====
if (!function_exists('encryptField')) {
    function encryptField($plaintext)
    {
        global $ENCRYPTION_KEY;

        if ($plaintext === null || $plaintext === '') {
            return [null, null, null];
        }

        $iv = random_bytes(12);
        $tag = '';
        $ciphertext = openssl_encrypt(
            $plaintext,
            'aes-256-gcm',
            $ENCRYPTION_KEY,
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
    function decryptField($data, $iv, $tag)
    {
        global $ENCRYPTION_KEY;

        if (empty($data) || empty($iv) || empty($tag)) {
            return null;
        }

        return openssl_decrypt(
            base64_decode($data),
            'aes-256-gcm',
            $ENCRYPTION_KEY,
            OPENSSL_RAW_DATA,
            base64_decode($iv),
            base64_decode($tag)
        );
    }
}

// ===== SMTP CONFIG =====
define('SMTP_HOST', getenv('SMTP_HOST'));
define('SMTP_PORT', getenv('SMTP_PORT'));
define('SMTP_SECURE', getenv('SMTP_SECURE'));
define('SMTP_AUTH', filter_var(getenv('SMTP_AUTH'), FILTER_VALIDATE_BOOLEAN));
define('SMTP_USER', getenv('SMTP_USER'));
define('SMTP_PASS', getenv('SMTP_PASS'));

// ===== Default timezone =====
date_default_timezone_set('Asia/Manila');

// ===== Session setup (browser only) =====
if (php_sapi_name() !== 'cli' && session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ===== Token setup =====
if (php_sapi_name() !== 'cli' && !isset($_SESSION['tab_token'])) {
    $_SESSION['tab_token'] = bin2hex(random_bytes(16));
}

// ===== Define BASE_URL and BASE_PATH (corrected final version) =====
if (php_sapi_name() === 'cli') {

    // CLI mode: BASE_URL not needed, BASE_PATH auto-detected
    define('BASE_URL', '');
    define('BASE_PATH', realpath(__DIR__ . '/..'));

} else {

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

    // website is in the root (no subfolder)
    $basePath = '';

    define('BASE_URL', "$protocol://$host$basePath");

    // Correct physical path
    define('BASE_PATH', rtrim($_SERVER['DOCUMENT_ROOT'], '/') . $basePath);
}

// ===== Session timeout (browser only) =====
if (php_sapi_name() !== 'cli') {
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
}
?>
