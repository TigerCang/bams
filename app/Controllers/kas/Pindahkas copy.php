<?php

namespace App\Controllers\kas;

// defined('BASEPATH') or exit('No direct script access allowed');

use Config\App;
use App\Controllers\BaseController;
use App\Models\kas\KasindukModel;
use App\Models\kas\KasanakModel;
use App\Models\kas\KasdetilModel;

class Pindahkas extends BaseController
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
        $data = [
            't_menu' => lang("app.tt_pindahkas"),
            't_submenu' => '',
            't_icon' => '<i class="fa fa-money ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-money"></i>',
            't_dir1' => lang("app.mintakas"),
            't_dirac' => lang("app.pindahkas"),
            'user' => $this->customModel->getUser(session()->username),
            'perusahaan' => $this->customModel->getPerusahaan('1'),
            'divisi' => $this->customModel->getDivisi('divisi', '1'),
            'asal' => 'pindahkas',
        ];
        // if (preg_match("/126/i", session()->menu->menu_1)) {
        return view('kas/mintakas_view', $data);
        // } else {
        //     return view('errors/akses_403');
        // }
    }

    // ____________________________________________________________________________________________________________________________
    public function crany()
    {
        $idu = buatid('40');
        $this->iduModel->saveId($idu);
        return redirect()->to('/pindahkas/input/' . $idu);
    }

    // ____________________________________________________________________________________________________________________________
    public function showdata($idunik)
    {
        $db = $this->tranModel->getKasinduk('', '', '', '', '', '', '', $idunik);
        $cabang = '';
        $penerima = '';
        $perusahaan = "";
        $wilayah = "";
        $divisi = "";
        $kbli = "";
        $akun = "";
        $norevisi = '0';
        $kasid = '';
        if (!empty($db)) {
            $cabang = $db['0']->cabang_id;
            $penerima = $db['0']->penerima_id;
            $perusahaan = $db['0']->perusahaan_id;
            $wilayah = $db['0']->wilayah_id;
            $divisi = $db['0']->divisi_id;
            $kasid = $db['0']->id;

            $dbanak = $this->tranModel->getKasanak($db['0']->id);
            $akun = $dbanak['0']->akun_id;

            if ($db['0']->pilihan == 'proyek')
                $dbkbli = $this->customModel->satuID('m_proyek', '', $db['0']->cabang_id);
            else if ($db['0']->pilihan == 'alat')
                $dbkbli = $this->customModel->satuID('m_alat', '', $db['0']->cabang_id);
            else
                $dbkbli = $this->customModel->satuID('m_proyek', '', $db['0']->cabang_id);
            $kbli = $dbkbli['0']->kbli_id;
            // $dbrev = $this->customModel->cariRevisikas($idunik);
            // if ($db['0']->nrev == '0') { // jika belum masuk proses 
            //     $norevisi = $dbrev['0']->norevisi;
            // } else {
            //     $norevisi = $dbrev['0']->norevisi + 1;
            // }
        }

        $data = [
            't_menu' => lang("app.tt_pindahkas"),
            't_submenu' => '',
            't_icon' => '<i class="fa fa-money ' . lang("app.xinput") . '"></i>',
            't_diricon' => '<i class="fa fa-money"></i>',
            't_dir1' => lang("app.mintakas"),
            't_dirac' => lang("app.pindahkas"),
            'perusahaan' => $this->customModel->getPerusahaan('1'),
            'wilayah' => $this->customModel->getDivisi('wilayah', '1'),
            'divisi' => $this->customModel->getDivisi('divisi', '1'),
            'nodoc' => $this->customModel->cekForm('dokumen', 'pindahkas', '1', '', '', ''),
            'user' => $this->customModel->getUser(session()->username),
            'minta' => $this->tranModel->getKasinduk('', '', '', '', '', '', '', $idunik),
            'anak' => $this->tranModel->getKasanak($kasid),
            'selnama' => $this->customModel->distSelect('beban'),
            'perusahaan1' => $this->customModel->satuID('m_perusahaan', '1', $perusahaan),
            'wilayah1' => $this->customModel->satuID('m_divisi', '1', $wilayah),
            'divisi1' => $this->customModel->satuID('m_divisi', '1', $divisi),
            'proyek1' => $this->customModel->satuID('m_proyek', '1', $cabang),
            'camp1' => $this->customModel->satuID('m_camp', '1', $cabang),
            'alat1' => $this->customModel->satuID('m_alat', '1', $cabang),
            'tanah1' => $this->customModel->satuID('m_tanah', '1', $cabang),
            'penerima1' => $this->customModel->satuID('m_penerima', '1', $penerima),
            'kbli1' => $this->customModel->satuID('m_kbli', '1', $kbli),
            'akun1' => $this->customModel->satuID('m_akun', '1', $akun),
            'idu' => $this->iduModel->cekId($idunik),
            'idunik' => $idunik,
            'norevisi' => $norevisi,
            'tuser' => $this->user,
            'validation' => \config\Services::validation()
        ];

        if (empty($data['nodoc'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        if (empty($data['minta']) && (empty($data['idu']))) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        return view('kas/pindahkas_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function savedata($idunik)
    {
        //status 0 belum sama antara peminta dan penginput
        $status = '1';
        $rule_akses = 'permit_empty';

        // akses peminta jika tidak sama dengan penginput
        if (session()->username != $this->request->getVar('userid')) {
            $status = '0';
            $peminta = $this->customModel->getUser($this->request->getVar('userid'));
            $perush = getid($this->request->getVar('xperusahaan'));
            $wil = getid($this->request->getVar('xwilayah'));
            $div = getid($this->request->getVar('xdivisi'));
            $cab = getid($this->request->getVar('xidbeban'));

            $error = "0";
            if (empty($peminta)) {
                $error = "1";
                goto err1;
            }
            if (($peminta['0']->akses_perusahaan == "0") && (!preg_match("/$perush,/i", $peminta['0']->perusahaan))) {
                $error = "1";
                goto err1;
            }
            if (($peminta['0']->akses_wilayah == "0") && (!preg_match("/$wil,/i", $peminta['0']->wilayah))) {
                $error = "1";
                goto err1;
            }
            if (($peminta['0']->akses_divisi == "0") && (!preg_match("/$div,/i", $peminta['0']->divisi))) {
                $error = "1";
                goto err1;
            }

            switch ($this->request->getVar('xpilihan')) {
                case 'proyek':
                    if (($peminta['0']->akses_proyek == "0") && (!preg_match("/$cab,/i", $peminta['0']->proyek))) {
                        $error = "1";
                        goto err1;
                    }
                    break;
                case 'camp':
                    if (($peminta['0']->akses_camp == "0") && (!preg_match("/$cab,/i", $peminta['0']->camp))) {
                        $error = "1";
                        goto err1;
                    }
                    break;
                case 'alat':
                    if (($peminta['0']->akses_alat == "0") && (!preg_match("/$cab,/i", $peminta['0']->alat))) {
                        $error = "1";
                        goto err1;
                    }
                    break;
                case 'tanah':
                    if (($peminta['0']->akses_aset == "0") && (!preg_match("/$cab,/i", $peminta['0']->aset))) {
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
            'xperusahaan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang("app.errpilih"),
                ]
            ],
            'xwilayah' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang("app.errpilih"),
                ]
            ],
            'xdivisi' => [
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
            'xpenerima' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang("app.errblank"),
                ]
            ],
            'noakun' => [
                'rules' => 'required',
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
            return redirect()->to('/pindahkas/input/' . $idunik)->withInput();
        }

        $nomordokumen = $this->request->getVar('nodoc');
        if ($this->request->getVar('nodoc') == "") {
            $db = $this->tranModel->getNomorkas($this->request->getVar('kui'), "-" . substr($this->request->getVar('tanggal'), 2, 2));
            if (empty($db['0']->nodoc)) {
                $nomor = "1";
            } else {
                $nomor = substr($db['0']->nodoc, -4) + 1;
            }
            $nomordokumen = nodokumen($this->request->getVar('kui'), $this->request->getVar('tanggal'), $nomor);
        }

        $kasinduk1 = $this->customModel->satuID('kas_induk', '', $this->request->getVar('idunik'), '1');
        if (empty($kasinduk1)) {
            $this->kasindukModel->save([
                'idunik' =>  $this->request->getVar('idunik'),
                'perusahaan_id' => getid($this->request->getVar('xperusahaan')),
                'wilayah_id' => getid($this->request->getVar('xwilayah')),
                'divisi_id' => getid($this->request->getVar('xdivisi')),
                'userid' => session()->username,
                'peminta' => $this->request->getVar('userid'),
                'nodoc' => $nomordokumen,
                'tgl_minta' => $this->request->getVar('tanggal'),
                'norevisi' => $this->request->getVar('norev'),
                'pilihan' => $this->request->getVar('xpilihan'),
                'cabang_id' => getid($this->request->getVar('xidbeban')),
                'penerima_id' => getid($this->request->getVar('xpenerima')),
                'level_aw' => $this->request->getVar('xlevel'),
                'level_pos' => $this->request->getVar('xlevel'),
                'asal' => 'pindahkas',
                'jenis' => 'ju',
                'status' => $status,
            ]);
            $this->tranModel->delId($this->request->getVar('idunik'));
        }

        $idkasinduk = $this->customModel->satuID('kas_induk', '', $this->request->getVar('idunik'), '1');
        $idkasanak = $this->tranModel->getKasanak($idkasinduk['0']->id);
        if (empty($idkasanak)) {
            $this->kasanakModel->save([
                'kasinduk_id' => $idkasinduk['0']->id,
                'akun_id' => getid($this->request->getVar('noakun')),
                'jumlah' => gantikoma($this->request->getVar('jumlah')),
                'harga' => gantikoma($this->request->getVar('harga')),
                'debit' => gantikoma($this->request->getVar('total')),
                'catatan' => $this->request->getVar('catatan'),
            ]);
        } else {
            $this->kasanakModel->save([
                'id' =>  $idkasanak['0']->id,
                'akun_id' => getid($this->request->getVar('noakun')),
                'jumlah' => gantikoma($this->request->getVar('jumlah')),
                'harga' => gantikoma($this->request->getVar('harga')),
                'debit' => gantikoma($this->request->getVar('total')),
                'catatan' => $this->request->getVar('catatan'),
            ]);
        }

        if ($this->request->getVar('norev') != "0") {
            $this->tranModel->updateRevisi('kas_beban', $this->request->getVar('idunik'), $this->request->getVar('norev'));
            $this->tranModel->updateLogaksi($this->request->getVar('nodoc'));
        }
        return redirect()->to('/pindahkas/input/' . $idunik);
    }

    // ____________________________________________________________________________________________________________________________
    public function modallampiran()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'idunik' => $this->request->getVar('idunik'),
            ];

            $msg = [
                'data' => view('x-modal/input_pindahkas', $data)
            ];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
    public function savelampiran()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();
            $idkasinduk = $this->customModel->satuID('kas_induk', '', $this->request->getVar('midunik'), '1');
            (empty($idkasinduk)) ? $rule_data = 'required' : $rule_data = 'permit_empty';

            if (!$this->validate([
                'mdata' => [
                    'rules' => $rule_data,
                    'errors' => [
                        'required' => lang("app.errnodata"),
                    ]
                ],
                'mnoakun' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang("app.errpilih"),
                    ]
                ],
                'mtotal' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang("app.errblank"),
                    ]
                ],
                'mcatatan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang("app.errblank"),
                    ]
                ]
            ])) {
                $msg = [
                    'error' => [
                        'mdata' => $validation->getError('mdata'),
                        'mnoakun' => $validation->getError('mnoakun'),
                        'mtotal' => $validation->getError('mtotal'),
                        'mcatatan' => $validation->getError('mcatatan'),
                    ]
                ];
            } else {
                $idkasinduk = $this->customModel->satuID('kas_induk', '', $this->request->getVar('midunik'), '1');
                $this->kasdetilModel->save([
                    'kasinduk_id' => $idkasinduk['0']->id,
                    'biaya_id' => getid($this->request->getVar('mnoakun')),
                    'debit' => gantikoma($this->request->getVar('mtotal')),
                    'catatan' => $this->request->getVar('mcatatan'),
                ]);
                $msg = [
                    'sukses' => lang("app.tambahdata") . ' ' . lang("app.sukses"),
                    'judul' => lang("app.inputjudul"),
                ];
            }
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
                $peminta = $this->customModel->getUser($this->request->getVar('user'));
                $cab = getid($this->request->getVar('cabang'));
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
                'pilihan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang("app.errpilih"),
                    ]
                ],
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
            ])) {
                $msg = [
                    'error' => [
                        'akses' => $validation->getError('akses'),
                        'pilihan' => $validation->getError('pilihan'),
                        'beban' => $validation->getError('cabang'),
                        'penerima' => $validation->getError('penerima'),
                    ]
                ];
            } else {
                $kasinduk1 = $this->customModel->satuID('kas_induk', '', $this->request->getVar('idunik'), '1');
                if (empty(!$kasinduk1)) {
                    $this->kasindukModel->save([
                        'id' => $kasinduk1['0']->id,
                        'pilihan' => $this->request->getVar('pilihan'),
                        'cabang_id' => getid($this->request->getVar('cabang')),
                        'penerima_id' => getid($this->request->getVar('penerima')),
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

    // ____________________________________________________________________________________________________________________________
    public function canceldokumen($idunik)
    {
        $db = $this->tranModel->getDatainduk($idunik);
        if (empty(!$db)) {
            $this->kasindukModel->save([
                'id' => $db['0']->id,
                'status' => '5',
            ]);

            $this->logModel->saveLog('/kaslangsung', 'Cancel', $db['0']->nodoc);
            session()->setflashdata('judul', lang("app.bataljudul"));
            session()->setflashdata('pesan', lang("app.bataldoc") . ' ' . $db['0']->nodoc . ' ' . lang("app.sukses"));
            session()->setflashdata('perus', $db['0']->perusahaan_id);
            session()->setflashdata('div', $db['0']->divisi_id);
        }
        return redirect()->to('/kaslangsung');
    }

    // ____________________________________________________________________________________________________________________________
    public function deletekas()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();

            if ($this->request->getVar('norev') != "0") {
                $this->customModel->updateRevisi('kas_beban', $this->request->getVar('idunik'), $this->request->getVar('norev'));
            }

            $id = $this->request->getVar('id');
            $this->mintakasModel->delete($id);

            $msg = [
                'sukses' => lang("app.delitem") . ' ' . $this->request->getVar('noakun') . ' ' . lang("app.sukses"),
                'judul' => lang("app.deljudul"),
            ];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
