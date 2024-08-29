<?php

if (!function_exists('json')) {
    function json($key)
    {
        // Load the content of data.json file
        $jsonFile = APPPATH . 'Language/variabel.json';
        $jsonData = file_get_contents($jsonFile);
        $data = json_decode($jsonData, true);
        return $data[$key] ?? '';
    }
}
