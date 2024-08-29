<?php

namespace App\Controllers\alat\tiket;

use Config\App;
use App\Controllers\BaseController;
use App\Models\alat\LembarwaktuModel;

class Tsproyek extends BaseController
{
    protected $lembarwaktuModel;

    public function __construct()
    {
        $this->lembarwaktuModel = new LembarwaktuModel();
    }

    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        $data = [
            't_menu' => lang("app.tt_tsproyek"),
            't_submenu' => '',
            't_icon' => '<i class="icofont icofont-meeting-add ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="icofont icofont-meeting-add"></i>',
            't_dir1' => lang("app.tiket"),
            't_dirac' => lang("app.proyek"),
            't_link' => '/tsproyek',
            'perusahaan' => $this->deklarModel->getPerusahaan('t'),
            'wilayah' => $this->deklarModel->getDivisi('wilayah', 't'),
            'divisi' => $this->deklarModel->getDivisi('divisi', 't'),
            'selbentuk' => $this->deklarModel->distSelect('bentuk'),
            'tuser' => $this->user,
        ];

        return view('alat/tiket/tsproyek_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    // public function tambahdata()
    // {
    //     if ($this->request->isAJAX()) {
    //         $validationRules = [
    //             'kodecamp' => [
    //                 'rules' => 'required',
    //                 'errors' => ['required' => lang("app.errblank")]
    //             ],
    //             'docjual' => [
    //                 'rules' => 'required',
    //                 'errors' => ['required' => lang("app.errpilih")]
    //             ],
    //             'ruas' => [
    //                 'rules' => 'required',
    //                 'errors' => ['required' => lang("app.errpilih")]
    //             ],
    //             'biaya' => [
    //                 'rules' => 'required',
    //                 'errors' => ['required' => lang("app.errpilih")]
    //             ],
    //             'docsewa' => [
    //                 'rules' => 'required',
    //                 'errors' => ['required' => lang("app.errpilih")]
    //             ],
    //             'gudang' => [
    //                 'rules' => 'required',
    //                 'errors' => ['required' => lang("app.errpilih")]
    //             ],
    //             'bahan' => [
    //                 'rules' => 'required',
    //                 'errors' => ['required' => lang("app.errpilih")]
    //             ],
    //             'notiket' => [
    //                 'rules' => 'required',
    //                 'errors' => ['required' => lang("app.errblank")]
    //             ],
    //             'jumlah' => [
    //                 'rules' => 'required',
    //                 'errors' => ['required' => lang("app.errblank")]
    //             ],
    //             'catatan' => [
    //                 'rules' => 'required',
    //                 'errors' => ['required' => lang("app.errblank")]
    //             ],
    //         ];
    //         if (!$this->validate($validationRules)) {
    //             $msg = [
    //                 'error' => [
    //                     'kodecamp' => $this->validation->getError('kodecamp'),
    //                     'docjual' => $this->validation->getError('docjual'),
    //                     'ruas' => $this->validation->getError('ruas'),
    //                     'biaya' => $this->validation->getError('biaya'),
    //                     'docsewa' => $this->validation->getError('docsewa'),
    //                     'gudang' => $this->validation->getError('gudang'),
    //                     'bahan' => $this->validation->getError('bahan'),
    //                     'notiket' => $this->validation->getError('notiket'),
    //                     'jumlah' => $this->validation->getError('notiket'),
    //                     'catatan' => $this->validation->getError('catatan'),
    //                 ]
    //             ];
    //         } else {
    //             $this->tiketcampModel->save([
    //                 'sojual_id' =>  $this->request->getVar('docjual'),
    //                 'sosewa_id' =>  $this->request->getVar('docsewa'),
    //                 'notiket' => $this->request->getVar('notiket'),
    //                 'subruas_id' => $this->request->getVar('ruas'),
    //                 'biaya_id' => $this->request->getVar('biaya'),
    //                 'gudang_id' => $this->request->getVar('gudang'),
    //                 'alat_id' => $this->request->getVar('alat'),
    //                 'alatperush_id' => $this->request->getVar('alatperush'),
    //                 'alatdiv_id' => $this->request->getVar('alatdiv'),
    //                 'supir_id' =>  $this->request->getVar('supir'),
    //                 'supirperush_id' => $this->request->getVar('supirperush'),
    //                 'supirwil_id' => $this->request->getVar('supirwil'),
    //                 'supirdiv_id' => $this->request->getVar('supirdiv'),
    //                 'bahan_id' => $this->request->getVar('bahan'),
    //                 'tanggal' => $this->request->getVar('tanggal'),
    //                 'jumlah' => ubahSeparator($this->request->getVar('jumlah')),
    //                 'catatan' => $this->request->getVar('catatan'),
    //                 'st_tiket' => '0',
    //             ]);
    //             $msg = ['sukses' => $this->request->getVar('notiket') . " " . lang("app.judultambah")];
    //         }
    //         echo json_encode($msg);
    //     } else {
    //         exit('out');
    //     }
    // }

    // ____________________________________________________________________________________________________________________________
    public function loadsosewa()
    {
        if ($this->request->isAJAX()) {
            $sosewa = $this->tranModel->loadts($this->request->getvar('searchTerm'), '', '', '');
            $sosewadata = array();
            $sosewadata[] = array('id' => '', 'text' => lang("app.pilihsr"));
            foreach ($sosewa as $row) {
                $sosewadata[] = array('id' => $row->id, 'text' => $row->kode . " => " . $row->nama);
            }
            echo json_encode($sosewadata);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function loadsosewa1()
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
            $isibahan = "";
            $isibahan .= '<option value="">' . lang("app.pilih-") . '</option>';
            $isibiaya = "";
            $isibiaya .= '<option value="">' . lang("app.pilih-") . '</option>';

            foreach ($sojual as $db) :
                $isidocjual .= "<option value='{$db->id}'>{$db->nodoc}, {$db->nopo} => {$db->proyek}</option>";
            endforeach;
            foreach ($gudang as $db) :
                $isigudang .= "<option value='{$db->id}'>{$db->nama}</option>";
            endforeach;

            $data = [
                'docjual' => $isidocjual,
                'ruas' => $isiruas,
                'docsewa' => $isidocsewa,
                'gudang' => $isigudang,
                'bahan' => $isibahan,
                'biaya' => $isibiaya
            ];
            echo json_encode($data);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    // public function outfocusdocjual()
    // {
    //     if ($this->request->isAJAX()) {
    //         $db = $this->deklarModel->satuID('jual_induk', $this->request->getvar('docjual'), 't');
    //         $isiruas = "";
    //         $isiruas .= '<option value="">' . lang("app.pilih-") . '</option>';
    //         $isibahan = "";
    //         $isibahan .= '<option value="">' . lang("app.pilih-") . '</option>';
    //         $isibiaya = "";
    //         $isibiaya .= '<option value="">' . lang("app.pilih-") . '</option>';
    //         $isisewa = "";
    //         $isisewa .= '<option value="">' . lang("app.pilih-") . '</option>';

    //         if (!empty($db)) {
    //             $proyek1 = $this->deklarModel->satuID('m_proyek', $db['0']->proyek_id, 't');
    //             $penerima1 = $this->deklarModel->satuID('m_penerima', $db['0']->penerima_id, 't');
    //             $ruas = $this->deklarModel->getRuas('subruas', $db['0']->proyek_id, $db['0']->cabang_id, 't');
    //             $bahan = $this->tranModel->getSalesanak($db['0']->id);
    //             $sewa = $this->tranModel->getDokumen('alat', '', $db['0']->proyek_id);

    //             foreach ($ruas as $db2) :
    //                 $isiruas .= "<option value='{$db2->id}'>{$db2->namaruas}, {$db2->kode} => {$db2->nama}</option>";
    //             endforeach;

    //             foreach ($bahan as $db3) :
    //                 $isibahan .= "<option value='{$db3->idbarang}'>{$db3->kodebarang} => {$db3->namabarang}</option>";
    //             endforeach;

    //             foreach ($sewa as $db4) :
    //                 $isisewa .= "<option value='{$db4->id}'>{$db4->nodoc}, {$db4->nopo}</option>";
    //             endforeach;

    //             $data = [
    //                 'dokumen' => $db,
    //                 'proyek' => $proyek1,
    //                 'penerima' => $penerima1,
    //                 'ruas' => $isiruas,
    //                 'bahan' => $isibahan,
    //                 'biaya' => $isibiaya,
    //                 'sewa' => $isisewa,
    //             ];
    //         } else {
    //             $data = ['ruas' => $isiruas, 'bahan' => $isibahan, 'biaya' => $isibiaya, 'sewa' => $isisewa];
    //         }
    //         $data = ['sukses' => $data];
    //         echo json_encode($data);
    //     } else {
    //         exit('out');
    //     }
    // }

    // ____________________________________________________________________________________________________________________________
    // public function outfocusruas()
    // {
    //     if ($this->request->isAJAX()) {
    //         $dbruas = $this->deklarModel->satuID('m_ruas', $this->request->getvar('ruas'), 't');
    //         $isibiaya = "";
    //         $isibiaya .= '<option value="">' . lang("app.pilih-") . '</option>';
    //         if (!empty($dbruas)) {
    //             $biayal = $this->tranModel->getBudgetBL($this->request->getvar('proyek'), $dbruas['0']->ruas_id, $this->request->getvar('tipe'), '');
    //             if (!empty($biayal)) {
    //                 foreach ($biayal as $db) :
    //                     $isibiaya .= "<option value='{$db->biaya_id}'>{$db->biaya} => {$db->namabiaya} ({$db->matabayar})</option>";
    //                 endforeach;
    //             }
    //         }

    //         $data = ['biaya' => $isibiaya, 'subruas' => $dbruas];
    //         $data = ['sukses' => $data];
    //         echo json_encode($data);
    //     } else {
    //         exit('out');
    //     }
    // }

    // ____________________________________________________________________________________________________________________________
    // public function outfocusdocsewa()
    // {
    //     if ($this->request->isAJAX()) {
    //         $isikategori = "";
    //         $isikategori .= '<option value="">' . lang("app.pilih-") . '</option>';

    //         $kategori = $this->tranModel->getKategoriSOsewa($this->request->getvar('docsewa'));
    //         foreach ($kategori as $db) :
    //             $isikategori .= "<option value='{$db->kategori_id}'>{$db->kategori}</option>";
    //         endforeach;

    //         $data = ['kategori' => $isikategori];
    //         echo json_encode($data);
    //     } else {
    //         exit('out');
    //     }
    // }

    // ____________________________________________________________________________________________________________________________
    // public function outfocusbahan()
    // {
    //     if ($this->request->isAJAX()) {
    //         $db = $this->deklarModel->satuID('jual_anak', $this->request->getvar('bahan'), 't');
    //         $data = ['sukses' => $db];
    //         echo json_encode($data);
    //     } else {
    //         exit('out');
    //     }
    // }


    // ____________________________________________________________________________________________________________________________
    // public function outfocussupir()
    // {
    //     if ($this->request->isAJAX()) {
    //         $db = $this->deklarModel->satuID('m_pegawai', $this->request->getvar('supir'), 't');
    //         $data = ['supir' => $db];
    //         echo json_encode($data);
    //     } else {
    //         exit('out');
    //     }
    // }

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
