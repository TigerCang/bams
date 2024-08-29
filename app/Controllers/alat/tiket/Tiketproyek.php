<?php

namespace App\Controllers\alat\tiket;

use Config\App;
use App\Controllers\BaseController;
use App\Models\alat\TiketcampModel;

class Tiketproyek extends BaseController
{
    protected $tiketcampModel;

    public function __construct()
    {
        $this->tiketcampModel = new TiketcampModel();
    }

    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        $data = [
            't_menu' => lang("app.tt_tiketproyek"),
            't_submenu' => '',
            't_icon' => '<i class="fa fa-ticket ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-ticket"></i>',
            't_dir1' => lang("app.tiket"),
            't_dirac' => lang("app.proyek"),
            't_link' => '/tiketproyek',
            'perusahaan' => $this->deklarModel->getPerusahaan('t'),
            'wilayah' => $this->deklarModel->getDivisi('wilayah', 't'),
            'divisi' => $this->deklarModel->getDivisi('divisi', 't'),
            'selbentuk' => $this->deklarModel->distSelect('bentuk'),
            'selkategori' => $this->deklarModel->getDivisi('katalat', 't'),
            'tuser' => $this->user,
        ];

        return view('alat/tiket/tiketproyek_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function tambahdata()
    {
        if ($this->request->isAJAX()) {
            $validationRules = [
                'kodecamp' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
                'docjual' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'ruas' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'biaya' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'docsewa' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'jasa' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'gudang' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'barang' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'notiket' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
                'jumlah' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
                'catatan' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'kodecamp' => $this->validation->getError('kodecamp'),
                        'docjual' => $this->validation->getError('docjual'),
                        'ruas' => $this->validation->getError('ruas'),
                        'biaya' => $this->validation->getError('biaya'),
                        'docsewa' => $this->validation->getError('docsewa'),
                        'jasa' => $this->validation->getError('jasa'),
                        'gudang' => $this->validation->getError('gudang'),
                        'barang' => $this->validation->getError('barang'),
                        'notiket' => $this->validation->getError('notiket'),
                        'jumlah' => $this->validation->getError('notiket'),
                        'catatan' => $this->validation->getError('catatan'),
                    ]
                ];
            } else {
                $this->tiketcampModel->save([
                    'sojual_id' =>  $this->request->getVar('docjual'),
                    'sojual2_id' =>  $this->request->getVar('barang'),
                    'sosewa_id' =>  $this->request->getVar('docsewa'),
                    'sosewa2_id' =>  $this->request->getVar('jasa'),
                    'asal' =>  'proyek',
                    'notiket' => $this->request->getVar('notiket'),
                    'subruas_id' => $this->request->getVar('ruas'),
                    'biaya_id' => $this->request->getVar('biaya'),
                    'gudang_id' => $this->request->getVar('gudang'),
                    'barang_id' => $this->request->getVar('idbarang'),
                    'alat_id' => $this->request->getVar('alat'),
                    'alatperush_id' => $this->request->getVar('alatperush'),
                    'alatdiv_id' => $this->request->getVar('alatdiv'),
                    'supir_id' =>  $this->request->getVar('supir'),
                    'supirperush_id' => $this->request->getVar('supirperush'),
                    'supirwil_id' => $this->request->getVar('supirwil'),
                    'supirdiv_id' => $this->request->getVar('supirdiv'),
                    'tanggal' => $this->request->getVar('tanggal'),
                    'jumlah' => ubahSeparator($this->request->getVar('jumlah')),
                    'catatan' => $this->request->getVar('catatan'),
                    'st_tiket' => '0',
                ]);
                $msg = ['sukses' => $this->request->getVar('notiket') . " " . lang("app.judultambah")];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function loadsojual()
    {
        if ($this->request->isAJAX()) {
            $sojual = $this->tranModel->getDokumen('camp', $this->request->getvar('camp'), 't');
            $gudang = $this->deklarModel->getGudang('gudang', 't', $this->request->getvar('perusahaan'), $this->request->getvar('wilayah'), $this->request->getvar('divisi'));
            $isidocjual = "";
            $isidocjual .= '<option value="">' . lang("app.pilih-") . '</option>';
            $isiruas = "";
            $isiruas .= '<option value="">' . lang("app.pilih-") . '</option>';
            $isidocsewa = "";
            $isidocsewa .= '<option value="">' . lang("app.pilih-") . '</option>';
            $isigudang = "";
            $isigudang .= '<option value="">' . lang("app.pilih-") . '</option>';
            $isibarang = "";
            $isibarang .= '<option value="">' . lang("app.pilih-") . '</option>';
            $isibiaya = "";
            $isibiaya .= '<option value="">' . lang("app.pilih-") . '</option>';

            foreach ($sojual as $db) :
                $isidocjual .= "<option value='{$db->id}'>{$db->nodoc}; {$db->nopo} => {$db->proyek}</option>";
            endforeach;
            foreach ($gudang as $db) :
                $isigudang .= "<option value='{$db->id}'>{$db->nama}</option>";
            endforeach;

            $data = [
                'docjual' => $isidocjual,
                'ruas' => $isiruas,
                'docsewa' => $isidocsewa,
                'gudang' => $isigudang,
                'barang' => $isibarang,
                'biaya' => $isibiaya
            ];
            echo json_encode($data);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function loadalat()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->isAJAX()) {
                $alat = $this->deklarModel->loadAlatincRekanan($this->request->getvar('searchTerm'), $this->request->getvar('bentuk'), $this->request->getvar('kategori'));
                $alatdata = array();
                $alatdata[] = array('id' => '', 'text' => lang("app.pilihsr"));
                foreach ($alat as $row) {
                    $perusahaan = ($row->pilihan == 'rekan') ? $row->penerima : $row->perusahaan;
                    $alatdata[] = array('id' => $row->id, 'text' => $row->nomor . " => " . $row->nama . " (" . $perusahaan . ")");
                }
                echo json_encode($alatdata);
            } else {
                exit('out');
            }
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function outfocusdocjual()
    {
        if ($this->request->isAJAX()) {
            $db = $this->deklarModel->satuID('jual_induk', $this->request->getvar('docjual'), 'id');
            $isiruas = "";
            $isiruas .= '<option value="">' . lang("app.pilih-") . '</option>';
            $isibarang = "";
            $isibarang .= '<option value="">' . lang("app.pilih-") . '</option>';
            $isibiaya = "";
            $isibiaya .= '<option value="">' . lang("app.pilih-") . '</option>';
            $isisewa = "";
            $isisewa .= '<option value="">' . lang("app.pilih-") . '</option>';
            if (!empty($db)) {
                $proyek1 = $this->deklarModel->satuID('m_proyek', $db['0']->proyek_id, 'id');
                $penerima1 = $this->deklarModel->satuID('m_penerima', $db['0']->penerima_id, 'id');
                $ruas = $this->deklarModel->getRuas('subruas', $db['0']->proyek_id, $db['0']->cabang_id, 'id');
                $barang = $this->tranModel->getSalesanak($db['0']->id);
                $sewa = $this->tranModel->getDokumen('alat', '', $db['0']->proyek_id);

                foreach ($ruas as $db2) :
                    $isiruas .= "<option value='{$db2->id}'>{$db2->namaruas}, {$db2->kode} => {$db2->nama}</option>";
                endforeach;
                foreach ($barang as $db3) :
                    $isibarang .= "<option value='{$db3->id}'>{$db3->kodebarang} => {$db3->namabarang}; $db3->jumlah</option>";
                endforeach;
                foreach ($sewa as $db4) :
                    $isisewa .= "<option value='{$db4->id}'>{$db4->nodoc}; {$db4->nopo}</option>";
                endforeach;

                $data = [
                    'dokumen' => $db,
                    'proyek' => $proyek1,
                    'penerima' => $penerima1,
                    'ruas' => $isiruas,
                    'barang' => $isibarang,
                    'biaya' => $isibiaya,
                    'sewa' => $isisewa,
                ];
            } else {
                $data = ['ruas' => $isiruas, 'barang' => $isibarang, 'biaya' => $isibiaya, 'sewa' => $isisewa];
            }
            $data = ['sukses' => $data];
            echo json_encode($data);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function outfocusruas()
    {
        if ($this->request->isAJAX()) {
            $dbruas = $this->deklarModel->satuID('m_ruas', $this->request->getvar('ruas'), 'id');
            $isibiaya = "";
            $isibiaya .= '<option value="">' . lang("app.pilih-") . '</option>';
            if (!empty($dbruas)) {
                $biayal = $this->tranModel->getBudgetBL($this->request->getvar('proyek'), $dbruas['0']->ruas_id, $this->request->getvar('tipe'), '');
                if (!empty($biayal)) {
                    foreach ($biayal as $db) :
                        $isibiaya .= "<option value='{$db->biaya_id}'>{$db->biaya} => {$db->namabiaya} ({$db->matabayar})</option>";
                    endforeach;
                }
            }
            $data = ['biaya' => $isibiaya, 'subruas' => $dbruas];
            $data = ['sukses' => $data];
            echo json_encode($data);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function outfocusdocsewa()
    {
        if ($this->request->isAJAX()) {
            $isijasa = "";
            $isijasa .= '<option value="">' . lang("app.pilih-") . '</option>';

            $jasa = $this->tranModel->getSalesanak($this->request->getvar('docsewa'));
            foreach ($jasa as $db2) :
                $jumlahF = formatkoma($db2->jumlah, 4);
                $hargaF = formatkoma($db2->harga, 2);
                $isijasa .= "<option value='{$db2->id}'>{$db2->jasa}; {$db2->kategori}; $jumlahF x $hargaF</option>";
            endforeach;

            $data = ['jasa' => $isijasa];
            echo json_encode($data);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function outfocusjasa()
    {
        if ($this->request->isAJAX()) {
            $db = $this->tranModel->getKategoriSOsewa($this->request->getvar('jasa'));
            $data = ['kategori' => $db['0']->kategori_id ?? ''];
            echo json_encode($data);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function outfocusbarang()
    {
        if ($this->request->isAJAX()) {
            $db = $this->deklarModel->satuID('jual_anak', $this->request->getvar('barang'), 'id');
            $data = ['barang' => $db];
            echo json_encode($data);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function outfocusalat()
    {
        if ($this->request->isAJAX()) {
            $dbalat = $this->deklarModel->satuID('m_alat', $this->request->getvar('alat'), 'id');
            $isisupir = "";
            $isisupir .= '<option value="">' . lang("app.pilihsr") . '</option>';

            if (!empty($dbalat)) {
                $dbsupir = $this->deklarModel->satuID('m_penerima', $dbalat['0']->supir_id, 'id');
                if (!empty($dbsupir)) $isisupir .= "<option value='{$dbsupir['0']->id}' selected>{$dbsupir['0']->kode} => {$dbsupir['0']->nama}</option>";
            }
            $data = ['sukses' => $isisupir, 'alat' => $dbalat, 'supir' => $dbsupir];
            echo json_encode($data);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function outfocussupir()
    {
        if ($this->request->isAJAX()) {
            $db = $this->deklarModel->satuID('m_penerima', $this->request->getvar('supir'), 'id');
            $data = ['supir' => $db];
            echo json_encode($data);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function tabeldata()
    {
        if ($this->request->isAJAX()) {
            $perush = ($this->request->getVar('perusahaan') != 'all' ? $this->request->getVar('perusahaan') : '');
            $div = ($this->request->getVar('divisi') != 'all' ? $this->request->getVar('divisi') : '');
            $data = ['alat' => $this->deklarModel->getAlat('', $perush, $div)];
            $msg = ['data' => view('x-file/alat_tabel', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
