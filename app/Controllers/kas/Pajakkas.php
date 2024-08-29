<?php

namespace App\Controllers\kas;

use Config\App;
use App\Controllers\BaseController;
use App\Models\kas\KasindukModel;
use App\Models\kas\KasanakModel;
use App\Models\extra\LogaksiModel;

class Pajakkas extends BaseController
{
    protected $kasindukModel;
    protected $kasanakModel;
    protected $logaksiModel;

    public function __construct()
    {
        $this->kasindukModel = new KasindukModel();
        $this->kasanakModel = new KasanakModel();
        $this->logaksiModel = new LogaksiModel();
    }

    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        // (!preg_match("/118/i", $this->session->menu->menu_1)) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();      
        $data = [
            't_menu' => lang("app.tt_pajakmintakas"),
            't_submenu' => '',
            't_icon' => '<i class="fa fa-money ' . lang("app.xinput") . '"></i>',
            't_diricon' => '<i class="fa fa-money"></i>',
            't_dir1' => lang("app.mintakas"),
            't_dirac' => lang("app.pajak"),
            't_link' => '/pajakkas',
            'perusahaan' => $this->deklarModel->getPerusahaan('t'),
            'wilayah' => $this->deklarModel->getDivisi('wilayah', 't'),
            'divisi' => $this->deklarModel->getDivisi('divisi', 't'),
            'menu' => 'pajakkas',
            'asal' => '',
            'pesan' => '1',
            'proses' => '2',
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
            't_menu' => lang("app.tt_pajakmintakas"),
            't_submenu' => '',
            't_icon' => '<i class="fa fa-money ' . lang("app.xinput") . '"></i>',
            't_diricon' => '<i class="fa fa-money"></i>',
            't_dir1' => lang("app.mintakas"),
            't_dirac' => lang("app.pajak"),
            't_link' => '/pajakkas',
            'idunik' => $idunik,
            'induk' => $this->deklarModel->satuID('kas_induk', $idunik),
            // 'anak' => $this->tranModel->getKasanak($db1['0']->id),
            'selnama' => $this->deklarModel->distSelect('aksiproses'),
            'kelakun' => $this->deklarModel->getKelakun('pajak', ''),
            'perusahaan1' => $this->deklarModel->satuID('m_perusahaan', $db1['0']->perusahaan_id, 't', 't'),
            'divisi1' => $this->deklarModel->satuID('m_divisi', $db1['0']->divisi_id, 't', 't'),
            'wilayah1' => $this->deklarModel->satuID('m_divisi', $db1['0']->wilayah_id, 't', 't'),
            'penerima1' => $this->deklarModel->satuID('m_penerima', $db1['0']->penerima_id, 't', 't'),
            'proyek1' => $this->deklarModel->satuID('m_proyek', $db1['0']->cabang_id, 't', 't'),
            'camp1' => $this->deklarModel->satuID('m_camp', $db1['0']->cabang_id, 't', 't'),
            'alat1' => $this->deklarModel->satuID('m_alat', $db1['0']->cabang_id, 't', 't'),
            'tanah1' => $this->deklarModel->satuID('m_tanah', $db1['0']->cabang_id, 't', 't'),
            'menu' => 'pajakkas',
            'tuser' => $this->user,
            'validation' => \config\Services::validation()
        ];

        (empty($data['induk'])) && throw new \CodeIgniter\Exceptions\PageNotFoundException();
        if (!empty($data['induk'])) {
            if (($this->user['akses_perusahaan'] == "0") && (!preg_match("/," . $data['induk']['0']->perusahaan_id . ",/i", $this->user['perusahaan']))) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
            if (($this->user['akses_wilayah'] == "0") && (!preg_match("/," . $data['induk']['0']->wilayah_id . ",/i", $this->user['wilayah']))) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
            if (($this->user['akses_divisi'] == "0") && (!preg_match("/," . $data['induk']['0']->divisi_id . ",/i", $this->user['divisi']))) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        }
        return view('kas/pajakkas_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function tambahdata()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();

            if (!$this->validate([
                'noakun' => [
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
                ],
            ])) {
                $msg = [
                    'error' => [
                        'noakun' => $validation->getError('noakun'),
                        'vtotal' => $validation->getError('vtotal'),
                        'catatan' => $validation->getError('catatan'),
                    ]
                ];
            } else {
                list($debit, $kredit) = ($this->request->getVar('posisidk') == 'debit') ? [ubahkoma($this->request->getVar('total')), 0] : [0, ubahkoma($this->request->getVar('total'))];

                $kasinduk1 = $this->deklarModel->satuID('kas_induk', $this->request->getVar('idunik'));
                $this->kasanakModel->save([
                    'kasinduk_id' => $kasinduk1['0']->id,
                    'akun_id' => $this->request->getVar('noakun'),
                    'jumlah' => ubahkoma($this->request->getVar('jumlah')),
                    'harga' => ubahkoma($this->request->getVar('harga')),
                    'debit' => $debit,
                    'kredit' => $kredit,
                    'catatan' => $this->request->getVar('catatan'),
                    'nopajak' => $this->request->getVar('nopajak'),
                    'status' => '1',
                    'asal' => 'pajak',
                ]);

                $akun1 = $this->deklarModel->satuID('m_akun', $this->request->getVar('noakun'), 't', 't');
                $msg = ['sukses' => $akun1['0']->noakun . ' ' . lang("app.judultambah")];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function savedokumen()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();

            // var_dump($this->request->getVar('idunik'));
            // die;
            // $db = $this->deklarModel->satuID('kas_induk', $this->request->getVar('idunik'));
            $this->tranModel->updateKasinduk($this->request->getVar('idunik'), '', '', '', '', '1');
            $indukbaru = $this->deklarModel->satuID('kas_induk', $this->request->getVar('idunik'));
            $this->tranModel->updateBayarKas($indukbaru['0']->id, $indukbaru['0']->st_cek, $indukbaru['0']->st_setuju, $indukbaru['0']->st_pajak);

            $this->logModel->saveLog('/pajakkas', $indukbaru['0']->id, 'Save', $indukbaru['0']->nodoc);
            $msg = ['sukses' => $indukbaru['0']->nodoc . ' ' . lang("app.judulsimpan"), 'perus' => $indukbaru['0']->perusahaan_id, 'div' => $indukbaru['0']->divisi_id];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
