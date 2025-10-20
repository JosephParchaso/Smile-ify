<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

function encryptField($plaintext, $key) {
    if ($plaintext === null || $plaintext === '') return [null, null, null];

    $iv = random_bytes(12);
    $ciphertext = openssl_encrypt($plaintext, 'aes-256-gcm', $key, OPENSSL_RAW_DATA, $iv, $tag);
    return [
        base64_encode($ciphertext),
        base64_encode($iv),
        base64_encode($tag)
    ];
}

$ENCRYPTION_KEY = base64_decode(getenv('APP_ENC_KEY'));

// ---------- USERS ----------
$result = $conn->query("SELECT user_id, first_name, last_name, email, contact_number, address FROM users");
while ($row = $result->fetch_assoc()) {
    list($fn, $fn_iv, $fn_tag) = encryptField($row['first_name'], $ENCRYPTION_KEY);
    list($ln, $ln_iv, $ln_tag) = encryptField($row['last_name'], $ENCRYPTION_KEY);
    list($em, $em_iv, $em_tag) = encryptField($row['email'], $ENCRYPTION_KEY);
    list($cn, $cn_iv, $cn_tag) = encryptField($row['contact_number'], $ENCRYPTION_KEY);
    list($ad, $ad_iv, $ad_tag) = encryptField($row['address'], $ENCRYPTION_KEY);

    $stmt = $conn->prepare("
        UPDATE users SET
            first_name_enc=?, first_name_iv=?, first_name_tag=?,
            last_name_enc=?, last_name_iv=?, last_name_tag=?,
            email_enc=?, email_iv=?, email_tag=?,
            contact_number_enc=?, contact_number_iv=?, contact_number_tag=?,
            address_enc=?, address_iv=?, address_tag=?
        WHERE user_id=?;
    ");
    $stmt->bind_param(
        'sssssssssssssssi',
        $fn, $fn_iv, $fn_tag,
        $ln, $ln_iv, $ln_tag,
        $em, $em_iv, $em_tag,
        $cn, $cn_iv, $cn_tag,
        $ad, $ad_iv, $ad_tag,
        $row['user_id']
    );
    $stmt->execute();
}
echo "✅ Users encrypted successfully.<br>";

// ---------- DENTIST ----------
$result = $conn->query("SELECT dentist_id, first_name, middle_name, last_name, email, contact_number FROM dentist");
while ($row = $result->fetch_assoc()) {
    list($fn, $fn_iv, $fn_tag) = encryptField($row['first_name'], $ENCRYPTION_KEY);
    list($mn, $mn_iv, $mn_tag) = encryptField($row['middle_name'], $ENCRYPTION_KEY);
    list($ln, $ln_iv, $ln_tag) = encryptField($row['last_name'], $ENCRYPTION_KEY);
    list($em, $em_iv, $em_tag) = encryptField($row['email'], $ENCRYPTION_KEY);
    list($cn, $cn_iv, $cn_tag) = encryptField($row['contact_number'], $ENCRYPTION_KEY);

    $stmt = $conn->prepare("
        UPDATE dentist SET
            first_name_enc=?, first_name_iv=?, first_name_tag=?,
            middle_name_enc=?, middle_name_iv=?, middle_name_tag=?,
            last_name_enc=?, last_name_iv=?, last_name_tag=?,
            email_enc=?, email_iv=?, email_tag=?,
            contact_number_enc=?, contact_number_iv=?, contact_number_tag=?
        WHERE dentist_id=?;
    ");
    $stmt->bind_param(
        'sssssssssssssssi',
        $fn, $fn_iv, $fn_tag,
        $mn, $mn_iv, $mn_tag,
        $ln, $ln_iv, $ln_tag,
        $em, $em_iv, $em_tag,
        $cn, $cn_iv, $cn_tag,
        $row['dentist_id']
    );
    $stmt->execute();
}
echo "✅ Dentist encrypted successfully.<br>";
