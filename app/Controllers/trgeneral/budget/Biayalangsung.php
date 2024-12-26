<?php

namespace App\Controllers\trumum\anggaran;

use Config\App;
use App\Controllers\BaseController;
use App\Models\trumum\AnggaranindukModel;
use App\Models\trumum\AnggarananakModel;

class Biayalangsung extends BaseController
{
    protected $anggaranindukModel;
    protected $anggarananakModel;
    public function __construct()
    {
        $this->anggaranindukModel = new AnggaranindukModel();
        $this->anggarananakModel = new AnggarananakModel();
    }

    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        // (!preg_match("/119/i", $this->menu['menu_1'])) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $data = [
            't_menu' => lang("app.tt_anggaranbl"), 't_submenu' => '',
            't_icon' => '<i class="fa fa-book ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-book"></i>', 't_dir1' => lang("app.anggaran"), 't_dirac' => lang("app.biayal"), 't_link' => '/anggbiayal',
            'menu' => 'anggbiayal', 'whid' => '', 'dhid' => 'hidden', 'phid' => 'hidden', 'thid' => 'hidden', 'baru' => '',
            'perusahaan' => $this->deklarModel->getPerusahaan('', 't'),
            'divisi' => $this->deklarModel->getDivisi('', 'divisi', 't'),
            'wilayah' => $this->deklarModel->getDivisi('', 'wilayah', 't'),
            'selnama' => $this->deklarModel->distSelect('setanggaran'),
            'selbeban' => $this->deklarModel->distSelect('beban'),
            'btnclascr' => lang('app.btncCreate'), 'btntextcr' => lang('app.btnCreate'),
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        return view('trumum/anggaran/anggaran_view', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function crany()
    {
        do {
            $idu = buatid(60);
            $db = $this->deklarModel->satuID('anggaran_induk', $idu);
        } while ($db);
        $this->iduModel->saveID($idu);
        return redirect()->to('/anggbiayal/input/' . $idu);
    }

    // ____________________________________________________________________________________________________________________________
    public function showdata($idunik)
    {
        // (!preg_match("/122/i", $this->session->menu->menu_1)) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $db1 = $this->deklarModel->satuID('anggaran_induk', $idunik);
        $data = [
            't_menu' => lang("app.tt_anggaranbl"), 't_submenu' => '',
            't_icon' => '<i class="fa fa-book ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-book"></i>', 't_dir1' => lang("app.anggaran"), 't_dirac' => lang("app.biayal"), 't_link' => '/anggbiayal',
            'idu' => $this->iduModel->cekID($idunik), 'idunik' => $idunik,
            'perusahaan' => $this->deklarModel->getPerusahaan('', 't'),
            'wilayah' => $this->deklarModel->getDivisi('', 'wilayah', 't'),
            'divisi' => $this->deklarModel->getDivisi('', 'divisi', 't', 't'),
            'selnama' => $this->deklarModel->distSelect('kelin'),
            'proyek1' => $this->deklarModel->satuID('m_proyek', $db1[0]->beban_id ?? '', '', 'id', 't'),
            'ruas1' => $this->deklarModel->satuID('m_ruas', $db1[0]->ruas_id ?? '', '', 'id', 't'),
            'nodoc' => $this->deklarModel->cekForm('dokumen', 'anggaranproyek', 't', '', '', ''),
            'anggaran' => $db1,
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        (empty($data['anggaran']) && empty($data['idu'])) && throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($data['anggaran']) {
            if ($this->user['act_perusahaan'] == "0" && !preg_match("/," . $data['anggaran'][0]->perusahaan_id . ",/i", $this->user['perusahaan'])) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
            if ($this->user['act_wilayah'] == "0" && !preg_match("/," . $data['anggaran'][0]->wilayah_id . ",/i", $this->user['wilayah'])) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
            if ($this->user['act_divisi'] == "0" && !preg_match("/," . $data['anggaran'][0]->divisi_id . ",/i", $this->user['divisi'])) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        }
        if ($db1) $this->logModel->saveLog('Read', $idunik, $db1[0]->nodoc, '-');
        return view('trumum/anggaran/biayal_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function tambahdata()
    {
        if ($this->request->isAJAX()) {
            $idruas = ($this->request->getVar('idruas') != '') ? $this->request->getVar('idruas') : '-';
            $cek = $this->tranModel->cekAnggaraninduk('pengeluaran', 'proyek', '', $this->request->getVar('idproyek'), $idruas, $this->request->getVar('noadd'), $this->request->getVar('norev'));
            $rule_akses = ($cek ? ($cek[0]->idunik == $this->request->getVar('idunik') ? 'permit_empty' : 'valid_email') : 'permit_empty');
            $cekproyek = $this->deklarModel->satuID('m_proyek', $this->request->getVar('idproyek'), '', 'id', 't');
            $rule_perusahaan = (($cekproyek && $this->request->getVar('idperusahaan') == $cekproyek[0]->perusahaan_id) ? 'permit_empty' : 'valid_email');
            $rule_wilayah = (($cekproyek && $this->request->getVar('idwilayah') == $cekproyek[0]->wilayah_id) ? 'permit_empty' : 'valid_email');
            $rule_divisi = (($cekproyek && $this->request->getVar('iddivisi') == $cekproyek[0]->divisi_id) ? 'permit_empty' : 'valid_email');

            $validationRules = [
                'akses' => [
                    'rules' => $rule_akses,
                    'errors' => ['valid_email' => lang("app.errnoakses")]
                ],
                'idperusahaan' => [
                    'rules' => $rule_perusahaan,
                    'errors' => ['valid_email' => lang("app.errunik")]
                ],
                'idwilayah' => [
                    'rules' => $rule_wilayah,
                    'errors' => ['valid_email' => lang("app.errunik")]
                ],
                'iddivisi' => [
                    'rules' => $rule_divisi,
                    'errors' => ['valid_email' => lang("app.errunik")]
                ],
                'kodeproyek' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
                'idruas' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'biaya' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'totalkontrak' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
                'totalkerja' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
                'kelin' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'catatan' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'akses' => $this->validation->getError('akses'),
                        'perusahaan' => $this->validation->getError('idperusahaan'),
                        'wilayah' => $this->validation->getError('idwilayah'),
                        'divisi' => $this->validation->getError('iddivisi'),
                        'kodeproyek' => $this->validation->getError('kodeproyek'),
                        'ruas' => $this->validation->getError('idruas'),
                        'biaya' => $this->validation->getError('biaya'),
                        'totalkontrak' => $this->validation->getError('totalkontrak'),
                        'totalkerja' => $this->validation->getError('totalkerja'),
                        'kelin' => $this->validation->getError('kelin'),
                        'catatan' => $this->validation->getError('catatan'),
                    ]
                ];
            } else {
                $budinduk1 = $this->deklarModel->satuID('anggaran_induk', $this->request->getVar('idunik'));
                $nodokumen = $this->request->getVar('nodoc');
                if ($budinduk1) {
                    $this->anggaranindukModel->save([
                        'id' => $budinduk1[0]->id,
                        'perusahaan_id' => $this->request->getVar('idperusahaan'),
                        'wilayah_id' => $this->request->getVar('idwilayah'),
                        'divisi_id' => $this->request->getVar('iddivisi'),
                        'beban_id' => $this->request->getVar('idproyek'),
                        'ruas_id' => $this->request->getVar('idruas'),
                        'status' => '0',
                        'is_use' => '0',
                    ]);
                } else {
                    // $db = $this->tranModel->getNomordoc('anggaran_induk', $this->request->getVar('kui'), "-" . substr($this->request->getVar('tanggal1'), 2, 2));
                    // $nomor = ($db ? substr($db[0]->nodoc, -4) + 1 : '1');
                    // $nodokumen = nodokumen($this->request->getVar('kui'), $this->request->getVar('tanggal1'), $nomor);
                    $this->anggaranindukModel->save([
                        'idunik' =>  $this->request->getVar('idunik'),
                        'pilihan' =>  'pengeluaran',
                        'tujuan' =>  'proyek',
                        'perusahaan_id' => $this->request->getVar('idperusahaan'),
                        'wilayah_id' => $this->request->getVar('idwilayah'),
                        'divisi_id' => $this->request->getVar('iddivisi'),
                        'beban_id' => $this->request->getVar('idproyek'),
                        'ruas_id' => $this->request->getVar('idruas'),
                        'tanggal1' => $this->request->getVar('tanggal1'),
                        'tanggal2' => $this->request->getVar('tanggal2'),
                        'status' => '0',
                    ]);
                }
                $induk1 = $this->deklarModel->satuID('anggaran_induk', $this->request->getVar('idunik'));
                // $addrev = $induk1[0]->adendum . "." . $induk1[0]->revisi;
                $this->anggarananakModel->save([
                    'anggaraninduk_id' => $induk1[0]->id,
                    'biaya_id' => $this->request->getVar('biaya'),
                    'jumlah_kontrak' => ubahSeparator($this->request->getVar('jumlah')),
                    'jumlah_cco' => ubahSeparator($this->request->getVar('jumlah')),
                    'harga_kontrak' => ubahSeparator($this->request->getVar('hgkontrak')),
                    'harga_kerja' => ubahSeparator($this->request->getVar('hgkerja')),
                    'total_kontrak' => ubahSeparator($this->request->getVar('totalkontrak')),
                    'total_kerja' => ubahSeparator($this->request->getVar('totalkerja')),
                    'harga_kontrak_cco' => ubahSeparator($this->request->getVar('hgkontrak')),
                    'harga_kerja_cco' => ubahSeparator($this->request->getVar('hgkerja')),
                    'total_kontrak_cco' => ubahSeparator($this->request->getVar('totalkontrak')),
                    'total_kerja_cco' => ubahSeparator($this->request->getVar('totalkerja')),
                    'kelin' => $this->request->getVar('kelin'),
                    'catatan' => $this->request->getVar('catatan'),
                ]);

                $db3 = $this->deklarModel->getIndukbiaya('bl', $this->request->getVar('biaya'));
                $ceklev2 = $this->tranModel->cekAnggarananak($induk1[0]->id, 'biaya_id', $db3[0]->idlev2);
                if ($ceklev2) {
                    $total2 = $this->tranModel->getAnggarantotal($induk1[0]->id, $db3[0]->idlev2, 'biaya');
                    $this->anggarananakModel->save([
                        'id' => $ceklev2[0]->id,
                        'total_kontrak' => $total2[0]->totalkontrak,
                        'total_kerja' => $total2[0]->totalkerja,
                        'total_kontrak_cco' => $total2[0]->totalkontrakcco,
                        'total_kerja_cco' => $total2[0]->totalkerjacco,
                    ]);
                    $this->deklarModel->updateDeletedat('anggaran_anak', $ceklev2[0]->id);
                } else {
                    $this->anggarananakModel->save([
                        'anggaraninduk_id' => $induk1[0]->id,
                        'biaya_id' => $db3[0]->idlev2,
                        'total_kontrak' => ubahSeparator($this->request->getVar('totalkontrak')),
                        'total_kerja' => ubahSeparator($this->request->getVar('totalkerja')),
                        'total_kontrak_cco' => ubahSeparator($this->request->getVar('totalkontrak')),
                        'total_kerja_cco' => ubahSeparator($this->request->getVar('totalkerja')),
                    ]);
                }

                $ceklev1 = $this->tranModel->cekAnggarananak($induk1[0]->id, 'biaya_id', $db3[0]->idlev1);
                if ($ceklev1) {
                    $total1 = $this->tranModel->getAnggarantotal($induk1[0]->id, $db3[0]->idlev1, 'biaya');
                    $this->anggarananakModel->save([
                        'id' => $ceklev1[0]->id,
                        'total_kontrak' => $total1[0]->totalkontrak,
                        'total_kerja' => $total1[0]->totalkerja,
                        'total_kontrak_cco' => $total1[0]->totalkontrakcco,
                        'total_kerja_cco' => $total1[0]->totalkerjacco,
                    ]);
                    $this->deklarModel->updateDeletedat('anggaran_anak', $ceklev1[0]->id);
                } else {
                    $this->anggarananakModel->save([
                        'anggaraninduk_id' => $induk1[0]->id,
                        'biaya_id' => $db3[0]->idlev1,
                        'total_kontrak' => ubahSeparator($this->request->getVar('totalkontrak')),
                        'total_kerja' => ubahSeparator($this->request->getVar('totalkerja')),
                        'total_kontrak_cco' => ubahSeparator($this->request->getVar('totalkontrak')),
                        'total_kerja_cco' => ubahSeparator($this->request->getVar('totalkerja')),
                        'levsatu' => '1',
                    ]);
                }
                $msg = ['sukses' => "{$nodokumen} => {$db3[0]->nama}" . lang('app.judultambah'), 'stat' => lang('app.baru')];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function modalbatal()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'anggaran' => $this->deklarModel->satuid('anggaran_induk', $this->request->getVar('idunik')),
                'menu' => 'anggbiayal',
            ];
            $msg = ['data' => view('x-modal/batal_catatan', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function savedata()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->deklarModel->satuID('anggaran_induk', $this->request->getVar('idunik'));
            $idruas = ($this->request->getVar('idruas') != '') ? $this->request->getVar('idruas') : '-';
            $cek = $this->tranModel->cekAnggaraninduk('pengeluaran', 'proyek', '', $this->request->getVar('idproyek'), $idruas, $this->request->getVar('noadd'), $this->request->getVar('norev'));
            $rule_akses = ($cek ? ($cek[0]->idunik == $this->request->getVar('idunik') ? 'permit_empty' : 'valid_email') : 'permit_empty');
            if ($rule_akses == 'permit_empty') $rule_akses = (empty($db1) ? 'required' : ($this->request->getVar('iduser') == '' ? 'valid_url' : 'permit_empty'));
            $cekproyek = $this->deklarModel->satuID('m_proyek', $this->request->getVar('idproyek'), '', 'id', 't');
            $rule_perusahaan = (($cekproyek && $this->request->getVar('idperusahaan') == $cekproyek[0]->perusahaan_id) ? 'permit_empty' : 'valid_email');
            $rule_wilayah = (($cekproyek && $this->request->getVar('idwilayah') == $cekproyek[0]->wilayah_id) ? 'permit_empty' : 'valid_email');
            $rule_divisi = (($cekproyek && $this->request->getVar('iddivisi') == $cekproyek[0]->divisi_id) ? 'permit_empty' : 'valid_email');

            $validationRules = [
                'akses' => [
                    'rules' => $rule_akses,
                    'errors' => ['required' => lang("app.errunik2"), 'valid_email' => lang("app.errnoakses"), 'valid_url' => lang("app.erruserlog")]
                ],
                'idperusahaan' => [
                    'rules' => $rule_perusahaan,
                    'errors' => ['valid_email' => lang("app.errunik")]
                ],
                'idwilayah' => [
                    'rules' => $rule_wilayah,
                    'errors' => ['valid_email' => lang("app.errunik")]
                ],
                'iddivisi' => [
                    'rules' => $rule_divisi,
                    'errors' => ['valid_email' => lang("app.errunik")]
                ],
                'kodeproyek' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
                'idruas' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'akses' => $this->validation->getError('akses'),
                        'perusahaan' => $this->validation->getError('idperusahaan'),
                        'wilayah' => $this->validation->getError('idwilayah'),
                        'divisi' => $this->validation->getError('iddivisi'),
                        'kodeproyek' => $this->validation->getError('kodeproyek'),
                        'ruas' => $this->validation->getError('idruas'),
                    ]
                ];
            } else {
                $nodokumen = $this->request->getVar('nodoc') ?: nodokumen(
                    $this->request->getVar('kui'),
                    $this->request->getVar('tanggal1'),
                    ($db = $this->tranModel->getNomordoc('anggaran_induk', $this->request->getVar('kui'), "-" . substr($this->request->getVar('tanggal1'), 2, 2))) ? substr($db[0]->nodoc, -4) + 1 : '1'
                );
                // if ($this->request->getVar('nodoc') == '') {
                //     $db = $this->tranModel->getNomordoc('anggaran_induk', $this->request->getVar('kui'), "-" . substr($this->request->getVar('tanggal1'), 2, 2));
                //     $nomor = ($db ? substr($db[0]->nodoc, -4) + 1 : '1');
                //     $nodokumen = nodokumen($this->request->getVar('kui'), $this->request->getVar('tanggal1'), $nomor);
                // } else {
                //     $nodokumen = $this->request->getVar('nodoc');
                // }
                $this->anggaranindukModel->save([
                    'id' => $db1[0]->id,
                    'user_id' => $this->request->getVar('user'),
                    'perusahaan_id' => $this->request->getVar('idperusahaan'),
                    'wilayah_id' => $this->request->getVar('idwilayah'),
                    'divisi_id' => $this->request->getVar('iddivisi'),
                    'beban_id' => $this->request->getVar('idproyek'),
                    'ruas_id' => $this->request->getVar('idruas'),
                    'nodoc' => $nodokumen,
                    'tanggal1' => $this->request->getVar('tanggal1'),
                    'tanggal2' => $this->request->getVar('tanggal2'),
                    'adendum' => $this->request->getVar('noadd'),
                    'revisi' => $this->request->getVar('norev'),
                    'level_aw' => $this->request->getVar('level'),
                    'level_pos' => $this->request->getVar('level'),
                    'status' => '1'
                ]);
                $proyek1 = $this->deklarModel->satuID('m_proyek', $db1[0]->beban_id, '', 'id');
                $this->logModel->saveLog('Save', $this->request->getVar('idunik'), $this->request->getVar('nodoc'));
                $this->session->setFlashdata(['judul' => $nodokumen . " " . lang("app.judulsimpan"), 'perus' => $db1[0]->perusahaan_id, 'div' => '', 'wil' => $db1[0]->wilayah_id, 'tujuan' => $db1[0]->tujuan, 'tahun' => $proyek1[0]->periode1]);
                $msg = ['redirect' => '/anggbiayal'];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
    public function canceldata()
    {
        if ($this->request->isAJAX()) {
            $validationRules = [
                'mcatatan' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
            ];
            if (!$this->validate($validationRules)) {
                $msg = ['error' => ['catatan' => $this->validation->getError('mcatatan')]];
            } else {
                $db1 = $this->deklarModel->satuID('anggaran_induk', $this->request->getVar('idunik'));
                $proyek1 = $this->deklarModel->satuID('m_proyek', $db1[0]->beban_id, '', 'id');
                $this->anggaranindukModel->save(['id' => $db1[0]->id, 'status' => '5', 'catatan' => $this->request->getVar('mcatatan')]);
                $this->logModel->saveLog('Cancel', $db1[0]->idunik, $db1[0]->nodoc);
                $this->session->setFlashdata(['judul' => $db1[0]->nodoc . " " . lang("app.judulbatal"), 'perus' => $db1[0]->perusahaan_id, 'wil' => $db1[0]->wilayah_id, 'tujuan' => $db1[0]->tujuan, 'tahun' => $proyek1[0]->periode1]);
                $msg = ['redirect' => '/anggbiayal'];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function deletedata()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $anak = $this->deklarModel->satuID('anggaran_anak', $id, 'id');
            $this->anggarananakModel->delete($id);

            $indukby = $this->deklarModel->getIndukbiaya('bl', $anak[0]->biaya_id);
            $dblev2 = $this->tranModel->cekAnggarananak('biaya_id', $anak[0]->anggaraninduk_id, $indukby[0]->idlev2);
            $total2 = $this->tranModel->getAnggarantotal($anak[0]->anggaraninduk_id, $indukby[0]->idlev2, 'biaya');
            if (empty($total2)) {
                $this->anggarananakModel->delete($dblev2[0]->id);
            } else {
                $this->anggarananakModel->save([
                    'id' => $dblev2[0]->id,
                    'total_kontrak' => $total2[0]->totkontrak,
                    'total_kerja' => $total2[0]->totkerja,
                ]);
            }

            $dblev1 = $this->tranModel->cekAnggarananak('biaya_id', $anak[0]->anggaraninduk_id, $indukby[0]->idlev1);
            $total1 = $this->tranModel->getAnggarantotal($anak[0]->anggaraninduk_id, $indukby[0]->idlev1, 'biaya');
            $this->anggarananakModel->save([
                'id' => $dblev1[0]->id,
                'total_kontrak' => $total1[0]->totkontrak,
                'total_kerja' => $total1[0]->totkerja,
                'levsatu' => '1',
            ]);
            $msg = ['sukses' => $this->request->getVar('kode') . " " . lang("app.judulhapus")];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // // ____________________________________________________________________________________________________________________________
    // public function savedokumen()
    // {
    //     if ($this->request->isAJAX()) {
    //         $db1 = $this->deklarModel->satuID('anggaran_induk', $this->request->getVar('idunik'));
    //         $rule_akses = ($db1 ? ($this->request->getVar('kodedoc') == '' ? 'valid_email' : 'permit_empty') : 'required');

    //         $validationRules = [
    //             'akses' => [
    //                 'rules' => $rule_akses,
    //                 'errors' => ['required' => lang("app.errunik4"), 'valid_email' => lang("app.errunik5")]
    //             ],
    //         ];
    //         if (!$this->validate($validationRules)) {
    //             $msg = [
    //                 'error' => [
    //                     'akses' => $this->validation->getError('akses'),
    //                 ]
    //             ];
    //         } else {
    //             $nomordokumen = $this->request->getVar('nodoc');
    //             if ($nomordokumen == '') {
    //                 $dbdoc = $this->tranModel->getNomordoc('anggaran_induk', $this->request->getVar('awal'), "-" . substr($this->request->getVar('tanggal1'), 2, 2));
    //                 $nomor = (empty($dbdoc[0]->nodoc)) ? "1" : substr($dbdoc[0]->nodoc, -4) + 1;
    //                 $nomordokumen = nodokumen($this->request->getVar('awal'), $this->request->getVar('tanggal1'), $nomor);
    //             };
    //             $this->anggaranindukModel->save([
    //                 'id' =>  $db1[0]->id,
    //                 'userid' => $this->user['kode'],
    //                 'level_aw' => $this->user['acc_setuju'],
    //                 'level_pos' => $this->user['acc_setuju'],
    //                 'level_acc' => $this->levacc,
    //                 'nodoc' =>  $nomordokumen,
    //                 'tanggal1' =>  $this->request->getVar('tanggal1'),
    //                 'tanggal2' =>  $this->request->getVar('tanggal2'),
    //                 'st_confirm' => '1', //sudah disave
    //             ]);
    //             $this->logModel->saveLog('Save', '1', $this->request->getVar('idunik'), $nomordokumen);
    //             $msg = ['sukses' => $this->request->getVar('idunik') . " " . lang("app.judulsimpan"), 'nomordoc' => $nomordokumen];
    //         }
    //         echo json_encode($msg);
    //     } else {
    //         exit('out');
    //     }
    // }

    // ____________________________________________________________________________________________________________________________
    // public function canceldokumen($idunik)
    // {
    //     $db = $this->deklarModel->satuID('budget_induk', $idunik);
    //     if (empty(!$db)) {
    //         $this->budgetindukModel->save([
    //             'id' => $db[0]->id,
    //             'st_confirm' => '4',
    //         ]);

    //         $proyek1 = $this->deklarModel->satuID('m_proyek', $db[0]->proyek_id, 't');
    //         $ruas1 = $this->deklarModel->satuID('m_ruas', $db[0]->ruas_id, 't');
    //         $this->logModel->saveLog('/budgetbiayal', $db[0]->id, 'Cancel', $proyek1[0]->kode . ' => ' . $ruas1[0]->kode);
    //         $this->session->setflashdata(['judul' => $proyek1[0]->kode . ' => ' . $ruas1[0]->kode . ' ' . lang("app.judulbatal"), 'perus' => $proyek1[0]->perusahaan_id, 'wil' => $proyek1[0]->wilayah_id, 'tahun' => $proyek1[0]->periode1]);
    //     }
    //     return redirect()->to('/budgetbiayal');
    // }
}
