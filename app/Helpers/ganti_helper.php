<?php

if (!function_exists('ganti')) {
    function ganti($inputString, $decr = "0")
    {
        $oriSet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789 ~`!@#$%^&*()-_+={}|\/?'<>,.";
        $encSet = "MkOq1u}Ucw\Bf3@FIN (PrnQjR8yTVvW%=XJC<0D$2t4i+5Kea6&pl9{ZsG~`!z#x^gEm*AS)-b_|H/L?7oYd'>h,.";

        $translationMap = [];
        if ($decr == "0") {
            for ($i = 0; $i < strlen($oriSet); $i++) {
                $translationMap[$oriSet[$i]] = $encSet[$i];
            }
        } else {
            for ($i = 0; $i < strlen($encSet); $i++) {
                $translationMap[$encSet[$i]] = $oriSet[$i];
            }
        }

        $hasil = strtr($inputString, $translationMap);
        return $hasil;
    }
}

if (!function_exists('buatToken')) {
    function buatToken()
    {
        $karakter = "ABCDEFGHJKLMNPRSTUWXY23456789";
        $hasil = substr(str_shuffle($karakter), 1, 10);
        return $hasil;
    }
}
