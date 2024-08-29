<?php

namespace App\Controllers\hrd;

use Config\App;
use App\Controllers\BaseController;
use App\Models\hrd\HrdnilaiModel;

class Nilaipegawai extends BaseController
{
    protected $hrdnilaiModel;

    public function __construct()
    {
        $this->hrdnilaiModel = new HrdnilaiModel();
    }

    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        // (!preg_match("/118/i", $this->session->menu->menu_1)) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();      
        $data = [
            't_menu' => lang("app.tt_nilaipegawai"),
            't_submenu' => '',
            't_icon' => '<i class="fa fa-money ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-money"></i>',
            't_dir1' => lang("app.mintakas"),
            't_dirac' => lang("app.nilaipegawai"),
            't_link' => '/nilaipegawai',
            'menu' => 'nilaipegawai',
            'tandat' => '0',
            'peminta' => $this->session->username,
            'pegawai' => $this->session->menu->id,
            'tuser' => $this->user,
        ];

        return view('hrd/nilaipegawai_view', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function crany()
    {
        do {
            $idu = buatid('60');
            $db = $this->deklarModel->satuID('hrd_nilai', $idu);
        } while (!empty($db));

        $this->iduModel->saveID($idu);
        return redirect()->to('/nilaipegawai/input/' . $idu);
    }

    // ____________________________________________________________________________________________________________________________
    public function showdata($idunik)
    {
        // (!preg_match("/118/i", $this->session->menu->menu_1)) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();      
        $db1 = $this->deklarModel->satuID('hrd_nilai', $idunik);
        $db2 = $this->deklarModel->getBiodata($this->session->menu->id);
        empty($db2) && throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $perusahaan = empty($db1) ? $db2['0']->perusahaan_id : $db1['0']->perusahaan_id;
        $divisi = empty($db1) ? $db2['0']->divisi_id : $db1['0']->divisi_id;
        $wilayah = empty($db1) ? $db2['0']->wilayah_id : $db1['0']->wilayah_id;
        $pegawai = empty($db1) ? $db2['0']->id : $db1['0']->pegawai_id;

        $data = [
            't_menu' => lang("app.tt_nilaipegawai"),
            't_submenu' => '',
            't_icon' => '<i class="fa fa-money ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-money"></i>',
            't_dir1' => lang("app.mintakas"),
            't_dirac' => lang("app.nilaipegawai"),
            't_link' => '/nilaipegawai',
            'idu' => $this->iduModel->cekID($idunik),
            'idunik' => $idunik,
            'perusahaan' => $this->deklarModel->getPerusahaan('t'),
            'wilayah' => $this->deklarModel->getDivisi('wilayah', 't'),
            'divisi' => $this->deklarModel->getDivisi('divisi', 't'),
            'kategori' => $this->deklarModel->getDivisi('katrating', 't'),
            'nodoc' => $this->deklarModel->cekForm('dokumen', 'cuti', 't', '', '', ''),
            'minta' => $this->deklarModel->satuID('hrd_nilai', $idunik),
            'perusahaan1' => $this->deklarModel->satuID('m_perusahaan', $perusahaan, 't'),
            'divisi1' => $this->deklarModel->satuID('m_divisi', $divisi, 't'),
            'wilayah1' => $this->deklarModel->satuID('m_divisi', $wilayah, 't'),
            'pegawai1' => $this->deklarModel->satuID('m_pegawai', $pegawai, 't'),
            'menu' => 'nilaipegawai',
            'tuser' => $this->user,
        ];

        (empty($data['nodoc']) || (empty($data['minta']) && empty($data['idu']))) && throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('hrd/nilaipegawai_input', $data);
    }
}
