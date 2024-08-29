<?php

namespace App\Controllers\kas;

// defined('BASEPATH') or exit('No direct script access allowed');

use Config\App;
use App\Controllers\BaseController;
use App\Models\kas\KasindukModel;
use App\Models\kas\KasanakModel;
use App\Models\kas\KasdetilModel;

class Kasnonlangsung extends BaseController
{
    protected $kasindukModel;
    protected $kasanakModel;
    protected $kasdetilModel;

    public function __construct()
    {
        $this->kasindukModel = new KasindukModel();
        $this->kasanakModel = new KasanakModel();
        $this->kasdetilModel = new KasdetilModel();
    }

    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        // if (!preg_match("/122/i", session()->menu->menu_1))
        //     throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();

        $data = [
            't_menu' => lang("app.tt_kasnonlangsung"),
            't_submenu' => '',
            't_icon' => '<i class="fa fa-money ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-money"></i>',
            't_dir1' => lang("app.mintakas"),
            't_dirac' => lang("app.kasnonlangsung"),
            'perusahaan' => $this->deklarModel->getPerusahaan('1'),
            'wilayah' => $this->deklarModel->getDivisi('wilayah', '1'),
            'divisi' => $this->deklarModel->getDivisi('divisi', '1'),
            'menu' => 'kasnonlangsung',
            'pesan' => '0',
            'peminta' => session()->username,
            'tuser' => $this->user,
        ];

        return view('kas/mintakas_view', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function crany()
    {
        ulang1:
        $idu = buatid('60');
        $db = $this->deklarModel->cekID('kas_induk', $idu);
        if (!empty($db)) {
            goto ulang1;
        }
        $this->iduModel->saveID($idu);
        return redirect()->to('/kasnonlangsung/input/' . $idu);
    }

    // ____________________________________________________________________________________________________________________________
    public function showdata($idunik)
    {
        // if (!preg_match("/122/i", session()->menu->menu_1))
        // throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();

        $db1 = $this->deklarModel->satuID('kas_induk', '', $idunik, '1');
        ((!empty($db1)) && ($db1['0']->norevisi != '0')) ? $ticon = '<i class="fa fa-money ' . lang("app.xdetil") . '"></i>' : $ticon = '<i class="fa fa-money ' . lang("app.xinput") . '"></i>';
        ((!empty($db1)) && ($db1['0']->norevisi != '0')) ? $revisi = "y" : $revisi = "n";
        (!empty($db1)) ? $cabang = $db1['0']->cabang_id : $cabang = '';
        (!empty($db1)) ? $penerima = $db1['0']->penerima_id : $penerima = '';
        // (!empty($db1)) ? $kbli = $db1['0']->kbli_id : $kbli = '';

        $kbli = "";
        $norevisi = '0';
        if (!empty($db1)) {
            $dbkbli = $this->tranModel->getKasanak($db1['0']->id);
            $kbli = $dbkbli['0']->kbli_id;

            //     $dbrev = $this->customModel->cariRevisikas($idunik);
            //     if ($db['0']->nrev == '0') { // jika belum masuk proses 
            //         $norevisi = $dbrev['0']->norevisi;
            //     } else {
            //         $norevisi = $dbrev['0']->norevisi + 1;
            //     }
        }

        $data = [
            't_menu' => lang("app.tt_kasnonlangsung"),
            't_submenu' => '',
            't_icon' => $ticon,
            't_diricon' => '<i class="fa fa-money"></i>',
            't_dir1' => lang("app.mintakas"),
            't_dirac' => lang("app.kasnonlangsung"),
            'idu' => $this->iduModel->cekID($idunik),
            'idunik' => $idunik,
            'perusahaan' => $this->deklarModel->getPerusahaan('1'),
            'wilayah' => $this->deklarModel->getDivisi('wilayah', '1'),
            'divisi' => $this->deklarModel->getDivisi('divisi', '1'),
            'nodoc' => $this->deklarModel->cekForm('dokumen', 'kasnonlangsung', '1', '', '', ''),
            'minta' => $this->tranModel->getKasinduk($idunik),
            'selnama' => $this->deklarModel->distSelect('beban'),
            'proyek1' => $this->deklarModel->satuID('m_proyek', '1', $cabang),
            'camp1' => $this->deklarModel->satuID('m_camp', '1', $cabang),
            'alat1' => $this->deklarModel->satuID('m_alat', '1', $cabang),
            'tanah1' => $this->deklarModel->satuID('m_tanah', '1', $cabang),
            'penerima1' => $this->deklarModel->satuID('m_penerima', '1', $penerima),
            'kbli1' => $this->deklarModel->satuID('m_kbli', '1', $kbli),
            'norevisi' => $norevisi,
            'revisi' => $revisi,
            'menu' => 'kasnonlangsung',
            'tuser' => $this->user,
            'validation' => \config\Services::validation()
        ];

        if ((empty($data['nodoc'])) || (empty($data['minta']) && (empty($data['idu'])))) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        return view('kas/kaslangsung_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function savedata()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();

            //status 0 belum sama antara peminta dan penginput
            $status = '1';
            $rule_akses = 'permit_empty';
            if (session()->username != $this->request->getVar('userid')) {
                $status = '0';
                $peminta = $this->deklarModel->getUser($this->request->getVar('userid'));
                $perush = $this->request->getVar('idperusahaan');
                $wil = $this->request->getVar('idwilayah');
                $div = $this->request->getVar('iddivisi');
                $cab = $this->request->getVar('idbeban');
                $error = "0";

                if (empty($peminta)) {
                    $error = "1";
                    goto err1;
                }
                if (($peminta['0']->akses_perusahaan == "0") && (!preg_match("/,$perush,/i", $peminta['0']->perusahaan))) {
                    $error = "1";
                    goto err1;
                }
                if (($peminta['0']->akses_wilayah == "0") && (!preg_match("/,$wil,/i", $peminta['0']->wilayah))) {
                    $error = "1";
                    goto err1;
                }
                if (($peminta['0']->akses_divisi == "0") && (!preg_match("/,$div,/i", $peminta['0']->divisi))) {
                    $error = "1";
                    goto err1;
                }

                switch ($this->request->getVar('xpilihan')) {
                    case 'proyek':
                        if (($peminta['0']->akses_proyek == "0") && (!preg_match("/,$cab,/i", $peminta['0']->proyek))) {
                            $error = "1";
                            goto err1;
                        }
                        break;
                    case 'camp':
                        if (($peminta['0']->akses_camp == "0") && (!preg_match("/,$cab,/i", $peminta['0']->camp))) {
                            $error = "1";
                            goto err1;
                        }
                        break;
                    case 'alat':
                        if (($peminta['0']->akses_alat == "0") && (!preg_match("/,$cab,/i", $peminta['0']->alat))) {
                            $error = "1";
                            goto err1;
                        }
                        break;
                    case 'tanah':
                        if (($peminta['0']->akses_aset == "0") && (!preg_match("/,$cab,/i", $peminta['0']->aset))) {
                            $error = "1";
                            goto err1;
                        }
                        break;
                }
                err1:
                if ($error == "1") {
                    $rule_akses = 'required';
                }
            }
            $rule_akun = 'permit_empty';
            $rule_biaya = 'permit_empty';
            $rule_sumberdaya = 'permit_empty';
            if ($this->request->getVar('xpilihan') != "proyek") {
                $rule_akun = 'required';
                $noakun = $this->request->getVar('noakun');
            } else {
                $rule_biaya = 'required';
                $db = $this->deklarModel->satuID('m_biaya', '1', $this->request->getVar('biaya'));
                (!empty($db)) ? $noakun = $db['0']->akun_id : $noakun = '';

                if ($this->request->getVar('ruas') != '') { // jika biaya langsung           
                    $rule_sumberdaya = 'required';
                    $db = $this->deklarModel->satuID('m_biaya', '1', $this->request->getVar('sumberdaya'));
                    (!empty($db)) ? $noakun = $db['0']->akun_id : $noakun = '';
                }
            }

            if (!$this->validate([
                'idperusahaan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang("app.errpilih"),
                    ]
                ],
                'idwilayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang("app.errpilih"),
                    ]
                ],
                'iddivisi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang("app.errpilih"),
                    ]
                ],
                'xpilihan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang("app.errpilih"),
                    ]
                ],
                'userid' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang("app.errblank"),
                    ]
                ],
                'akses' => [
                    'rules' => $rule_akses,
                    'errors' => [
                        'required' => lang("app.errnoakses"),
                    ]
                ],
                'beban' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang("app.errblank"),
                    ]
                ],
                'penerima' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang("app.errpilih"),
                    ]
                ],
                'noakun' => [
                    'rules' => $rule_akun,
                    'errors' => [
                        'required' => lang("app.errpilih"),
                    ]
                ],
                'nokbli' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang("app.errpilih"),
                    ]
                ],
                'biaya' => [
                    'rules' => $rule_biaya,
                    'errors' => [
                        'required' => lang("app.errpilih"),
                    ]
                ],
                'sumberdaya' => [
                    'rules' => $rule_sumberdaya,
                    'errors' => [
                        'required' => lang("app.errpilih"),
                    ]
                ],
                'vtotal' => [
                    'rules' => 'required|greater_than_equal_to[1]',
                    'errors' => [
                        'required' => lang("app.errblank"),
                        'greater_than_equal_to' => lang("app.err1"),
                    ]
                ],
                'catatan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang("app.errblank"),
                    ]
                ],
            ])) {
                $msg = [
                    'error' => [
                        'akses' => $validation->getError('akses'),
                        'perusahaan' => $validation->getError('idperusahaan'),
                        'wilayah' => $validation->getError('idwilayah'),
                        'divisi' => $validation->getError('iddivisi'),
                        'pilihan' => $validation->getError('xpilihan'),
                        'userid' => $validation->getError('userid'),
                        'beban' => $validation->getError('beban'),
                        'penerima' => $validation->getError('penerima'),
                        'biaya' => $validation->getError('biaya'),
                        'sumberdaya' => $validation->getError('sumberdaya'),
                        'noakun' => $validation->getError('noakun'),
                        'nokbli' => $validation->getError('nokbli'),
                        'vtotal' => $validation->getError('vtotal'),
                        'catatan' => $validation->getError('catatan'),
                    ]
                ];
            } else {
                $nomordokumen = $this->request->getVar('nodoc');
                if ($this->request->getVar('nodoc') == "") {
                    $db = $this->tranModel->getNomordoc('kas_induk', $this->request->getVar('kui'), "-" . substr($this->request->getVar('tanggal'), 2, 2));
                    (empty($db['0']->nodoc)) ? $nomor = "1" : $nomor = substr($db['0']->nodoc, -4) + 1;
                    $nomordokumen = nodokumen($this->request->getVar('kui'), $this->request->getVar('tanggal'), $nomor);
                }
                $kasinduk1 = $this->deklarModel->satuID('kas_induk', '', $this->request->getVar('idunik'), '1');
                if (empty($kasinduk1)) {
                    $this->kasindukModel->save([
                        'idunik' =>  $this->request->getVar('idunik'),
                        'perusahaan_id' => $this->request->getVar('idperusahaan'),
                        'wilayah_id' => $this->request->getVar('idwilayah'),
                        'divisi_id' => $this->request->getVar('iddivisi'),
                        'userid' => session()->username,
                        'peminta' => $this->request->getVar('userid'),
                        'nodoc' => $nomordokumen,
                        'tgl_minta' => $this->request->getVar('tanggal'),
                        'norevisi' => $this->request->getVar('norev'),
                        'pilihan' => $this->request->getVar('xpilihan'),
                        'cabang_id' => $this->request->getVar('idbeban'),
                        'penerima_id' => $this->request->getVar('penerima'),
                        'level_aw' => $this->request->getVar('xlevel'),
                        'level_pos' => $this->request->getVar('xlevel'),
                        'asal' => 'kasnonlangsung',
                        'jenis' => 'ju',
                        'status' => $status,
                    ]);
                }

                $kasin1 = $this->deklarModel->satuID('kas_induk', '', $this->request->getVar('idunik'), '1');
                // $this->tranModel->updatePenerimakas($this->request->getVar('idunik'), getid($this->request->getVar('xidbeban')), getid($this->request->getVar('xpenerima')));
                $this->kasanakModel->save([
                    'kasinduk_id' => $kasin1['0']->id,
                    'ruas_id' => $this->request->getVar('ruas'),
                    'biaya_id' => $this->request->getVar('biaya'),
                    'sumberdaya_id' => $this->request->getVar('sumberdaya'),
                    'akun_id' => $noakun,
                    'kbli_id' => $this->request->getVar('nokbli'),
                    'jumlah' => ubahkoma($this->request->getVar('jumlah')),
                    'harga' => ubahkoma($this->request->getVar('harga')),
                    'debit' => ubahkoma($this->request->getVar('total')),
                    'catatan' => $this->request->getVar('catatan'),
                    'status' => '1',
                ]);

                // if ($this->request->getVar('norev') != "0") {
                //     $this->tranModel->updateRevisi('kas_induk', $this->request->getVar('idunik'), $this->request->getVar('norev'));
                //     $this->tranModel->updateLogaksi($this->request->getVar('nodoc'));
                // }

                $akun1 = $this->deklarModel->satuID('m_akun', '', $noakun);
                $msg = [
                    'sukses' => lang("app.inputdata") . ' ' . $akun1['0']->noakun . ' ' . lang("app.sukses"),
                    'judul' => lang("app.mintajudul"),
                    'nodoc' => $nomordokumen,
                ];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function tabeluangmuka()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'piutang' => $this->tranModel->getPiutang($this->request->getvar('penerima'), $this->request->getvar('pilihan')),
                'idunik' => $this->request->getVar('idunik'),
            ];
            $msg = [
                'data' => view('x-kas/uangmuka_tabel', $data)
            ];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
    public function modaluangmuka()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'idunik' => $this->request->getVar('idunik'),
                'induk' => $this->request->getVar('induk'),
                'anak' => $this->request->getVar('anak'),
                'akun' => $this->request->getVar('akun'),
                'sisa' => $this->request->getVar('sisa'),
            ];

            $msg = [
                'data' => view('x-modal/input_piutang', $data)
            ];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
    public function saveuangmuka()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();

            $rule_total = 'required';
            if (ubahkoma($this->request->getVar('total2')) > $this->request->getVar('xsisa')) {
                $rule_total = 'valid_email';
            }
            if (!$this->validate([
                'total2' => [
                    'rules' => $rule_total,
                    'errors' => [
                        'required' => lang("app.errblank"),
                        'valid_email' => lang("app.errunik3"),
                    ]
                ],
                'catatan2' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang("app.errblank"),
                    ]
                ]
            ])) {
                $msg = [
                    'error' => [
                        'mtotal' => $validation->getError('total2'),
                        'mcatatan' => $validation->getError('catatan2'),
                    ]
                ];
            } else {
                $this->kasdetilModel->save([
                    'kasinduk_id' => $this->request->getVar('idkasinduk'),
                    'kasanak_id' => $this->request->getVar('idkasanak'),
                    'kredit' => ubahkoma($this->request->getVar('total2')),
                    'catatan' => $this->request->getVar('catatan2'),
                ]);

                $akhir1 = $this->deklarModel->akhirID('kas_detil');
                $kasin1 = $this->deklarModel->satuID('kas_induk', '', $this->request->getVar('xidunik'), '1');
                $this->kasanakModel->save([
                    'kasinduk_id' => $kasin1['0']->id,
                    'kasdetil_id' => $akhir1['0']->id,
                    'akun_id' => $this->request->getVar('idakun'),
                    'jumlah' => '1',
                    'harga' => ubahkoma($this->request->getVar('total2')),
                    'kredit' => ubahkoma($this->request->getVar('total2')),
                    'catatan' => $this->request->getVar('catatan2'),
                ]);

                $akun1 = $this->deklarModel->satuID('m_akun', '1', $this->request->getVar('idakun'));
                $msg = [
                    'sukses' => lang("app.simpandata") . ' ' . $akun1['0']->noakun . ' ' . lang("app.sukses"),
                    'judul' => lang("app.simpanjudul"),
                ];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function modalkoreksi()
    {
        if ($this->request->isAJAX()) {
            var_dump($this->request->getvar('id'));
            die;

            $id = $this->request->getvar('id');
            $db = $this->deklarModel->satuID('po_anak', '', $id);
            $data = [
                'po' => $this->deklarModel->satuID('po_anak', '', $id),
                'akun1' => $this->deklarModel->satuID('m_akun', '', $db['0']->barang_id),
                'barang1' => $this->deklarModel->satuID('m_barang', '', $db['0']->barang_id),
            ];
            $msg = [
                'data' => view('x-modal/koreksi_mintabarang', $data)
            ];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function updatedokumen()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();

            $rule_akses = 'permit_empty';
            if (session()->username != $this->request->getVar('user')) {
                $peminta = $this->deklarModel->getUser($this->request->getVar('user'));
                $cab = $this->request->getVar('cabang');
                $error = "0";

                switch ($this->request->getVar('pilihan')) {
                    case 'proyek':
                        if (($peminta['0']->akses_proyek == "0") && (!preg_match("/,$cab,/i", $peminta['0']->proyek))) {
                            $error = "1";
                            goto err1;
                        }
                        break;
                    case 'camp':
                        if (($peminta['0']->akses_camp == "0") && (!preg_match("/,$cab,/i", $peminta['0']->camp))) {
                            $error = "1";
                            goto err1;
                        }
                        break;
                    case 'alat':
                        if (($peminta['0']->akses_alat == "0") && (!preg_match("/,$cab,/i", $peminta['0']->alat))) {
                            $error = "1";
                            goto err1;
                        }
                        break;
                    case 'tanah':
                        if (($peminta['0']->akses_aset == "0") && (!preg_match("/,$cab,/i", $peminta['0']->aset))) {
                            $error = "1";
                            goto err1;
                        }
                        break;
                }
                err1:
                if ($error == "1") {
                    $rule_akses = 'required';
                }
            }

            if (!$this->validate([
                'akses' => [
                    'rules' => $rule_akses,
                    'errors' => [
                        'required' => lang("app.errnoakses"),
                    ]
                ],
                'cabang' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang("app.errblank"),
                    ]
                ],
                'penerima' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang("app.errblank"),
                    ]
                ],
                'dokumen' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang("app.errblank"),
                    ]
                ],
            ])) {
                $msg = [
                    'error' => [
                        'akses' => $validation->getError('akses'),
                        'beban' => $validation->getError('cabang'),
                        'penerima' => $validation->getError('penerima'),
                        'dokumen' => $validation->getError('dokumen'),
                    ]
                ];
            } else {
                $db1 = $this->deklarModel->satuID('kas_induk', '', $this->request->getVar('idunik'), '1');
                if (empty(!$db1)) {
                    $this->kasindukModel->save([
                        'id' => $db1['0']->id,
                        'cabang_id' => $this->request->getVar('cabang'),
                        'level_pos' => $this->request->getVar('level'),
                        'penerima_id' => $this->request->getVar('penerima'),
                    ]);
                }
                $msg = [
                    'sukses' => lang("app.ubahdoc") . ' ' . $this->request->getVar('dokumen') . ' ' . lang("app.sukses"),
                    'judul' => lang("app.ubahjudul"),
                ];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
    public function canceldokumen($idunik)
    {
        $db = $this->tranModel->getKasinduk($idunik);
        if (empty(!$db)) {
            $this->kasindukModel->save([
                'id' => $db['0']->id,
                'status' => '5',
            ]);

            $this->logModel->saveLog('/kasnonlangsung', $db['0']->id, 'Cancel', $db['0']->nodoc);
            session()->setflashdata('judul', lang("app.bataljudul"));
            session()->setflashdata('pesan', lang("app.bataldoc") . ' ' . $db['0']->nodoc . ' ' . lang("app.sukses"));
            session()->setflashdata('perus', $db['0']->perusahaan_id);
            session()->setflashdata('div', $db['0']->divisi_id);
        }
        return redirect()->to('/kasnonlangsung');
    }

    // ____________________________________________________________________________________________________________________________
    public function deletekas()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();

            $id = $this->request->getVar('id');
            $this->kasanakModel->delete($id);
            $msg = [
                'sukses' => lang("app.delitem") . ' ' . $this->request->getVar('akun') . ' ' . lang("app.sukses"),
                'judul' => lang("app.deljudul"),
            ];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
