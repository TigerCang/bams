<?php

namespace App\Controllers\proyek\anggaran;

use Config\App;
use App\Controllers\BaseController;
use App\Models\umum\AnggaranindukModel;
use App\Models\umum\AnggarananakModel;

class BiayaTL extends BaseController
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
        (!preg_match("/119/i", $this->menu['menu_1'])) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $data = [
            't_menu' => lang("app.tt_anggaranbtl"), 't_submenu' => '',
            't_icon' => '<i class="fa fa-book ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-book"></i>', 't_dir1' => lang("app.anggaran"), 't_dirac' => lang("app.biayatl"), 't_link' => '/anggproyekbtl',
            'perusahaan' => $this->deklarModel->getPerusahaan('', 't'),
            'wilayah' => $this->deklarModel->getDivisi('', 'wilayah', 't'),
            'menu' => 'anggproyekbtl', 'asal' => 'btl',
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        return view('proyek/anggaran/biayaproyek_view', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function crany()
    {
        do {
            $idu = buatid(60);
            $db = $this->deklarModel->satuID('anggaran_induk', $idu);
        } while ($db);
        $this->iduModel->saveID($idu);
        return redirect()->to('/anggproyekbtl/input/' . $idu);
    }

    // ____________________________________________________________________________________________________________________________
    public function showdata($idunik)
    {
        // (!preg_match("/122/i", $this->session->menu->menu_1)) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $db1 = $this->deklarModel->satuID('anggaran_induk', $idunik);
        $data = [
            't_menu' => lang("app.tt_anggaranbtl"), 't_submenu' => '',
            't_icon' => '<i class="fa fa-book ' . lang("app.xinput") . '"></i>',
            't_diricon' => '<i class="fa fa-book"></i>', 't_dir1' => lang("app.anggaran"), 't_dirac' => lang("app.biayatl"), 't_link' => '/anggproyekbtl',
            'idu' => $this->iduModel->cekID($idunik), 'idunik' => $idunik,
            'perusahaan' => $this->deklarModel->getPerusahaan('', 't'),
            'wilayah' => $this->deklarModel->getDivisi('', 'wilayah', 't'),
            'divisi' => $this->deklarModel->getDivisi('', 'divisi', 't', 't'),
            'proyek1' => $this->deklarModel->satuID('m_proyek', $db1['0']->tujuan_id ?? '', 'id'),
            'kodedoc' => $this->deklarModel->cekForm('dokumen', 'anggaranproyek', 't'),
            'asal' => 'btl',
            'anggaran' => $db1,
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        ((empty($data['anggaran'])) && (empty($data['idu']))) && throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($data['anggaran']) {
            if (($this->user['akses_proyek'] == "0") && (!preg_match("/," . $data['anggaran']['0']->proyek_id . ",/i", $this->user['proyek']))) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        }
        if ($data['proyek1']) {
            if (($this->user['akses_perusahaan'] == "0") && (!preg_match("/," . $data['proyek1']['0']->perusahaan_id . ",/i", $this->user['perusahaan']))) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
            if (($this->user['akses_wilayah'] == "0") && (!preg_match("/," . $data['proyek1']['0']->wilayah_id . ",/i", $this->user['wilayah']))) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
            if (($this->user['akses_divisi'] == "0") && (!preg_match("/," . $data['proyek1']['0']->divisi_id . ",/i", $this->user['divisi']))) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        }
        if ($db1) $this->logModel->saveLog('Read', '0', $idunik, $db1['0']->nodoc);
        return view('proyek/anggaran/biayaproyektl_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function tambahdata()
    {
        if ($this->request->isAJAX()) {
            $cek = $this->tranModel->cekBudgetinduk('btl', '', $this->request->getVar('idproyek'), '', $this->request->getVar('noadd'), $this->request->getVar('norev'));
            $rule_akses = ($cek) ? ($cek['0']->idunik == $this->request->getVar('idunik') ? 'permit_empty' : 'required') : 'permit_empty';
            $cekproyek = $this->deklarModel->satuID('m_proyek', $this->request->getVar('idproyek'), 'id', 't');
            $rule_perusahaan = ($cekproyek ? ($this->request->getVar('idperusahaan') == $cekproyek['0']->perusahaan_id ? 'required' : 'valid_email') : 'required');
            $rule_wilayah = ($cekproyek ? ($this->request->getVar('idwilayah') == $cekproyek['0']->wilayah_id ? 'required' : 'valid_email') : 'required');
            $rule_divisi = ($cekproyek ? ($this->request->getVar('iddivisi') == $cekproyek['0']->divisi_id ? 'required' : 'valid_email') : 'required');

            $validationRules = [
                'akses' => [
                    'rules' => $rule_akses,
                    'errors' => ['required' => lang("app.errunik2")]
                ],
                'idperusahaan' => [
                    'rules' => $rule_perusahaan,
                    'errors' => ['required' => lang("app.errpilih"), 'valid_email' => lang("app.errunik3")]
                ],
                'idwilayah' => [
                    'rules' => $rule_wilayah,
                    'errors' => ['required' => lang("app.errpilih"), 'valid_email' => lang("app.errunik3")]
                ],
                'iddivisi' => [
                    'rules' => $rule_divisi,
                    'errors' => ['required' => lang("app.errpilih"), 'valid_email' => lang("app.errunik3")]
                ],
                'kodeproyek' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
                'biaya' => [
                    'rules' => 'required',
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
                        'kodeproyek' => $this->validation->getError('kodeproyek'),
                        'biaya' => $this->validation->getError('biaya'),
                        'total' => $this->validation->getError('total'),
                        'catatan' => $this->validation->getError('catatan'),
                    ]
                ];
            } else {
                $budgetinduk1 = $this->deklarModel->satuID('anggaran_induk', $this->request->getVar('idunik'));
                if (empty($budgetinduk1)) {
                    $this->anggaranindukModel->save([
                        'idunik' =>  $this->request->getVar('idunik'),
                        'pilihan' =>  'btl',
                        'tujuan' =>  'proyek',
                        'perusahaan_id' => $this->request->getVar('idperusahaan'),
                        'wilayah_id' => $this->request->getVar('idwilayah'),
                        'divisi_id' => $this->request->getVar('iddivisi'),
                        'tujuan_id' => $this->request->getVar('idproyek'),
                        'userid' => $this->user['kode'],
                        'tanggal1' => $this->request->getVar('tanggal1'),
                        'tanggal2' => $this->request->getVar('tanggal2'),
                        'noadendum' => $this->request->getVar('noadd'),
                        'norevisi' => $this->request->getVar('norev'),
                    ]);
                }

                $idinduk = $this->deklarModel->satuID('anggaran_induk', $this->request->getVar('idunik'));
                $this->anggarananakModel->save([
                    'anggaraninduk_id' => $idinduk['0']->id,
                    'biaya_id' => $this->request->getVar('biaya'),
                    'bulan' => ubahSeparator($this->request->getVar('bulan')),
                    'jumlah_cco' => ubahSeparator($this->request->getVar('jumlah')),
                    'harga_kontrak_cco' => ubahSeparator($this->request->getVar('harga')),
                    'total_kontrak_cco' => ubahSeparator($this->request->getVar('total')),
                    'catatan' => $this->request->getVar('catatan'),
                ]);

                $indukby = $this->deklarModel->getIndukbiaya($this->request->getVar('biaya'), 'btl');
                $dblev3 = $this->tranModel->cekAnggarananak('biaya_id', $idinduk['0']->id, $indukby['0']->idlev3);
                if (empty($dblev3)) {
                    $this->anggarananakModel->save([
                        'anggaraninduk_id' => $idinduk['0']->id,
                        'biaya_id' => $indukby['0']->idlev3,
                        'total_kontrak_cco' => ubahSeparator($this->request->getVar('total')),
                    ]);
                } else {
                    $total3 = $this->tranModel->getAnggarantotal($idinduk['0']->id, $indukby['0']->idlev3, 'biaya');
                    $this->anggarananakModel->save([
                        'id' => $dblev3['0']->id,
                        'total_kontrak_cco' => $total3['0']->totkontrakcco,
                    ]);
                    $this->deklarModel->updateDeletedat('anggaran_anak', $dblev3['0']->id);
                }

                $dblev2 = $this->tranModel->cekAnggarananak('biaya_id', $idinduk['0']->id, $indukby['0']->idlev2);
                if (empty($dblev2)) {
                    $this->anggarananakModel->save([
                        'anggaraninduk_id' => $idinduk['0']->id,
                        'biaya_id' => $indukby['0']->idlev2,
                        'total_kontrak_cco' => ubahSeparator($this->request->getVar('total')),
                    ]);
                } else {
                    $total2 = $this->tranModel->getAnggarantotal($idinduk['0']->id, $indukby['0']->idlev2, 'biaya');
                    $this->anggarananakModel->save([
                        'id' => $dblev2['0']->id,
                        'total_kontrak_cco' => $total2['0']->totkontrakcco,
                    ]);
                    $this->deklarModel->updateDeletedat('anggaran_anak', $dblev2['0']->id);
                }

                $dblev1 = $this->tranModel->cekAnggarananak('biaya_id', $idinduk['0']->id, $indukby['0']->idlev1);
                if (empty($dblev1)) {
                    $this->anggarananakModel->save([
                        'anggaraninduk_id' => $idinduk['0']->id,
                        'biaya_id' => $indukby['0']->idlev1,
                        'total_kontrak_cco' => ubahSeparator($this->request->getVar('total')),
                    ]);
                } else {
                    $total1 = $this->tranModel->getAnggarantotal($idinduk['0']->id, $indukby['0']->idlev1, 'biaya');
                    $this->anggarananakModel->save([
                        'id' => $dblev1['0']->id,
                        'total_kontrak_cco' => $total1['0']->totkontrakcco,
                    ]);
                    $this->deklarModel->updateDeletedat('anggaran_anak', $dblev1['0']->id);
                }
                $biaya1 = $this->deklarModel->satuID('m_biaya', $this->request->getVar('biaya'), 'id');
                $this->logModel->saveLog('Add', '1', $this->request->getVar('idunik'), $biaya1['0']->kode);
                $msg = ['sukses' => $indukby['0']->kode . " " . lang("app.judultambah")];
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

            $indukby = $this->deklarModel->getIndukbiaya($anak['0']->biaya_id, 'btl');
            $dblev3 = $this->tranModel->cekAnggarananak('biaya_id', $anak['0']->anggaraninduk_id, $indukby['0']->idlev3);
            $total3 = $this->tranModel->getAnggarantotal($anak['0']->anggaraninduk_id, $indukby['0']->idlev3, 'biaya');
            if (empty($total3)) {
                $this->anggarananakModel->delete($dblev3['0']->id);
            } else {
                $this->anggarananakModel->save([
                    'id' => $dblev3['0']->id,
                    'total_kontrak_cco' => $total3['0']->totkontrakcco,
                ]);
            }

            $dblev2 = $this->tranModel->cekAnggarananak('biaya_id', $anak['0']->anggaraninduk_id, $indukby['0']->idlev2);
            $total2 = $this->tranModel->getAnggarantotal($anak['0']->anggaraninduk_id, $indukby['0']->idlev2, 'biaya');
            if (empty($total2)) {
                $this->anggarananakModel->delete($dblev2['0']->id);
            } else {
                $this->anggarananakModel->save([
                    'id' => $dblev2['0']->id,
                    'total_kontrak_cco' => $total2['0']->totkontrakcco,
                ]);
            }

            $dblev1 = $this->tranModel->cekAnggarananak('biaya_id', $anak['0']->anggaraninduk_id, $indukby['0']->idlev1);
            $total1 = $this->tranModel->getAnggarantotal($anak['0']->anggaraninduk_id, $indukby['0']->idlev1, 'biaya');
            $this->anggarananakModel->save([
                'id' => $dblev1['0']->id,
                'total_kontrak_cco' => $total1['0']->totkontrakcco,
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
                    $nomor = (empty($dbdoc['0']->nodoc)) ? "1" : substr($dbdoc['0']->nodoc, -4) + 1;
                    $nomordokumen = nodokumen($this->request->getVar('awal'), $this->request->getVar('tanggal1'), $nomor);
                };
                $this->anggaranindukModel->save([
                    'id' =>  $db1['0']->id,
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
                $cekproyek = $this->deklarModel->satuID('m_proyek', $this->request->getVar('idproyek'), 'id', 't');

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
                    'kodeproyek' => [
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
                            'kodeproyek' => $this->validation->getError('kodeproyek'),
                        ]
                    ];
                } else {
                    $db = $this->deklarModel->getAnggaran('', '0', '', $this->request->getVar('tujuan'), $this->request->getVar('pilihan'));
                    $this->anggaranindukModel->save([
                        'idunik' =>  $this->request->getVar('idunik'),
                        'pilihan' =>  'btl',
                        'tujuan' =>  'proyek',
                        'perusahaan_id' => $this->request->getVar('idperusahaan'),
                        'wilayah_id' => $this->request->getVar('idwilayah'),
                        'divisi_id' => $this->request->getVar('iddivisi'),
                        'tujuan_id' => $this->request->getVar('idproyek'),
                        'tanggal1' => $this->request->getVar('tanggal1'),
                        'tanggal2' => $this->request->getVar('tanggal2'),
                        'noadendum' => $this->request->getVar('noadd'),
                        'norevisi' => $this->request->getVar('norev'),
                    ]);

                    $idinduk = $this->deklarModel->satuID('anggaran_induk', $this->request->getVar('idunik'));
                    foreach ($db as $item) {
                        $this->anggarananakModel->save([
                            'anggaraninduk_id' => $idinduk['0']->id,
                            'biaya_id' => $item->biaya_id,
                            'bulan' => $item->bulan,
                            'jumlah_kontrak' => $item->jumlah,
                            'harga_kontrak' => $item->harga,
                            'total_kontrak' => $item->total,
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
