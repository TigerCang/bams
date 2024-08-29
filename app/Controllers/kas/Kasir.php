<?php

namespace App\Controllers\kas;

use Config\App;
use App\Controllers\BaseController;
use App\Models\kas\KasindukModel;
use App\Models\kas\KasanakModel;

class Kasir extends BaseController
{
    protected $kasindukModel;
    protected $kasanakModel;

    public function __construct()
    {
        $this->kasindukModel = new KasindukModel();
        $this->kasanakModel = new KasanakModel();
    }

    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        // (!preg_match("/118/i", $this->session->menu->menu_1)) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();      
        $data = [
            't_menu' => lang("app.tt_kasir"),
            't_submenu' => '',
            't_icon' => '<i class="fa fa-money ' . lang("app.xinput") . '"></i>',
            't_diricon' => '<i class="fa fa-money"></i>',
            't_dir1' => lang("app.mintakas"),
            't_dirac' => lang("app.kasir"),
            't_link' => '/kasir',
            'perusahaan' => $this->deklarModel->getPerusahaan('t'),
            'wilayah' => $this->deklarModel->getDivisi('wilayah', 't'),
            'divisi' => $this->deklarModel->getDivisi('divisi', 't'),
            'menu' => 'kasir',
            'asal' => '',
            'asal' => '',
            'pesan' => '1',
            'proses' => '6',
            'peminta' => '',
            'tuser' => $this->user,
        ];

        return view('kas/mintakas_view', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function showdata($idunik)
    {
        // (!preg_match("/118/i", $this->session->menu->menu_1)) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();      
        $db1 = $this->deklarModel->satuID('kas_induk', $idunik);
        $data = [
            't_menu' => lang("app.tt_kasir"),
            't_submenu' => '',
            't_icon' => '<i class="fa fa-money ' . lang("app.xinput") . '"></i>',
            't_diricon' => '<i class="fa fa-money"></i>',
            't_dir1' => lang("app.mintakas"),
            't_dirac' => lang("app.kasir"),
            't_link' => '/kasir',
            'idunik' => $idunik,
            'induk' => $this->deklarModel->satuID('kas_induk', $idunik),
            // 'anak' => $this->tranModel->getKasanak($db1['0']->id),
            'sumkas' => $this->tranModel->getsumKasanak($db1['0']->id),
            'selnama' => $this->deklarModel->distSelect('aksiproses'),
            'kelakun' => $this->deklarModel->getKelakun('kas', ''),
            'perusahaan1' => $this->deklarModel->satuID('m_perusahaan', $db1['0']->perusahaan_id, 't', 't'),
            'divisi1' => $this->deklarModel->satuID('m_divisi', $db1['0']->divisi_id, 't', 't'),
            'wilayah1' => $this->deklarModel->satuID('m_divisi', $db1['0']->wilayah_id, 't', 't'),
            'penerima1' => $this->deklarModel->satuID('m_penerima', $db1['0']->penerima_id, 't', 't'),
            'proyek1' => $this->deklarModel->satuID('m_proyek', $db1['0']->cabang_id, 't', 't'),
            'camp1' => $this->deklarModel->satuID('m_camp', $db1['0']->cabang_id, 't', 't'),
            'alat1' => $this->deklarModel->satuID('m_alat', $db1['0']->cabang_id, 't', 't'),
            'tanah1' => $this->deklarModel->satuID('m_tanah', $db1['0']->cabang_id, 't', 't'),
            'menu' => 'kasir',
            'tuser' => $this->user,
            'validation' => \config\Services::validation()
        ];

        (empty($data['induk'])) && throw new \CodeIgniter\Exceptions\PageNotFoundException();
        if (!empty($data['induk'])) {
            if (($this->user['akses_perusahaan'] == "0") && (!preg_match("/," . $data['induk']['0']->perusahaan_id . ",/i", $this->user['perusahaan']))) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
            if (($this->user['akses_wilayah'] == "0") && (!preg_match("/," . $data['induk']['0']->wilayah_id . ",/i", $this->user['wilayah']))) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
            if (($this->user['akses_divisi'] == "0") && (!preg_match("/," . $data['induk']['0']->divisi_id . ",/i", $this->user['divisi']))) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        }
        return view('kas/kasir_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function savedokumen($idunik)
    {
        if (!$this->validate([
            'kasbank' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang("app.errpilih"),
                ]
            ],
            'vtotal' => [
                'rules' => 'required|greater_than_equal_to[1]',
                'errors' => [
                    'required' => lang("app.errblank"),
                    'greater_than_equal_to' => lang("app.err1"),
                ]
            ],
            'catatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang("app.errblank"),
                ]
            ]
        ])) {
            return redirect()->to('/kasir/input/' . $this->request->getVar('idunik'))->withInput();
        }

        $kasin1 = $this->deklarModel->satuID('kas_induk', $this->request->getVar('idunik'));
        $this->kasanakModel->save([
            'kasinduk_id' => $kasin1['0']->id,
            'akun_id' => $this->request->getVar('kasbank'),
            'jumlah' => "1",
            'harga' => ubahkoma($this->request->getVar('total')),
            'kredit' => ubahkoma($this->request->getVar('total')),
            'catatan' => $this->request->getVar('catatan'),
            'status' => '1',
            'asal' => 'biaya',
        ]);
        // $this->tranModel->updateBayarKas($indukbaru['0']->id, $indukbaru['0']->st_cek, $indukbaru['0']->st_setuju, $indukbaru['0']->st_pajak);
        $this->logModel->savelog('/kasir', 'Save', $kasin1['0']->id, $this->request->getVar('nodoc'));
        $this->session->setflashdata(['judul' => $this->request->getVar('nodoc') . ' ' . lang("app.judulsimpan"), 'perus' => $kasin1['0']->perusahaan_id, 'div' => $kasin1['0']->divisi_id]);
        return redirect()->to('/kasir');
    }
}
