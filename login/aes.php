<?php
// aes.php

function encryptData($data, $key) {
    $cipher = 'AES-128-CBC';
    $ivlen = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($ivlen);
    $encrypted = openssl_encrypt($data, $cipher, $key, $options=0, $iv);
    return base64_encode($iv . $encrypted);
}

function decryptData($encrypted_data, $key) {
    $cipher = 'AES-128-CBC';
    $ivlen = openssl_cipher_iv_length($cipher);
    $encrypted_data = base64_decode($encrypted_data);
    $iv = substr($encrypted_data, 0, $ivlen);
    $encrypted = substr($encrypted_data, $ivlen);
    return openssl_decrypt($encrypted, $cipher, $key, $options=0, $iv);
}
?>