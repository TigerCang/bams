<?php

namespace App\Controllers\alat\tiket;

use Config\App;
use App\Controllers\BaseController;
use App\Models\alat\TiketcampModel;

class Cektiket extends BaseController
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
            't_menu' => lang("app.tt_cektiketproyek"),
            't_submenu' => '',
            't_icon' => '<i class="fa fa-ticket ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-ticket"></i>',
            't_dir1' => lang("app.tiket"),
            't_dirac' => lang("app.proyek"),
            't_link' => '/tiketproyek',
            'tuser' => $this->user,
        ];

        return view('alat/tiket/cektiket_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function loadtiket()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->isAJAX()) {
                $tiket = $this->tranModel->loadtiket($this->request->getvar('searchTerm'));
                $tiketdata = array();
                $tiketdata[] = array('id' => '', 'text' => lang("app.pilihsr"));
                foreach ($tiket as $row) {
                    $tiketdata[] = array('id' => $row->id, 'text' => $row->notiket . ", " . $row->nopol . " => " . $row->namaalat);
                }
                echo json_encode($tiketdata);
            } else {
                exit('out');
            }
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function outfocustiket()
    {
        if ($this->request->isAJAX()) {
            $db = $this->deklarModel->satuID('tiket_camp', $this->request->getvar('tiket'), 'id');
            if (!empty($db)) {
                $dbso = $this->deklarModel->satuID('jual_induk', $db['0']->sojual_id, 'id');
                $perus = $this->deklarModel->satuID('m_perusahaan', $dbso['0']->perusahaan_id, 'id');
                $isiperus = "<option>{$perus['0']->kode} => {$perus['0']->nama}</option>";
                $wil = $this->deklarModel->satuID('m_divisi', $dbso['0']->wilayah_id, 'id');
                $isiwil = "<option>{$wil['0']->nama}</option>";
                $div = $this->deklarModel->satuID('m_divisi', $dbso['0']->divisi_id, 'id');
                $isidiv = "<option>{$div['0']->nama}</option>";
                $cabang = $this->deklarModel->satuID('m_camp', $dbso['0']->cabang_id, 'id');
                $penerima = $this->deklarModel->satuID('m_penerima', $dbso['0']->penerima_id, 'id');
                $proyek = $this->deklarModel->satuID('m_proyek', $dbso['0']->proyek_id, 'id');
                $subruas = $this->deklarModel->satuID('m_ruas', $db['0']->subruas_id, 'id');
                $ruas = $this->deklarModel->satuID('m_ruas', $subruas['0']->ruas_id, 'id');
                $isiruas = "<option>{$ruas['0']->nama}, {$subruas['0']->kode} => {$subruas['0']->nama}</option>";
                $biaya = $this->deklarModel->satuID('m_biaya', $db['0']->biaya_id, 'id');
                $isibiaya = "<option>{$biaya['0']->kode} => {$biaya['0']->nama} ({$biaya['0']->matabayar})</option>";
                $barang = $this->deklarModel->satuID('m_barang', $db['0']->barang_id, 'id');
                $isibarang = "<option>{$barang['0']->kode} => {$barang['0']->nama}</option>";
                $alat1 = $this->deklarModel->satuID('m_alat', $db['0']->alat_id, 'id');
                $perusid = ($alat1['0']->pilihan == 'rekan') ? $alat1['0']->penerima_id : $alat1['0']->perusahaan_id;
                $perus1 = $this->deklarModel->satuID('m_penerima', $perusid, 'id');
                $isialat = "<option>{$alat1['0']->nomor} => {$alat1['0']->nama} ( {$perus1['0']->nama} )</option>";
                // $isibentuk = "<option>{$alat1['0']->bentuk}</option>";
                // $kategori = $this->deklarModel->satuID('m_divisi', $alat1['0']->kategori_id, 'id');
                // $isikategori = "<option>{$kategori['0']->nama}</option>";
                $supir = $this->deklarModel->satuID('m_penerima', $db['0']->supir_id, 'id');
                $isisupir = "<option>{$supir['0']->kode} => {$supir['0']->nama}</option>";

                $data = [
                    'perusahaan' => $isiperus,
                    'wilayah' => $isiwil,
                    'divisi' => $isidiv,
                    'ruas' => $isiruas,
                    'biaya' => $isibiaya,
                    'barang' => $isibarang,
                    // 'bentuk' => $isibentuk,
                    // 'kategori' => $isikategori,
                    'alat' => $isialat,
                    'supir' => $isisupir,
                    'tiket' => $db,
                    'cabang' => $cabang,
                    'penerima' => $penerima,
                    'proyek' => $proyek,
                    'subruas' => $subruas,
                ];
            } else {
                $isiperus = '<option value="">' . lang("app.pilih-") . '</option>';
                $isiwil = '<option value="">' . lang("app.pilih-") . '</option>';
                $isidiv = '<option value="">' . lang("app.pilih-") . '</option>';
                $isiruas = '<option value="">' . lang("app.pilih-") . '</option>';
                $isibiaya = '<option value="">' . lang("app.pilih-") . '</option>';
                $isibarang = '<option value="">' . lang("app.pilih-") . '</option>';
                // $isibentuk = '<option value="">' . lang("app.pilih-") . '</option>';
                // $isikategori = '<option value="">' . lang("app.pilih-") . '</option>';
                $isialat = '<option value="">' . lang("app.pilihsr") . '</option>';
                $isisupir = '<option value="">' . lang("app.pilihsr") . '</option>';

                $data = [
                    'perusahaan' => $isiperus,
                    'wilayah' => $isiwil,
                    'divisi' => $isidiv,
                    'ruas' => $isiruas,
                    'biaya' => $isibiaya,
                    'barang' => $isibarang,
                    // 'bentuk' => $isibentuk,
                    // 'kategori' => $isikategori,
                    'alat' => $isialat,
                    'supir' => $isisupir,
                ];
            }
            $data = ['sukses' => $data];
            echo json_encode($data);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function savedata()
    {
        if ($this->request->isAJAX()) {
            $validationRules = [
                'notiket' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'notiket' => $this->validation->getError('notiket'),
                    ]
                ];
            } else {
                $this->tiketcampModel->save([
                    'id' =>  $this->request->getVar('notiket'),
                    'st_tiket' =>  '2',
                ]);
                $msg = ['sukses' => $this->request->getVar('nomortiket') . " " . lang("app.judulsimpan")];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
