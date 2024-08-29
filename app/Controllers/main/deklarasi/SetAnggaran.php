<?php

namespace App\Controllers\main\deklarasi;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\AnggaranModel;

class SetAnggaran extends BaseController
{
    protected $anggaranModel;
    public function __construct()
    {
        $this->anggaranModel = new AnggaranModel();
    }

    public function index()
    {
        checkPage('102');
        $data = [
            't_judul' => lang('app.anggaran bawaan'),
            't_span' => lang('app.span anggaran bawaan'),
            'link' => '/setanggaran',
            'anggaran' => $this->mainModel->getAnggaran($this->urls[1]),
        ];
        $this->render('main/deklarasi/setanggaran_list', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function inputData()
    {
        $db1 = $this->mainModel->satuID('m_anggaran', $this->request->getVar('datakey'));
        checkPage('101', $db1, 'y', 'n');
        $buttons = setButton($db1);
        if ($db1) $this->logModel->saveLog('Read', $this->request->getVar('datakey'), "{$db1[0]->judul}");

        $data = [
            't_judul' => lang('app.anggaran bawaan'),
            't_span' => lang('app.span anggaran bawaan'),
            'link' => "/setanggaran",
            'selbeban' => $this->mainModel->distSelect('beban'),
            'selpilih' => $this->mainModel->distSelect('setanggaran'),
            'jenis' => $this->mainModel->distinctBiaya('biaya taklangsung'),
            'anggaran' => $db1,
            'button' => ['save' => $buttons['bsave'], 'conf' => $buttons['bconf'], 'del' => $buttons['bdel'], 'aktif' => $buttons['baktif']],
            'btnaktif' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.btn aktif') : lang('app.btn inaktif')),
            'acby' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.inacby') : lang('app.acby')),
        ];
        $this->render('main/deklarasi/setanggaran_input', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function tambahdata()
    {
        if ($this->request->isAJAX()) {
            $idunik = $this->request->getVar('idunik');
            $judul = $this->mainModel->cekAnggaran($this->request->getVar('judul'), $idunik);
            $beban = $this->request->getVar('xbeban');
            $rule_biaya = ($beban == 'proyek' ? 'required' : 'permit_empty');
            $rule_akun = ($beban != 'proyek' ? 'required' : 'permit_empty');
            $jenis = ($beban == 'proyek' ? $this->request->getVar('xjenis') : '');

            $validationRules = [
                // 'akses' => ['rules' => $rule_akses, 'errors' => ['required' => lang("app.err unik")]],
                'judul' => ['rules' => 'required', 'errors' => ['required' => lang("app.err pilih")]],
                'biaya' => ['rules' => $rule_biaya, 'errors' => ['required' => lang("app.err pilih")]],
                'akun' => ['rules' => $rule_akun, 'errors' => ['required' => lang("app.err pilih")]],
                'total' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'akses' => $this->validation->getError('akses'),
                        'judul' => $this->validation->getError('judul'),
                        'biaya' => $this->validation->getError('biaya'),
                        'akun' => $this->validation->getError('akun'),
                        'total' => $this->validation->getError('total'),
                    ]
                ];
            } else {
                $total = ubahSeparator($this->request->getVar('total'));
                $this->anggaranModel->save([
                    'idunik' =>  $idunik,
                    'judul' => $this->request->getVar('judul'),
                    'pilih' => $this->request->getVar('xpilih'),
                    'beban' => $beban,
                    'jenis' => $jenis,
                    'biaya_id' => $this->request->getVar('biaya'),
                    'akun_id' => $this->request->getVar('akun'),
                    'bulan' => ubahSeparator($this->request->getVar('bulan')),
                    'jumlah' => ubahSeparator($this->request->getVar('jumlah')),
                    'harga' =>  ubahSeparator($this->request->getVar('harga')),
                    'total' => $total,
                    'catatan' => $this->request->getVar('catatan'),
                ]);

                $nfield = ($beban == 'proyek' ? 'biaya' : 'akun');
                $nid = ($beban == 'proyek' ? 'biaya_id' : 'akun_id');
                $db4 = $this->mainModel->getIndukbiaya($nfield, $this->request->getVar($nfield));
                $ceklev3 = $this->mainModel->cekAnggaran($idunik, $nfield, $nid, $db4[0]->idlev3);
                if ($ceklev3) {
                    $total3 = $this->mainModel->anggaranTotal($idunik, $db4[0]->idlev3, $nfield);
                    $this->anggaranModel->save(['id' => $ceklev3[0]->id, 'total' => $total3[0]->subtotal]);
                    $this->mainModel->updateDeletedat('m_anggaran', $ceklev3[0]->id);
                } else {
                    $this->anggaranModel->save([
                        'idunik' =>  $idunik,
                        'pilih' => $this->request->getVar('xpilih'),
                        'beban' => $beban,
                        'jenis' => $jenis,
                        $nid => $db4[0]->idlev3,
                        'total' => $total,
                    ]);
                }

                $ceklev2 = $this->mainModel->cekAnggaran($idunik, $nfield, $nid, $db4[0]->idlev2);
                if ($ceklev2) {
                    $total2 = $this->mainModel->anggaranTotal($idunik, $db4[0]->idlev2, $nfield);
                    $this->anggaranModel->save(['id' => $ceklev2[0]->id, 'total' => $total2[0]->subtotal]);
                    $this->mainModel->updateDeletedat('m_anggaran', $ceklev2[0]->id);
                } else {
                    $this->anggaranModel->save([
                        'idunik' =>  $idunik,
                        'pilih' => $this->request->getVar('xpilih'),
                        'beban' => $beban,
                        'jenis' => $jenis,
                        $nid => $db4[0]->idlev2,
                        'total' => $total,
                    ]);
                }

                $ceklev1 = $this->mainModel->cekAnggaran($idunik, $nfield, $nid, $db4[0]->idlev1);
                if ($ceklev1) {
                    $total1 = $this->mainModel->anggaranTotal($idunik, $db4[0]->idlev1, $nfield);
                    $this->anggaranModel->save(['id' => $ceklev1[0]->id, 'total' => $total1[0]->subtotal]);
                    $this->mainModel->updateDeletedat('m_anggaran', $ceklev1[0]->id);
                } else {
                    $this->anggaranModel->save([
                        'idunik' =>  $idunik,
                        'pilih' => $this->request->getVar('xpilih'),
                        'beban' => $beban,
                        'jenis' => $jenis,
                        $nid => $db4[0]->idlev2,
                        'total' => $total,
                        'levsatu' => '1',
                    ]);
                }
                // $this->mainModel->updateData('m_anggaran', 'tujuan', $tujuan, 'idunik', $idunik);
                // $this->mainModel->updateData('m_anggaran', 'is_confirm', '3', 'idunik', $idunik);
                // $this->mainModel->updateData('m_anggaran', 'confirmed_by', '0', 'idunik', $idunik);
                $msg = ['sukses' => "{$db4[0]->nama}" . lang("app.judul tambah")];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function modaldata()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getvar('id');
            $db = $this->deklarModel->satuID('m_anggaran', $id, '', 'id');
            $data = [
                'anggaran' => $db,
                'biaya1' => $this->deklarModel->satuID('m_biaya', $db[0]->biaya_id, '', 'id'),
                'akun1' => $this->deklarModel->satuID('m_akun', $db[0]->akun_id, '', 'id'),
            ];
            $msg = ['data' => view('x-modal/koreksi_anggaran', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function savedata()
    {
        if ($this->request->isAJAX()) {
            $idunik = $this->request->getVar('idunik');
            $db1 = $this->deklarModel->satuID('m_anggaran', $idunik);
            $rule_akses = ($db1 ? 'permit_empty' : 'required');
            $validationRules = [
                'akses' => [
                    'rules' => $rule_akses,
                    'errors' => ['required' => lang("app.errunik2")]
                ],
            ];

            if (!$this->validate($validationRules)) {
                $msg = ['error' => ['akses' => $this->validation->getError('akses')]];
            } else {
                $akby = (($this->request->getVar('niaktif') == '0') ? $this->user['id'] : '0');
                $savj = (($this->request->getVar('niaktif') == '0') ? lang("app.judulnoaktif") : lang("app.judulaktif"));
                $onoff = (($this->request->getVar('niaktif') == '0') ? 'nonaktif' : 'aktif');
                if ($this->request->getVar('postaction') == 'save') {
                    $this->deklarModel->updateData('m_anggaran', 'is_confirm', '0', 'idunik', $idunik);
                    $this->deklarModel->updateData('m_anggaran', 'updated_by', $this->user['id'], 'idunik', $idunik);
                    $this->deklarModel->updateData('m_anggaran', 'confirmed_by', '0', 'idunik', $idunik);
                    $this->logModel->saveLog('Save', $idunik, "{$this->request->getVar('xpilih')} ; {$this->request->getVar('xtujuan')}");
                    session()->setFlashdata('judul', lang('app.' . $this->request->getVar('xpilih')) . ' ; ' . lang('app.' . $this->request->getVar('xtujuan')) . ' ' . lang("app.judulsimpan"));
                } elseif ($this->request->getVar('postaction') == 'confirm') {
                    $this->deklarModel->updateData('m_anggaran', 'is_confirm', '1', 'idunik', $idunik);
                    $this->deklarModel->updateData('m_anggaran', 'confirmed_by', $this->user['id'], 'idunik', $idunik);
                    $this->logModel->saveLog('Confirm', $idunik, "{$this->request->getVar('xpilih')} ; {$this->request->getVar('xtujuan')}");
                    session()->setFlashdata('judul', lang('app.' . $this->request->getVar('xpilih')) . ' ; ' . lang('app.' . $this->request->getVar('xtujuan')) . ' ' . lang("app.judulkonf"));
                } elseif ($this->request->getVar('postaction') == 'aktif') {
                    $this->deklarModel->updateData('m_anggaran', 'is_aktif', $this->request->getVar('niaktif'), 'idunik', $idunik);
                    $this->deklarModel->updateData('m_anggaran', 'activated_by', $akby, 'idunik', $idunik);
                    $this->logModel->saveLog('Active', $idunik, "{$this->request->getVar('xpilih')} ; {$this->request->getVar('xtujuan')} {$onoff}");
                    session()->setFlashdata('judul', lang('app.' . $this->request->getVar('xpilih')) . ' ; ' . lang('app.' . $this->request->getVar('xtujuan')) . ' ' . lang("app.judulkonf") . ' ' . $savj);
                }
                $msg = ['redirect' => '/setanggaran'];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function tabelData()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'anggaran' => $this->mainModel->getAnggaran('', '0', $this->request->getVar('idunik'), $this->request->getVar('judul'), $this->request->getVar('beban')),
                'beban' => $this->request->getVar('xbeban'),
            ];
            $msg = ['data' => view('x-main/setanggaran_table', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $tujuan = $this->request->getVar('mtujuan');
            $idunik = $this->request->getVar('midunik');

            $validationRules = [
                'mcatatan' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
            ];
            if (!$this->validate($validationRules)) {
                $msg = ['error' => ['mcatatan' => $this->validation->getError('mcatatan')]];
            } else {
                $ntabel = ($this->request->getVar('mtujuan') == 'proyek' ? 'm_biaya' : 'm_akun');
                $nfield = ($tujuan == 'proyek' ? 'biaya' : 'akun');
                $nid = ($this->request->getVar('mtujuan') == 'proyek' ? 'biaya_id' : 'akun_id');
                $this->anggaranModel->save([
                    'id' => $this->request->getVar('mid'),
                    'bulan' => ubahSeparator($this->request->getVar('mbulan')),
                    'jumlah' => ubahSeparator($this->request->getVar('mjumlah')),
                    'harga' =>  ubahSeparator($this->request->getVar('mharga')),
                    'total' => ubahSeparator($this->request->getVar('mtotal')),
                    'catatan' => $this->request->getVar('mcatatan'),
                ]);
                $dbu = $this->deklarModel->satuID('m_anggaran', $idunik);
                // $stconf = (($dbu && $dbu[0]->is_confirm != 'off') ? 'onoff' : 'off');
                // $this->deklarModel->updateData('m_anggaran', 'is_confirm', $stconf, 'idunik', $idunik);
                $db4 = $this->deklarModel->satuID($ntabel, $this->request->getVar('mitem'), '', 'id');
                $item = ($tujuan == 'proyek') ? $db4[0]->kode : $db4[0]->noakun;
                // 
                $db3 = $this->deklarModel->satuID($ntabel, $db4[0]->induk_id, '', 'id');
                $ceklev3 = $this->deklarModel->cekAnggaran($idunik, $nfield, $nid, $db3[0]->id);
                $total3 = $this->deklarModel->anggaranTotal($idunik, $db3[0]->id, $nfield);
                $this->anggaranModel->save(['id' => $ceklev3[0]->id, 'total' => $total3[0]->subtotal]);
                // 
                $db2 = $this->deklarModel->satuID($ntabel, $db3[0]->induk_id, '', 'id');
                $ceklev2 = $this->deklarModel->cekAnggaran($idunik, $nfield, $nid, $db2[0]->id);
                $total2 = $this->deklarModel->anggaranTotal($idunik, $db2[0]->id, $nfield);
                $this->anggaranModel->save(['id' => $ceklev2[0]->id, 'total' => $total2[0]->subtotal]);
                // 
                $db1 = $this->deklarModel->satuID($ntabel, $db2[0]->induk_id, '', 'id');
                $ceklev1 = $this->deklarModel->cekAnggaran($idunik, $nfield, $nid, $db1[0]->id);
                $total1 = $this->deklarModel->anggaranTotal($idunik, $db1[0]->id, $nfield);
                $this->anggaranModel->save(['id' => $ceklev1[0]->id, 'total' => $total1[0]->subtotal]);
                $msg = ['sukses' => "{$item}" . lang("app.judulubah")];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function deletedata()
    {
        if ($this->request->isAJAX()) {
            die;
            $id = $this->request->getVar('id');
            $dbu = $this->deklarModel->satuID('m_anggaran', $id, '', 'id');
            $idunik = $dbu[0]->idunik;
            $stconf = (($dbu && $dbu[0]->is_confirm != 'off') ? 'onoff' : 'off');

            // $pilihan = $dbu[0]->pilihan;
            $tujuan = $dbu[0]->tujuan;
            // $jenis = $dbu[0]->idunik;


            $total = ubahSeparator($this->request->getVar('total'));
            $nfield = ($tujuan == 'proyek' ? 'biaya' : 'akun');
            $ntabel = ($tujuan == 'proyek' ? 'm_biaya' : 'm_akun');
            $nid = ($tujuan == 'proyek' ? 'biaya_id' : 'akun_id');
            $nitem = ($tujuan == 'proyek' ? $dbu[0]->biaya_id : $dbu[0]->akun_id);


            // $this->deklarModel->updateData('m_anggaran', 'is_confirm', $stconf, 'idunik', $idunik);
            // $this->anggaranModel->delete($id);

            $db4 = $this->deklarModel->satuID($ntabel, $nitem, '', 'id');
            $item = ($tujuan == 'proyek') ? $db4[0]->kode : $db4[0]->noakun;

            var_dump($tujuan, $nfield, $ntabel, $id, $nitem, $item);
            die;

            // 
            $db3 = $this->deklarModel->satuID($ntabel, $db4[0]->induk_id, '', 'id');
            $ceklev3 = $this->deklarModel->cekAnggaran($idunik, $nfield, $nid, $db3[0]->id);
            $total3 = $this->deklarModel->anggaranTotal($idunik, $db3[0]->id, $nfield);
            $this->anggaranModel->save(['id' => $ceklev3[0]->id, 'total' => $total3[0]->subtotal]);
            $this->deklarModel->updateDeletedat('m_anggaran', $ceklev3[0]->id);
            // 
            $db2 = $this->deklarModel->satuID($ntabel, $db3[0]->induk_id, '', 'id');
            $ceklev2 = $this->deklarModel->cekAnggaran($idunik, $nfield, $nid, $db2[0]->id);
            $total2 = $this->deklarModel->anggaranTotal($idunik, $db2[0]->id, $nfield);
            $this->anggaranModel->save(['id' => $ceklev2[0]->id, 'total' => $total2[0]->subtotal]);
            $this->deklarModel->updateDeletedat('m_anggaran', $ceklev2[0]->id);
            // 
            $db1 = $this->deklarModel->satuID($ntabel, $db2[0]->induk_id, '', 'id');
            $ceklev1 = $this->deklarModel->cekAnggaran($idunik, $nfield, $nid, $db1[0]->id);
            $total1 = $this->deklarModel->anggaranTotal($idunik, $db1[0]->id, $nfield);
            $this->anggaranModel->save(['id' => $ceklev1[0]->id, 'total' => $total1[0]->subtotal]);
            $this->deklarModel->updateDeletedat('m_anggaran', $ceklev1[0]->id);

            $msg = ['sukses' => $this->request->getVar('kode') . ' ' . lang("app.judulhapus")];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
