<?php

namespace App\Controllers\pembelian;

use Config\App;
use App\Controllers\BaseController;
use App\Models\extra\LogaksiModel;

class Cekpo extends BaseController
{
    protected $logaksiModel;

    public function __construct()
    {
        $this->logaksiModel = new LogaksiModel();
    }

    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        // if (!preg_match("/122/i", session()->menu->menu_1))
        //     throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();

        $data = [
            't_menu' => lang("app.tt_cekpesanbarang"),
            't_submenu' => '',
            't_icon' => '<i class="icofont icofont-stamp ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="icofont icofont-stamp"></i>',
            't_dir1' => lang("app.pembelian"),
            't_dirac' => lang("app.tandat"),
            'perusahaan' => $this->deklarModel->getPerusahaan('1'),
            'divisi' => $this->deklarModel->getDivisi('divisi', '1'),
            'menu' => 'cekpo',
            'pesan' => '',
            'peminta' => '',
            'pilih' => '',
            'tuser' => $this->user,
        ];

        return view('pembelian/pesanbarang_view', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function showdata($idunik)
    {
        // if (!preg_match("/122/i", session()->menu->menu_1))
        // throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();

        $db = $this->deklarModel->satuID('po_pesan', '', $idunik, '1');
        $db1 = $this->deklarModel->satuID('po_minta', '', $db['0']->pominta_id);
        $cabang = $db1['0']->cabang_id;
        $anak = $db1['0']->id;
        $db2 = $this->deklarModel->satuID('m_penerima', '', $db['0']->penerima_id);
        $penerima = $db2['0']->id;

        $data = [
            't_menu' => lang("app.tt_cekpesanbarang"),
            't_submenu' => '',
            't_icon' => '<i class="icofont icofont-stamp ' . lang("app.xinput") . '"></i>',
            't_diricon' => '<i class="icofont icofont-stamp"></i>',
            't_dir1' => lang("app.pembelian"),
            't_dirac' => lang("app.tandat"),
            'idunik' => $idunik,
            'pesan' => $this->tranModel->getDataPOpesan($idunik),
            'anak' => $this->tranModel->getPOanak($anak, ''),
            'selnama' => $this->deklarModel->distSelect('aksiproses'),
            'proyek1' => $this->deklarModel->satuID('m_proyek', '1', $cabang),
            'camp1' => $this->deklarModel->satuID('m_camp', '1', $cabang),
            'alat1' => $this->deklarModel->satuID('m_alat', '1', $cabang),
            'tanah1' => $this->deklarModel->satuID('m_tanah', '1', $cabang),
            'penerima1' => $this->deklarModel->satuID('m_penerima', '1', $penerima),
            'tuser' => $this->user,
            'validation' => \config\Services::validation()
        ];

        if (empty($data['pesan'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
            // throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        }
        return view('pembelian/cekpo_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function savedata()
    {
        if (!$this->validate([
            'catatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang("app.errblank"),
                ]
            ]
        ])) {
            return redirect()->to('/cekpo/input/' . $this->request->getVar('idunik'))->withInput();
        }

        $this->logaksiModel->save([
            'idunik' => $this->request->getVar('idunik'),
            'user_id' => $this->request->getVar('iduser'),
            'menu' => 'pesanbarang',
            'aksi' => $this->request->getVar('aksi'),
            'nodoc' => $this->request->getVar('nopesan'),
            'level' => $this->request->getVar('levsetuju'),
            'catatan' => $this->request->getVar('catatan'),
            'ip_address' => get_ip(),
        ]);

        switch ($this->request->getVar('aksi')) {
            case 'cek':
                $status = '2';
                break;
            case 'terima':
                $status = '2';
                // if (gantikoma($this->request->getVar('nilimit')) >= gantikoma($this->request->getVar('nisum'))) {
                //     $status = '6';
                // }
                break;
            case 'revisi':
                $status = '3';
                break;
            case 'tolak':
                $status = '4';
                break;
        }

        // if (($this->request->getVar('levsetuju') > $this->request->getVar('levpo')) || ($this->request->getVar('levsetuju') == '0')) {
        //     $this->tranModel->updatePOminta($this->request->getVar('idunik'), $this->request->getVar('levsetuju'), $this->request->getVar('aksi'), $status);
        // }

        $menu = $this->deklarModel->satuID('po_pesan', '', $this->request->getVar('idunik'), '1');
        $this->logModel->savelog('/cekpo', $menu['0']->id, 'Save', $this->request->getVar('aksi') . ' => ' . $this->request->getVar('nopesan'));
        $db = $this->deklarModel->satuID('po_minta', '', $menu['0']->pominta_id);
        session()->setflashdata('judul', lang("app.cekjudul"));
        session()->setflashdata('pesan', lang("app.cekdata") . ' ' . $this->request->getVar('nopesan') . ' (' . lang("app." . $this->request->getVar('aksi')) . ') ' .  lang("app.sukses"));
        session()->setflashdata('perus', $db['0']->perusahaan_id);
        session()->setflashdata('div', $db['0']->divisi_id);
        return redirect()->to('/cekpo');
    }

    // ____________________________________________________________________________________________________________________________
    public function tabelbarang()
    {
        // var_dump($this->request->getVar('pesanidunik'));
        // die;
        if ($this->request->isAJAX()) {
            $po1 = $this->deklarModel->satuID('po_minta', '', $this->request->getVar('idunik'), '1');
            (empty(!$po1)) ? $poid = $po1['0']->id : $poid = '';
            (empty(!$po1)) ? $nstatus = $po1['0']->status : $nstatus = '0';
            $data = [
                'barang' => $this->tranModel->getPOanak($poid, '', $this->request->getVar('nodoc'), $this->request->getVar('penerima'), $this->request->getVar('pajak'), '0'),
                'nstat' => $nstatus,
                'meabpr' => $this->request->getVar('meabpr'),
            ];
            $msg = [
                'data' => view('x-umum/barangdetil_tabel', $data)
            ];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
