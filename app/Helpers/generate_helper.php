<?php

use Config\Encryption;

// Create token for new person 
if (!function_exists('createToken')) {
    function createToken()
    {
        $character = "ABCDEFGHJKLMNPRSTUWXY23456789";
        $result = substr(str_shuffle($character), 1, 10);
        return $result;
    }
}

//Function create unique for address bar
if (!function_exists('create_Unique')) {
    function create_Unique($length = 64)
    {
        $unique = bin2hex(random_bytes($length / 2));
        return $unique;
    }
}

// Function for hashing (SHA-256)
function hashData($value)
{
    return hash('sha256', $value);
}

// encrypt AES
if (!function_exists('encrypt')) {
    function encrypt($value)
    {
        $config = new \Config\Encryption();
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($config->cipher));
        $encrypted = openssl_encrypt($value, $config->cipher, $config->key, 0, $iv);
        return base64_encode("$encrypted::$iv");
    }
}

// decrypt AES
if (!function_exists('decrypt')) {
    function decrypt($value)
    {
        if (!$value) return '';

        $config = new \Config\Encryption();
        list($encrypted, $iv) = explode('::', base64_decode($value), 2);
        return $iv ? openssl_decrypt($encrypted, $config->cipher, $config->key, 0, $iv) : '';
    }
}

// substitution
if (!function_exists('encDec')) {
    function encDec($inputString, $model = "0")
    {
        $charSet1 = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789 ~`!@#$%^&*()-_+={}|\/?'<>,.";
        $charSet2 = "W%b6c=d/eTPfgh&ij7Yk!l_*n$5oJ9|XQp<q0 rSst{u'vGwU3@x>my-z1`AN~C}D4E)F(H#IBa2KL+M^O\RV?Z,8.";
        $translationMap = [];

        if ($model == "1") { // encrypt
            for ($i = 0; $i < strlen($charSet1); $i++) {
                $translationMap[$charSet1[$i]] = $charSet2[$i];
            }
        } else {
            for ($i = 0; $i < strlen($charSet2); $i++) {
                $translationMap[$charSet2[$i]] = $charSet1[$i];
            }
        }
        $result = strtr($inputString, $translationMap);
        return $result;
    }
}
