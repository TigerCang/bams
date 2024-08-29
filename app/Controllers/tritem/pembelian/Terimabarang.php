<?php

namespace App\Controllers\pembelian;

use Config\App;
use App\Controllers\BaseController;
use App\Models\pembelian\POpesanModel;
use App\Models\pembelian\POanakModel;
use App\Models\pembelian\POmasukModel;

class Terimabarang extends BaseController
{
    protected $popesanModel;
    protected $poanakModel;
    protected $pomasukModel;

    public function __construct()
    {
        $this->popesanModel = new POpesanModel();
        $this->poanakModel = new POanakModel();
        $this->pomasukModel = new POmasukModel();
    }

    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        // if (!preg_match("/122/i", session()->menu->menu_1))
        //     throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();

        $data = [
            't_menu' => lang("app.tt_terimabarang"),
            't_submenu' => '',
            't_icon' => '<i class="fa fa-product-hunt ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-product-hunt"></i>',
            't_dir1' => lang("app.pembelian"),
            't_dirac' => lang("app.terimabarang"),
            'perusahaan' => $this->deklarModel->getPerusahaan('1'),
            'divisi' => $this->deklarModel->getDivisi('divisi', '1'),
            'menu' => 'terimabarang',
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
            't_menu' => lang("app.tt_terimabarang"),
            't_submenu' => '',
            't_icon' => '<i class="fa fa-product-hunt ' . lang("app.xinput") . '"></i>',
            't_diricon' => '<i class="fa fa-product-hunt"></i>',
            't_dir1' => lang("app.pembelian"),
            't_dirac' => lang("app.terimabarang"),
            'idunik' => $idunik,
            'pesan' => $this->tranModel->getDataPOpesan($idunik),
            // 'anak' => $this->tranModel->getPOanak($anak,''),
            'anak' => $this->tranModel->getPOanak($anak, '', $db1['0']->nodoc, $db['0']->penerima_id, $db['0']->st_pajak, $db['0']->id),
            'gudang' => $this->deklarModel->getgudang('gudang', '1', $db1['0']->perusahaan_id, $db1['0']->wilayah_id, $db1['0']->divisi_id),
            'proyek1' => $this->deklarModel->satuID('m_proyek', '1', $cabang),
            'camp1' => $this->deklarModel->satuID('m_camp', '1', $cabang),
            'alat1' => $this->deklarModel->satuID('m_alat', '1', $cabang),
            'tanah1' => $this->deklarModel->satuID('m_tanah', '1', $cabang),
            'penerima1' => $this->deklarModel->satuID('m_penerima', '1', $penerima),
            'tuser' => $this->user,
            'validation' => \config\Services::validation()
        ];

        if ((empty($data['pesan']) && (empty($data['idu'])))) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
            // throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        }
        return view('pembelian/terimabarang_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function savedata()
    {
        if ($this->request->isAJAX()) {
            // $validation = \config\Services::validation();

            // if (!$this->validate([
            //  'catatan' => [
            //      'rules' => 'required',
            //      'errors' => [
            //          'required' => lang("app.errblank"),
            //      ]
            //  ],
            // ])) {
            //     $msg = [
            //     'error' => [
            //         'catatan' => $validation->getError('catatan'),
            //     ]
            // ];
            // } else {
            $db = $this->deklarModel->satuID('po_pesan', '', $this->request->getVar('idunik'), '1');
            $this->pomasukModel->save([
                'popesan_id' => $db['0']->id,
                'poanak_id' => $this->request->getVar('item'),
                'tanggal' => $this->request->getVar('tglmasuk'),
                'gudang_id' => $this->request->getVar('gudang'),
                'tiket' => $this->request->getVar('tiket'),
                'nopol' => strtoupper($this->request->getVar('nopol')),
                'supir' => $this->request->getVar('supir'),
                'jl_awal' => ubahkoma($this->request->getVar('jumlah')),
                'jl_hasil' => ubahkoma($this->request->getVar('hasil')),
            ]);

            // $this->logModel->savelog('/mintabarang', $db9['0']->id, 'Save', $nomordokumen . " => " . $kode);
            $msg = [
                'sukses' => lang("app.inputdata") . ' ' . "aa" . ' ' . lang("app.sukses"),
                // 'judul' => lang("app.mintajudul"),
                // 'nodoc' => $nomordokumen,
            ];
            // }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function modaldokumen()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'dokumen' => $this->tranModel->getDokumenPO($this->request->getvar('dokumen'), $this->request->getvar('penerima')),
                'tuser' => $this->user,
            ];
            $msg = [
                'data' => view('x-modal/select_dokumen', $data)
            ];
            echo json_encode($msg);
        } else {
            exit('out');
        }
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

    // ____________________________________________________________________________________________________________________________
    public function tabelpomasuk()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'barang' => $this->tranModel->getPOmasuk($this->request->getVar('idunik')),
            ];
            $msg = [
                'data' => view('x-umum/barangmasuk_tabel', $data)
            ];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
