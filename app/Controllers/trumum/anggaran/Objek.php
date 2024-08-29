<?php

namespace App\Controllers\trumum\anggaran;

use Config\App;
use App\Controllers\BaseController;
use App\Models\trumum\AnggaranindukModel;
use App\Models\trumum\AnggarananakModel;

class Objek extends BaseController
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
        // (!preg_match("/153/i", $this->session->menu->menu_1)) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $data = [
            't_menu' => lang("app.tt_anggaranobjek"), 't_submenu' => '',
            't_icon' => '<i class="fa fa-book ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-book"></i>', 't_dir1' => lang("app.anggaran"), 't_dirac' => lang("app.tujuan"), 't_link' => '/anggobjek',
            'menu' => 'anggobjek', 'whid' => 'hidden', 'dhid' => '', 'phid' => '', 'thid' => '', 'baru' => '',
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
        return redirect()->to('/anggobjek/input/' . $idu);
    }

    // ____________________________________________________________________________________________________________________________
    public function showdata($idunik)
    {
        // (!preg_match("/153/i", $this->session->menu->menu_1)) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $db1 = $this->deklarModel->satuID('anggaran_induk', $idunik);
        $beban = ($db1 ? 'm_' . $db1[0]->tujuan : 'm_proyek');
        $data = [
            't_menu' => lang("app.tt_anggaranobjek"), 't_submenu' => '',
            't_icon' => '<i class="fa fa-book ' . lang("app.xinput") . '"></i>',
            't_diricon' => '<i class="fa fa-book"></i>', 't_dir1' => lang("app.anggaran"), 't_dirac' => lang("app.tujuan"), 't_link' => '/anggobjek',
            'idu' => $this->iduModel->cekID($idunik), 'idunik' => $idunik,
            'perusahaan' => $this->deklarModel->getPerusahaan('', 't'),
            'wilayah' => $this->deklarModel->getDivisi('', 'wilayah', 't'),
            'divisi' => $this->deklarModel->getDivisi('', 'divisi', 't'),
            'selnama' => $this->deklarModel->distSelect('setanggaran'),
            'selbeban' => $this->deklarModel->distSelect('beban'),
            'kategori' => $this->deklarModel->distBiayalv1('btlangsung'),
            'beban1' => $this->deklarModel->satuID($beban, $db1[0]->beban_id ?? '', '', 'id', 't'),
            'nodoc' => $this->deklarModel->cekForm('dokumen', 'anggaranobjek', 't', '', '', ''),
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
        return view('trumum/anggaran/objek_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function tambahdata()
    {
        if ($this->request->isAJAX()) {
            $rule_akses = ($this->request->getVar('iduser') == '' ? 'valid_email' : 'permit_empty');
            $cek = $this->tranModel->cekAnggaraninduk($this->request->getVar('idunik'), $this->request->getVar('xpilih'), $this->request->getVar('xtujuan'), $this->request->getVar('xjenis'), $this->request->getVar('idbeban'), '', $this->request->getVar('noadd'), $this->request->getVar('norev'));
            // $rule_akses = ($cek) ? ($cek[0]->idunik == $this->request->getVar('idunik') ? 'permit_empty' : 'required') : 'permit_empty';
            $tujuan = ($this->request->getVar('xtujuan') == '' ? 'proyek' : $this->request->getVar('xtujuan'));
            if ($tujuan == 'tool') $cekbeban = $this->deklarModel->satuID('m_alat', $this->request->getVar('idbeban'), '', 'id', 't');
            if ($tujuan != 'tool') if (in_array($tujuan, ['proyek', 'camp', 'alat', 'tanah'])) $cekbeban = $this->deklarModel->satuID("m_$tujuan", $this->request->getVar('idbeban'), '', 'id', 't');
            $rule_perusahaan = (($cekbeban && $this->request->getVar('idperusahaan') == $cekbeban[0]->perusahaan_id) ? 'permit_empty' : 'valid_email');
            $rule_wilayah = (($cekbeban && $this->request->getVar('idwilayah') == $cekbeban[0]->wilayah_id) ? 'permit_empty' : 'valid_email');
            $rule_divisi = (($cekbeban && $this->request->getVar('iddivisi') == $cekbeban[0]->divisi_id) ? 'permit_empty' : 'valid_email');
            $rule_pilih = (($tujuan == 'proyek' && $this->request->getVar('xpilih') == 'pendapatan') ? 'valid_email' : 'required');
            $rule_biaya = ($tujuan == 'proyek' ? 'required' : 'permit_empty');
            $rule_akun = ($tujuan == 'proyek' ? 'permit_empty' : 'required');

            $validationRules = [
                'akses' => [
                    'rules' => $rule_akses,
                    'errors' => ['valid_email' => lang("app.errunik2")]
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
                'xpilih' => [
                    'rules' => $rule_pilih,
                    'errors' => ['required' => lang("app.errpilih"), 'valid_email' => lang("app.errunik")]
                ],
                'kodebeban' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
                'biaya' => [
                    'rules' => $rule_biaya,
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'akun' => [
                    'rules' => $rule_akun,
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'total' => [
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
                        'akses' => $this->validation->getError('akses'),
                        'perusahaan' => $this->validation->getError('idperusahaan'),
                        'wilayah' => $this->validation->getError('idwilayah'),
                        'divisi' => $this->validation->getError('iddivisi'),
                        'pilih' => $this->validation->getError('xpilih'),
                        'kodebeban' => $this->validation->getError('kodebeban'),
                        'biaya' => $this->validation->getError('biaya'),
                        'akun' => $this->validation->getError('akun'),
                        'total' => $this->validation->getError('total'),
                        'catatan' => $this->validation->getError('catatan'),
                    ]
                ];
            } else {
                $budinduk1 = $this->deklarModel->satuID('anggaran_induk', $this->request->getVar('idunik'));
                if ($budinduk1) {
                    $nodokumen = $this->request->getVar('nodoc');
                    $this->anggaranindukModel->save(['id' => $budinduk1[0]->id, 'status' => '0', 'is_use' => '0']);
                } else {
                    $db = $this->tranModel->getNomordoc('anggaran_induk', $this->request->getVar('kui'), "-" . substr($this->request->getVar('tanggal1'), 2, 2));
                    $nomor = ($db ? substr($db[0]->nodoc, -4) + 1 : '1');
                    $nodokumen = nodokumen($this->request->getVar('kui'), $this->request->getVar('tanggal1'), $nomor);
                    $this->anggaranindukModel->save([
                        'idunik' =>  $this->request->getVar('idunik'),
                        'pilihan' =>  $this->request->getVar('xpilih'),
                        'tujuan' =>  $this->request->getVar('xtujuan'),
                        'jenis' =>  $this->request->getVar('xjenis'),
                        'perusahaan_id' => $this->request->getVar('idperusahaan'),
                        'wilayah_id' => $this->request->getVar('idwilayah'),
                        'divisi_id' => $this->request->getVar('iddivisi'),
                        'beban_id' => $this->request->getVar('idbeban'),
                        'nodoc' => $nodokumen,
                        'tanggal1' => $this->request->getVar('tanggal1'),
                        'tanggal2' => $this->request->getVar('tanggal2'),
                        'adendum' => $this->request->getVar('noadd'),
                        'revisi' => $this->request->getVar('norev'),
                        'status' => '0',
                    ]);
                }
                $induk1 = $this->deklarModel->satuID('anggaran_induk', $this->request->getVar('idunik'));
                $addrev = $induk1[0]->adendum . "." . $induk1[0]->revisi;
                $this->anggarananakModel->save([
                    'anggaraninduk_id' => $induk1[0]->id,
                    'biaya_id' => $this->request->getVar('biaya'),
                    'akun_id' => $this->request->getVar('akun'),
                    'bulan' => ubahSeparator($this->request->getVar('bulan')),
                    'jumlah_cco' => ubahSeparator($this->request->getVar('jumlah')),
                    'harga_kontrak_cco' => ubahSeparator($this->request->getVar('harga')),
                    'total_kontrak_cco' => ubahSeparator($this->request->getVar('total')),
                    'catatan' => $this->request->getVar('catatan'),
                ]);

                $nfield = ($tujuan == 'proyek' ? 'biaya' : 'akun');
                $nid = ($tujuan == 'proyek' ? 'biaya_id' : 'akun_id');
                $db4 = $this->deklarModel->getIndukbiaya($nfield, $this->request->getVar($nfield));
                $ceklev3 = $this->tranModel->cekAnggarananak($induk1[0]->id, $nid, $db4[0]->idlev3);
                if ($ceklev3) {
                    $total3 = $this->tranModel->getAnggarantotal($induk1[0]->id, $db4[0]->idlev3, $nfield);
                    $this->anggarananakModel->save(['id' => $ceklev3[0]->id, 'total_kontrak_cco' => $total3[0]->totalkontrakcco]);
                    $this->deklarModel->updateDeletedat('anggaran_anak', $ceklev3[0]->id);
                } else {
                    $this->anggarananakModel->save([
                        'anggaraninduk_id' => $induk1[0]->id,
                        $nid => $db4[0]->idlev3,
                        'total_kontrak_cco' => ubahSeparator($this->request->getVar('total')),
                    ]);
                }

                $ceklev2 = $this->tranModel->cekAnggarananak($induk1[0]->id, $nid, $db4[0]->idlev2);
                if ($ceklev2) {
                    $total2 = $this->tranModel->getAnggarantotal($induk1[0]->id, $db4[0]->idlev2, $nfield);
                    $this->anggarananakModel->save(['id' => $ceklev2[0]->id, 'total_kontrak_cco' => $total2[0]->totalkontrakcco]);
                    $this->deklarModel->updateDeletedat('anggaran_anak', $ceklev2[0]->id);
                } else {
                    $this->anggarananakModel->save([
                        'anggaraninduk_id' => $induk1[0]->id,
                        $nid => $db4[0]->idlev2,
                        'total_kontrak_cco' => ubahSeparator($this->request->getVar('total')),
                    ]);
                }

                $ceklev1 = $this->tranModel->cekAnggarananak($induk1[0]->id, $nid, $db4[0]->idlev1);
                if ($ceklev1) {
                    $total1 = $this->tranModel->getAnggarantotal($induk1[0]->id, $db4[0]->idlev1, $nfield);
                    $this->anggarananakModel->save(['id' => $ceklev1[0]->id, 'total_kontrak_cco' => $total1[0]->totalkontrakcco]);
                    $this->deklarModel->updateDeletedat('anggaran_anak', $ceklev1[0]->id);
                } else {
                    $this->anggarananakModel->save([
                        'anggaraninduk_id' => $induk1[0]->id,
                        $nid => $db4[0]->idlev1,
                        'total_kontrak_cco' => ubahSeparator($this->request->getVar('total')),
                        'levsatu' => '1',
                    ]);
                }
                $msg = ['sukses' => "{$nodokumen} => {$db4[0]->nama}" . lang('app.judultambah'), 'nodoc' => $nodokumen, 'revisi' => $addrev, 'stat' => lang('app.baru')];
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

            $indukby = $this->deklarModel->getIndukakun($anak[0]->akun_id);
            $dblev3 = $this->tranModel->cekAnggarananak('akun_id', $anak[0]->anggaraninduk_id, $indukby[0]->idlev3);
            $total3 = $this->tranModel->getAnggarantotal($anak[0]->anggaraninduk_id, $indukby[0]->idlev3, 'akun');
            if (empty($total3)) {
                $this->anggarananakModel->delete($dblev3[0]->id);
            } else {
                $this->anggarananakModel->save([
                    'id' => $dblev3[0]->id,
                    'total_kontrak_cco' => $total3[0]->totkontraktcco,
                ]);
            }

            $dblev2 = $this->tranModel->cekAnggarananak('akun_id', $anak[0]->anggaraninduk_id, $indukby[0]->idlev2);
            $total2 = $this->tranModel->getAnggarantotal($anak[0]->anggaraninduk_id, $indukby[0]->idlev2, 'akun');
            if (empty($total2)) {
                $this->anggarananakModel->delete($dblev2[0]->id);
            } else {
                $this->anggarananakModel->save([
                    'id' => $dblev2[0]->id,
                    'total_kontrak_cco' => $total2[0]->totkontrakcco,
                ]);
            }

            $dblev1 = $this->tranModel->cekAnggarananak('akun_id', $anak[0]->anggaraninduk_id, $indukby[0]->idlev1);
            $total1 = $this->tranModel->getAnggarantotal($anak[0]->anggaraninduk_id, $indukby[0]->idlev1, 'akun');
            $this->anggarananakModel->save([
                'id' => $dblev1[0]->id,
                'total_kontrak_cco' => $total1[0]->totkontrakcco,
            ]);
            $msg = ['sukses' => $this->request->getVar('kode') . " " . lang("app.judulhapus")];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function savedokumen()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->deklarModel->satuID('anggaran_induk', $this->request->getVar('idunik'));
            $rule_akses = ($db1 ? ($this->request->getVar('kodedoc') == '' ? 'valid_email' : 'permit_empty') : 'required');

            // $cek = $this->tranModel->cekBudgetinduk($this->request->getVar('pilih'), $this->request->getVar('tujuan'), $this->request->getVar('beban'), '', $this->request->getVar('noadd'), $this->request->getVar('norev'));
            $validationRules = [
                'akses' => [
                    'rules' => $rule_akses,
                    'errors' => ['required' => lang("app.errunik4"), 'valid_email' => lang("app.errunik5")]
                ],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'akses' => $this->validation->getError('akses'),
                    ]
                ];
            } else {
                $nomordokumen = $this->request->getVar('nodoc');
                if ($nomordokumen == '') {
                    $dbdoc = $this->tranModel->getNomordoc('anggaran_induk', $this->request->getVar('awal'), "-" . substr($this->request->getVar('tanggal1'), 2, 2));
                    $nomor = (empty($dbdoc[0]->nodoc)) ? "1" : substr($dbdoc[0]->nodoc, -4) + 1;
                    $nomordokumen = nodokumen($this->request->getVar('awal'), $this->request->getVar('tanggal1'), $nomor);
                };

                $this->anggaranindukModel->save([
                    'id' =>  $db1[0]->id,
                    'userid' => $this->user['kode'],
                    'level_aw' => $this->user['acc_setuju'],
                    'level_pos' => $this->user['acc_setuju'],
                    'level_acc' => $this->levacc,
                    'nodoc' =>  $nomordokumen,
                    'tanggal1' =>  $this->request->getVar('tanggal1'),
                    'tanggal2' =>  $this->request->getVar('tanggal2'),
                    'st_confirm' => '1', //sudah disave
                ]);
                $this->logModel->saveLog('Save', '1', $this->request->getVar('idunik'), $nomordokumen);
                $msg = ['sukses' => $this->request->getVar('idunik') . " " . lang("app.judulsimpan"), 'nomordoc' => $nomordokumen];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function loadbudgetbawaan()
    {
        if ($this->request->isAJAX()) {
            $satu = $this->deklarModel->satuID('anggaran_induk', $this->request->getVar('idunik'));
            if (empty($satu)) {
                // $cekproyek = $this->deklarModel->satuID('m_proyek', $this->request->getVar('idproyek'), 'id', 't');

                $validationRules = [
                    'idperusahaan' => [
                        'rules' => 'required',
                        'errors' => ['required' => lang("app.errpilih")]
                    ],
                    'idwilayah' => [
                        'rules' => 'required',
                        'errors' => ['required' => lang("app.errpilih")]
                    ],
                    'iddivisi' => [
                        'rules' => 'required',
                        'errors' => ['required' => lang("app.errpilih")]
                    ],
                    'pilih' => [
                        'rules' => 'required',
                        'errors' => ['required' => lang("app.errpilih")]
                    ],
                    'kodebeban' => [
                        'rules' => 'required',
                        'errors' => ['required' => lang("app.errblank")]
                    ],
                ];

                if (!$this->validate($validationRules)) {
                    $msg = [
                        'error' => [
                            'perusahaan' => $this->validation->getError('idperusahaan'),
                            'wilayah' => $this->validation->getError('idwilayah'),
                            'divisi' => $this->validation->getError('iddivisi'),
                            'pilih' => $this->validation->getError('pilih'),
                            'kodebeban' => $this->validation->getError('kodebeban'),
                        ]
                    ];
                } else {
                    $db = $this->deklarModel->getAnggaran('', '0', '', $this->request->getVar('xtujuan'), $this->request->getVar('xpilih'));
                    $this->anggaranindukModel->save([
                        'idunik' =>  $this->request->getVar('idunik'),
                        'pilihan' =>  $this->request->getVar('xpilih'),
                        'tujuan' =>  $this->request->getVar('xtujuan'),
                        'perusahaan_id' => $this->request->getVar('idperusahaan'),
                        'wilayah_id' => $this->request->getVar('idwilayah'),
                        'divisi_id' => $this->request->getVar('iddivisi'),
                        'beban_id' => $this->request->getVar('idbeban'),
                        'tanggal1' => $this->request->getVar('tanggal1'),
                        'tanggal2' => $this->request->getVar('tanggal2'),
                        'noadendum' => $this->request->getVar('noadd'),
                        'norevisi' => $this->request->getVar('norev'),
                    ]);

                    $idinduk = $this->deklarModel->satuID('anggaran_induk', $this->request->getVar('idunik'));
                    foreach ($db as $item) {
                        $this->anggarananakModel->save([
                            'anggaraninduk_id' => $idinduk[0]->id,
                            'akun_id' => $item->akun_id,
                            'bulan' => $item->bulan,
                            'jumlah_cco' => $item->jumlah,
                            'harga_kontrak_cco' => $item->harga,
                            'total_kontrak_cco' => $item->total,
                            'catatan' => $item->catatan,
                        ]);
                    }
                    $msg = ['sukses' => lang("app.panggilanggaran")];
                }
            } else { //jika suda ada data
                $msg = ['ada' => lang("app.errunik2")];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
