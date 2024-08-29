<?php

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Security\Exceptions\SecurityException;
use App\Libraries\Menu;

// Pengecekan buka halaman dan izin akses
if (!function_exists('checkPage')) {
    function checkPage($nomor, $db = '', $createread = 'n', $detil = 'y')
    // nomor = role, db = ada . tidak datanya, createread = akses create dan read, detil = akses perusahaan wilayah divisi 
    {
        $menu = Menu::getMenu();
        $user = Menu::getUser();
        $queryString = $_SERVER['QUERY_STRING']; // Mengambil query string dari URL
        parse_str($queryString, $queryParams); // Memecah query string menjadi array
        $queryKeys = array_keys($queryParams); // Menyimpan nama parameter dalam array

        // (!preg_match("/$nomor/i", $menu['menu_1'])) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        if ($queryKeys && $queryKeys[0] !== 'datakey') throw PageNotFoundException::forPageNotFound();
        if (empty($queryParams['datakey'])) {
            if ($createread == 'y') if ($user['act_button'][0] == '0') throw SecurityException::forDisallowedAction();
        } else {
            if (empty($db)) throw PageNotFoundException::forPageNotFound();
            // if (empty($db) && (strlen($queryParams['datakey']) != '120')) throw PageNotFoundException::forPageNotFound();
            if ($createread == 'y') if ($user['act_button'][1] == '0') throw SecurityException::forDisallowedAction();
            // if ($user['act_akses'][0] == "0" && !preg_match("/," . $data['gudang'][0]->perusahaan_id . ",/i", $this->user['perusahaan'])) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        }
    }
}

// Setting Button untuk main data
if (!function_exists('setButton')) {
    function setButton($db1)
    {
        $user = Menu::getUser();
        $buttons = [];
        $queryString = $_SERVER['QUERY_STRING']; // Mengambil query string dari URL
        parse_str($queryString, $queryParams); // Memecah query string menjadi array
        // $queryKeys = array_keys($queryParams); // Menyimpan nama parameter dalam array

        if (empty($queryParams['datakey'])) {
            $buttons['bsave'] = '';
            $buttons['bconf'] = $buttons['bdel'] = $buttons['baktif'] = 'disabled';
        } else {
            $buttons['bsave'] = ($user['act_button'][2] == '0' ? 'disabled' : '');
            $buttons['bconf'] = (($user['act_button'][4] == '0' || $db1[0]->kondisi[1] == '1' || $db1[0]->save_by == $user['id']) ? 'disabled' : '');
            $buttons['bdel'] = ($user['act_button'][3] == '0' ? 'disabled' : '');
            $buttons['baktif'] = ($user['act_button'][5] == '0' ? 'disabled' : '');
        }
        return $buttons;
    }
}

// Setting format untuk nilai pada view
if (!function_exists('formatKoma')) {
    function formatKoma($angka, $jumlah = 2)
    {
        $angka = number_format($angka, $jumlah, ',', '.');
        return $angka;
    }
}

// Setting format untuk tanggal pada view
if (!function_exists('formatTanggal')) {
    function formatTanggal($angka, $model = 1)
    {
        if ($model == '1')
            $tanggal = date('d/m/Y', strtotime($angka));
        else if ($model == '2')
            $tanggal = date('d/m/Y H:i:s', strtotime($angka));
        else if ($model == '3')
            $tanggal = date('d/m', strtotime($angka));
        else if ($model == '4')
            $tanggal = date('j F Y', strtotime($angka));
        else if ($model == '5')
            $tanggal = date('d/m/Y H:i', strtotime($angka));
        return $tanggal;
    }
}

// Mengganti 20.500,12 jadi 20500.12 sebelum disimpan db
if (!function_exists('ubahSeparator')) {
    function ubahSeparator($angka, $tanda = 'koma')
    {
        if ($tanda == 'koma')
            $separator = str_replace(array('.', ','), array('', '.'), $angka);
        elseif ($tanda == 'titik')
            $separator = str_replace('.', ',', $angka);
        return $separator;
    }
}

// Mencetak angka romawi 
if (!function_exists('hurufRomawi')) {
    function hurufRomawi($angka)
    {
        $array_angka = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $huruf = $array_angka[$angka];
        return $huruf;
    }
}

// Memundurkan tanggal untuk filter between
if (!function_exists('tanggalMundur')) {
    function tanggalMundur($angka, $jumlah = 1, $format = 'months')
    {
        $tglnow = $angka;
        $temp = date('Y-m-d', strtotime($jumlah . ' ' . $format, strtotime($tglnow)));
        return date('Y-m-d', strtotime('1' . ' ' . 'days', strtotime($temp)));
    }
}

// Fungsi nodokumen AGG/SMS/SMB.KST/XI-230001
if (!function_exists('nomorDokumen')) {
    function nomorDokumen($awal, $tanggal, $nomor)
    {
        $thn = date('y', strtotime($tanggal));
        $bln = date('n', strtotime($tanggal));
        $nomor = sprintf("%04d", $nomor);
        $nodoc = $awal . hurufRomawi($bln) . "-" . $thn . $nomor;
        return $nodoc;
    }
}

//Fungsi membuat idunik pengganti slug
if (!function_exists('buatID')) {
    function buatID($length = 64)
    {
        $idunik = bin2hex(random_bytes($length / 2));
        return $idunik;
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

//Fungsi cetak status
if (!function_exists('labelBadge')) {
    function labelBadge($asal, $nomor)
    {
        if ($asal == 'barangpo')
            $statlabel = [
                '0' => ['class' => 'label-inverse-info-border', 'text' => lang('app.baru')],
                '1' => ['class' => 'label-warning', 'text' => lang('app.tunda')],
                '2' => ['class' => 'label-info', 'text' => lang('app.proses')],
                '3' => ['class' => 'label-inverse-danger', 'text' => lang('app.revisi')],
                '4' => ['class' => 'label-inverse', 'text' => lang('app.tolak')],
                '5' => ['class' => 'label-inverse', 'text' => lang('app.batal')],
                '6' => ['class' => 'label-inverse-warning', 'text' => lang('app.gudang')],
                '7' => ['class' => 'label-success', 'text' => lang('app.mintaok')],
                '8' => ['class' => 'label-success', 'text' => lang('app.pembelian')],
                // '9' => ['class' => 'label-primary', 'text' => lang('app.selesai')],
                'c' => ['class' => 'label-inverse-info-border', 'text' => lang('app.blmacc')]
            ];
        // else if ($asal == 'token')
        // if ($nomor == '0') { //jika belum digunakan
        //     $labelStatus = ['class' => 'badge rounded-pill bg-label-info', 'text' => lang('app.baru')];
        // } else {
        //     $labelStatus = ['class' => 'badge rounded-pill bg-label-dark', 'text' => lang('app.sudah pakai')];
        // }
        else if ($asal == 'main')
            $nomor = ($nomor[2] == '0' ? 'k' : ($nomor[1] == '1' ? 'l' : ($nomor[1] == 'a' ? 'm' : 'n')));
            $statlabel = [
                'k' => ['class' => 'badge rounded-pill bg-label-dark', 'text' => lang('app.inaktif')],
                'l' => ['class' => 'badge rounded-pill bg-label-primary', 'text' => lang('app.confirm')],
                'm' => ['class' => 'badge rounded-pill bg-label-info', 'text' => lang('app.baru')],
                'n' => ['class' => 'badge rounded-pill bg-label-warning', 'text' => lang('app.tunda')],
            ];

        // if ($nomor[2] == '0') { //jika inactive
        //     $labelStatus = ['class' => 'badge rounded-pill bg-label-dark', 'text' => lang('app.inaktif')];
        // } else if ($nomor[1] == '1') { //jika sudah diconfirm
        //     $labelStatus = ['class' => 'badge rounded-pill bg-label-primary', 'text' => lang('app.confirm')];
        // } else if ($nomor[1] == 'a') { //jika brlum disimpan
        //     $labelStatus = ['class' => 'badge rounded-pill bg-label-info', 'text' => lang('app.baru')];
        // } else {
        //     $labelStatus = ['class' => 'badge rounded-pill bg-label-warning', 'text' => lang('app.tunda')];
        // }

        // else if ($asal == 'warnaang')
        //     $statlabel = [
        //         '1' => ['class' => 'bgtr1'],
        //         '2' => ['class' => 'bgtr2'],
        //         '3' => ['class' => 'bgtr3']
        //     ];

        // else if ($asal == 'biayaang')
        //     $statlabel = [
        //         '0' => ['class' => 'label-inverse-info-border', 'text' => lang('app.baru')],
        //         '1' => ['class' => 'label-warning', 'text' => lang('app.tunda')],
        //         '2' => ['class' => 'label-info', 'text' => lang('app.proses')],
        //         '3' => ['class' => 'label-inverse-danger', 'text' => lang('app.revisi')],
        //         '4' => ['class' => 'label-inverse', 'text' => lang('app.tolak')],
        //         '5' => ['class' => 'label-inverse', 'text' => lang('app.batal')],
        //         '6' => ['class' => 'label-inverse-warning', 'text' => lang('app.gudang')],
        //         '7' => ['class' => 'label-success', 'text' => lang('app.mintaok')],
        //         '8' => ['class' => 'label-success', 'text' => lang('app.pembelian')],
        //         // '9' => ['class' => 'label-primary', 'text' => lang('app.selesai')],
        //         'c' => ['class' => 'label-inverse-info-border', 'text' => lang('app.blmacc')]
        //     ];
        else if ($asal == 'biayakas')
            $statlabel = [
                '0' => ['class' => 'badge rounded-pill bg-label-dark', 'text' => lang('app.baru')],
                '1' => ['class' => 'badge rounded-pill bg-label-dark', 'text' => lang('app.tunda')],
                '2' => ['class' => 'badge rounded-pill bg-label-dark', 'text' => lang('app.proses')],
                '3' => ['class' => 'badge rounded-pill bg-label-dark', 'text' => lang('app.revisi')],
                '4' => ['class' => 'badge rounded-pill bg-label-dark', 'text' => lang('app.tolak')],
                '5' => ['class' => 'badge rounded-pill bg-label-dark', 'text' => lang('app.batal')],
                'c' => ['class' => 'badge rounded-pill bg-label-dark', 'text' => lang('app.belum acc')]
            ];
        // else
        //     $labelStatus = ['class' => '', 'text' => ''];


        // $labelStatusMapping = [
        //     'c' => ['class' => 'badge rounded-pill bg-label-dark', 'text' => lang('app.inaktif')],
        //     '1' => ['class' => 'badge rounded-pill bg-label-primary', 'text' => lang('app.confirm')],
        //     'a' => ['class' => 'badge rounded-pill bg-label-info', 'text' => lang('app.baru')],
        //     'default' => ['class' => 'badge rounded-pill bg-label-warning', 'text' => lang('app.tunda')],
        // ];
        // $labelStatus = $labelStatusMapping[$nomor] ?? $labelStatusMapping['default'];
        $labelStatus = $statlabel[$nomor] ?? ['class' => '', 'text' => ''];
        // $status = $statlabel[$nostat] ?? ['class' => '', 'text' => ''];
        return $labelStatus;
    }
}

//Fungsi angka ke huruf
if (!function_exists('Terbilang')) {
    function Terbilang($angka)
    {
        $angka = abs($angka);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($angka < 12)
            $temp = " " . $huruf[$angka];
        else if ($angka < 20)
            $temp = terbilang($angka - 10) . " belas";
        else if ($angka < 100)
            $temp = terbilang($angka / 10) . " puluh" . terbilang($angka % 10);
        else if ($angka < 200)
            $temp = " seratus" . terbilang($angka - 100);
        else if ($angka < 1000)
            $temp = terbilang($angka / 100) . " ratus" . terbilang($angka % 100);
        else if ($angka < 2000)
            $temp = " seribu" . terbilang($angka - 1000);
        else if ($angka < 1000000)
            $temp = terbilang($angka / 1000) . " ribu" . terbilang($angka % 1000);
        else if ($angka < 1000000000)
            $temp = terbilang($angka / 1000000) . " juta" . terbilang($angka % 1000000);
        else if ($angka < 1000000000000)
            $temp = terbilang($angka / 1000000000) . " milyar" . terbilang(fmod($angka, 1000000000));
        else if ($angka < 1000000000000000)
            $temp = terbilang($angka / 1000000000000) . " trilyun" . terbilang(fmod($angka, 1000000000000));
        return $temp;
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
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}
