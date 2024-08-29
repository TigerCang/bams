<?php

namespace App\Controllers\pembelian;

use Config\App;
use App\Controllers\BaseController;
use App\Models\pembelian\POpesanModel;
use App\Models\pembelian\PObiayaModel;

class Pesanbarang extends BaseController
{
    protected $popesanModel;
    protected $pobiayaModel;

    public function __construct()
    {
        $this->popesanModel = new POpesanModel();
        $this->pobiayaModel = new PObiayaModel();
    }

    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        // if (!preg_match("/122/i", session()->menu->menu_1))
        //     throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();

        $data = [
            't_menu' => lang("app.tt_pesanbarang"),
            't_submenu' => '',
            't_icon' => '<i class="fa fa-product-hunt ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-product-hunt"></i>',
            't_dir1' => lang("app.pembelian"),
            't_dirac' => lang("app.pesanbarang"),
            'perusahaan' => $this->deklarModel->getPerusahaan('1'),
            'divisi' => $this->deklarModel->getDivisi('divisi', '1'),
            'menu' => 'pesanbarang',
            'pesan' => '1',
            'peminta' => '',
            'pilih' => '',
            'tuser' => $this->user,
        ];

        return view('pembelian/pesanbarang_view', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function crany()
    {
        ulang1:
        $idu = buatid('60');
        $db = $this->deklarModel->cekID('po_pesan', $idu);
        if (!empty($db)) {
            goto ulang1;
        }
        $this->iduModel->saveID($idu);
        return redirect()->to('/pesanbarang/input/' . $idu);
    }

    // ____________________________________________________________________________________________________________________________
    public function showdata($idunik)
    {
        // if (!preg_match("/122/i", session()->menu->menu_1))
        // throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();

        $db = $this->deklarModel->satuID('po_pesan', '', $idunik, '1');
        if (!empty($db)) {
            $db1 = $this->deklarModel->satuID('po_minta', '', $db['0']->pominta_id);
            $cabang = $db1['0']->cabang_id;
            $anak = $db1['0']->id;
            $db2 = $this->deklarModel->satuID('m_penerima', '', $db['0']->penerima_id);
            $penerima = $db2['0']->id;
        } else {
            $cabang = '';
            $penerima = '';
            $anak = '';
        }

        $data = [
            't_menu' => lang("app.tt_pesanbarang"),
            't_submenu' => '',
            't_icon' => '<i class="fa fa-product-hunt ' . lang("app.xinput") . '"></i>',
            't_diricon' => '<i class="fa fa-product-hunt"></i>',
            't_dir1' => lang("app.pembelian"),
            't_dirac' => lang("app.pesanbarang"),
            'idu' => $this->iduModel->cekID($idunik),
            'idunik' => $idunik,
            'perusahaan' => $this->deklarModel->getPerusahaan('1'),
            'wilayah' => $this->deklarModel->getDivisi('wilayah', '1'),
            'divisi' => $this->deklarModel->getDivisi('divisi', '1'),
            'nodoc' => $this->deklarModel->cekForm('dokumen', 'pesanbarang', '1', '', '', ''),
            'pesan' => $this->tranModel->getDataPOpesan($idunik),
            // 'anak' => $this->tranModel->getPOanak($anak, ''),
            'anak' => $this->tranModel->getPOanak($anak, '1', $db1['0']->nodoc, $db['0']->penerima_id, $db['0']->st_pajak, $db['0']->id),
            'selnama' => $this->deklarModel->distSelect('bebanitem'),
            'proyek1' => $this->deklarModel->satuID('m_proyek', '1', $cabang),
            'camp1' => $this->deklarModel->satuID('m_camp', '1', $cabang),
            'alat1' => $this->deklarModel->satuID('m_alat', '1', $cabang),
            'tanah1' => $this->deklarModel->satuID('m_tanah', '1', $cabang),
            'penerima1' => $this->deklarModel->satuID('m_penerima', '1', $penerima),
            'tuser' => $this->user,
            'validation' => \config\Services::validation()
        ];

        if ((empty($data['nodoc'])) || (empty($data['pesan']) && (empty($data['idu'])))) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
            // throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        }
        return view('pembelian/pesanbarang_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function savebiaya()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();

            // if (!$this->validate([
            //     'catatan' => [
            //         'rules' => 'required',
            //         'errors' => [
            //             'required' => lang("app.errblank"),
            //         ]
            //     ],
            // ])) {
            //     $msg = [
            //         'error' => [
            //             'akses' => $validation->getError('akses'),
            //         ]
            //     ];
            // } else {
            $this->pobiayaModel->save([
                'idunik_po' =>  $this->request->getVar('idunik'),
                'poanak_id' => $this->request->getVar('item'),
                'akun_id' => $this->request->getVar('biaya'),
                'jumlah' => ubahkoma($this->request->getVar('jumlah')),
                'biaya' => ubahkoma($this->request->getVar('total')),
                'catatan' => $this->request->getVar('catatan'),
            ]);

            // $db9 = $this->deklarModel->akhirID('po_anak');
            // $this->logModel->savelog('/mintabarang', $db9['0']->id, 'Save', $nomordokumen . " => " . $kode);
            $msg = [
                // 'sukses' => lang("app.inputdata") . ' ' . $nama . ' ' . lang("app.sukses"),
                'judul' => lang("app.mintajudul"),
                // 'nodoc' => $nomordokumen,
            ];
            // }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function savedata($idunik)
    {
        if (!$this->validate([
            'penerima' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang("app.errpilih"),
                ]
            ],
            'docminta' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang("app.errblank"),
                    'is_unique' => lang("app.errunik"),
                ]
            ],
        ])) {
            return redirect()->to('/pesanbarang/input/' . $idunik)->withInput();
        }

        $db = $this->tranModel->getNomordoc('po_pesan', $this->request->getVar('kui'), "-" . substr($this->request->getVar('tanggal'), 2, 2));
        (empty($db['0']->nodoc)) ? $nomor = "1" : $nomor = substr($db['0']->nodoc, -4) + 1;
        $nomordokumen = nodokumen($this->request->getVar('kui'), $this->request->getVar('tanggal'), $nomor);
        $mintaid = $this->deklarModel->satuID('po_minta', '', $this->request->getVar('mintaunik'), '1');
        $this->popesanModel->save([
            'idunik' =>  $idunik,
            'pominta_id' => $mintaid['0']->id,
            'penerima_id' => $this->request->getVar('penerima'),
            'nodoc' => $nomordokumen,
            'tgl_po' => $this->request->getVar('tanggal'),
            'total1' => ubahkoma($this->request->getVar('nisubtotal')),
            'totppn' => ubahkoma($this->request->getVar('nippn')),
            'total2' => ubahkoma($this->request->getVar('nitotal')),
            'st_pajak' => $this->request->getVar('xpajak'),
            'status' => '1',
        ]);

        $menu = $this->deklarModel->satuID('po_pesan', '', $idunik, '1');
        $this->tranModel->UpdatePOPesanAnak($menu['0']->id, $mintaid['0']->id, $this->request->getVar('penerima'), $this->request->getVar('xpajak'));
        $this->logModel->savelog('/pesanbarang', $menu['0']->id, 'Save', $nomordokumen);
        session()->setflashdata('judul',  lang("app.simpanjudul"));
        session()->setflashdata('pesan', lang("app.simpandata") . ' ' . $nomordokumen . ' ' . lang("app.sukses"));
        session()->setflashdata('perus', $this->request->getVar('idperusahaan'));
        session()->setflashdata('div', $this->request->getVar('iddivisi'));
        return redirect()->to('/pesanbarang');
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
    public function tabelbiaya()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'biaya' => $this->tranModel->getPObiaya($this->request->getVar('idunik')),
            ];
            $msg = [
                'data' => view('x-umum/biayatambah_tabel', $data)
            ];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
