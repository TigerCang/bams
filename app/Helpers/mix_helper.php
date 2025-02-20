<?php

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Security\Exceptions\SecurityException;

if (!function_exists('json')) {
    function json($key)
    {
        // Load the content of data.json file
        $jsonFile = APPPATH . 'Language/variable.json';
        $jsonData = file_get_contents($jsonFile);
        $data = json_decode($jsonData, true);
        return $data[$key] ?? '';
    }
}

// Setting format for value on view
if (!function_exists('formatComa')) {
    function formatComa($value, $count = 2)
    {
        $value = number_format($value, $count, ',', '.');
        return $value;
    }
}

// Setting format for date on view
if (!function_exists('formatDate')) {
    function formatDate($value, $model = 1)
    {
        if ($model == '1')
            $date = date('d/m/Y', strtotime($value));
        else if ($model == '2')
            $date = date('d/m/Y H:i:s', strtotime($value));
        else if ($model == '3')
            $date = date('d/m', strtotime($value));
        else if ($model == '4')
            $date = date('j F Y', strtotime($value));
        else if ($model == '5')
            $date = date('d/m/Y H:i', strtotime($value));
        return $date;
    }
}

// Change 20.500,12 be 20500.12 before save db
if (!function_exists('changeSeparator')) {
    function changeSeparator($value, $sign = 'coma')
    {
        if ($sign == 'coma')
            $separator = str_replace(array('.', ','), array('', '.'), $value);
        elseif ($sign == 'dot')
            $separator = str_replace('.', ',', $value);
        return $separator;
    }
}

// roman typeface 
if (!function_exists('romanLetter')) {
    function romanLetter($value)
    {
        $array_value = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $character = $array_value[$value];
        return $character;
    }
}

// Memundurkan tanggal untuk filter between
if (!function_exists('tanggalMundur')) {
    function tanggalMundur($number, $jumlah = 1, $format = 'months')
    {
        $tglnow = $number;
        $temp = date('Y-m-d', strtotime($jumlah . ' ' . $format, strtotime($tglnow)));
        return date('Y-m-d', strtotime('1' . ' ' . 'days', strtotime($temp)));
    }
}

// Function create document number AGG/SMS/SMB.KST/XI-230001
if (!function_exists('createDocumentNumber')) {
    function createDocumentNumber($start, $date, $number)
    {
        $thn = date('y', strtotime($date));
        $bln = date('n', strtotime($date));
        $number = sprintf("%04d", $number);
        $documentNumber = $start . romanLetter($bln) . "-" . $thn . $number;
        return $documentNumber;
    }
}

// Function Split data
if (!function_exists('splitData')) {
    function splitData($data, $separator)
    {
        return explode($separator, $data);
    }
}

// Fungsi level
if (!function_exists('statLev')) {
    function statLev($sama, $levuser, $levsetuju)
    {
        $slLevel = $levuser . ';' . $levuser . ';' . ($levuser == '0' ? $levsetuju : $levuser - 1);
        $slStatus = $sama . ($sama == '0' ? 'c' : '1');
        return [$slLevel, $slStatus];
    }
}

//Function status
if (!function_exists('labelBadge')) {
    function labelBadge($source, $number)
    {
        if ($source == 'colorTR') {
            $statLabel = [
                '1' => ['class' => 'backgroundTR1'],
                '2' => ['class' => 'backgroundTR2'],
                '3' => ['class' => 'backgroundTR3']
            ];
        } elseif ($source == 'token') {
            $statLabel = [
                '0' => ['class' => 'badge rounded-pill bg-label-success', 'text' => lang('app.new')],
                '1' => ['class' => 'badge rounded-pill bg-label-primary', 'text' => lang('app.used')],
            ];
        } elseif ($source == 'main') {
            $number = ($number[2] == '0' ? '0' : ($number[1] == '1' ? '1' : ($number[1] == '2' ? '2' : '3')));
            $statLabel = [
                '0' => ['class' => 'badge rounded-pill bg-label-dark', 'text' => lang('app.inactive')],
                '1' => ['class' => 'badge rounded-pill bg-label-primary', 'text' => lang('app.confirm')],
                '2' => ['class' => 'badge rounded-pill bg-label-info', 'text' => lang('app.new')],
                '3' => ['class' => 'badge rounded-pill bg-label-warning', 'text' => lang('app.pending')],
            ];
            // elseif ($source == 'barangpo') {
            //     $statLabel = [
            // '0' => ['class' => 'label-inverse-info-border', 'text' => lang('app.baru')],
            // '1' => ['class' => 'label-warning', 'text' => lang('app.tunda')],
            // '2' => ['class' => 'label-info', 'text' => lang('app.proses')],
            // '3' => ['class' => 'label-inverse-danger', 'text' => lang('app.revisi')],
            // '4' => ['class' => 'label-inverse', 'text' => lang('app.tolak')],
            // '5' => ['class' => 'label-inverse', 'text' => lang('app.batal')],
            // '6' => ['class' => 'label-inverse-warning', 'text' => lang('app.gudang')],
            // '7' => ['class' => 'label-success', 'text' => lang('app.mintaok')],
            // '8' => ['class' => 'label-success', 'text' => lang('app.pembelian')],
            // // '9' => ['class' => 'label-primary', 'text' => lang('app.selesai')],
            // 'c' => ['class' => 'label-inverse-info-border', 'text' => lang('app.blmacc')]
            // ];
        } elseif ($source == 'cash') {
            $statLabel = [
                '0' => ['text' => lang('app.new')],
                '1' => ['text' => lang('app.pending')],
                '2' => ['text' => lang('app.need acc')],
                '3' => ['text' => lang('app.process')],
                '4' => ['text' => lang('app.revision')],
                '5' => ['text' => lang('app.reject')],
                '6' => ['text' => lang('app.cancel')],
                '7' => ['text' => lang('app.ok')],
                '8' => ['text' => lang('app.pay')]
            ];
        }
        $labelStatus = $statLabel[$number] ?? ['class' => '', 'text' => ''];
        return $labelStatus;
    }
}

//Function number to letter
if (!function_exists('labelLetter')) {
    function labelLetter($number)
    {
        $number = abs($number);
        $letter = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($number < 12)
            $temp = " " . $letter[$number];
        else if ($number < 20)
            $temp = labelLetter($number - 10) . " belas";
        else if ($number < 100)
            $temp = labelLetter($number / 10) . " puluh" . labelLetter($number % 10);
        else if ($number < 200)
            $temp = " seratus" . labelLetter($number - 100);
        else if ($number < 1000)
            $temp = labelLetter($number / 100) . " ratus" . labelLetter($number % 100);
        else if ($number < 2000)
            $temp = " seribu" . labelLetter($number - 1000);
        else if ($number < 1000000)
            $temp = labelLetter($number / 1000) . " ribu" . labelLetter($number % 1000);
        else if ($number < 1000000000)
            $temp = labelLetter($number / 1000000) . " juta" . labelLetter($number % 1000000);
        else if ($number < 1000000000000)
            $temp = labelLetter($number / 1000000000) . " milyar" . labelLetter(fmod($number, 1000000000));
        else if ($number < 1000000000000000)
            $temp = labelLetter($number / 1000000000000) . " trilyun" . labelLetter(fmod($number, 1000000000000));
        return $temp;
    }
}

if (!function_exists('optionCondition')) {
    function optionCondition($action)
    {
        $isAccZero = thisUser()['act_approve'] == '0';
        $isCheckOption = $action == 'check';
        return ($isAccZero && !$isCheckOption) || (!$isAccZero && $isCheckOption) ? 'disabled' : '';
    }
}

if (!function_exists('splitUser')) {
    function splitUser($field, $data)
    {
        return explode(',', $data[$field]);
    }
}

if (!function_exists('getIP')) {
    function getIP()
    {
        $ipAddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipAddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipAddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipAddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipAddress = 'UNKNOWN';
        return $ipAddress;
    }
}
