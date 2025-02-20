<?php

namespace App\Controllers\trcash\expense;

use Config\App;
use App\Controllers\BaseController;
use App\Models\trcash\CashParentModel;
use App\Models\trcash\CashChild1Model;

class Advancepayment extends BaseController
{
    protected $CashParentModel;
    protected $CashChild1Model;

    public function __construct()
    {
        $this->cashparentModel = new CashParentModel();
        $this->cashchild1Model = new CashChild1Model();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        // checkPage('119');
        $data = [
            't_title' => lang('app.advance payment'),
            't_span' => lang('app.span advance payment'),
            'link' => base_url('advancepayment'),
            // 'cash' => $this->transModel->getCash($this->urls[1]),
        ];
        $this->render('trcash/expense/request_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        $db1 = $this->mainModel->getData('cash_parent', $this->request->getVar('search'));
        $table = (isset($db1[0]) ? ($db1[0]->object == 'project' ? 'm_project' : ($db1[0]->object == 'equipment tool' ? 'm_tool' : ($db1[0]->object == 'land building' ? 'm_land' : 'm_branch'))) : 'm_branch');
        // checkPage('119', $db1);
        $buttons = transButton($db1, '1', $db1[0]->status ?? '0');
        // if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, "{$db1[0]->title}");

        $data = [
            't_title' => lang('app.advance payment'),
            't_span' => lang('app.span advance payment'),
            'link' => base_url('advancepayment'),
            'company' => $this->mainModel->getCompany('', 't'),
            'region' => $this->mainModel->getFile('', 'region', 't'),
            'division' => $this->mainModel->getFile('', 'division', 't'),
            'selectSource' => $this->mainModel->distSelect('set budget'),
            'selectObject' => $this->mainModel->distSelect('object'),
            'type' => $this->mainModel->distinctCost('indirect cost'),
            'choice' => 'object',
            'object1' => $this->mainModel->getData($table, $db1[0]->object_id ?? '', '', 'id'),
            'requester1' => $this->mainModel->loadUser($db1[0]->username ?? decrypt(session()->username), '1'),
            'cash' => $db1,
            'button' => ['hidden' => $buttons['hidden'], 'disabled' => $buttons['disabled']],
        ];
        $this->render('trcash/expense/advancePayment_input', $data);
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
            't_menu' => lang("app.tt_kasum"),
            't_submenu' => '',
            't_icon' => $ticon,
            't_diricon' => '<i class="fa fa-money"></i>',
            't_dir1' => lang("app.mintakas"),
            't_dirac' => lang("app.kasum"),
            'idu' => $this->iduModel->cekID($idunik),
            'idunik' => $idunik,
            'perusahaan' => $this->deklarModel->getPerusahaan('1'),
            'wilayah' => $this->deklarModel->getDivisi('wilayah', '1'),
            'divisi' => $this->deklarModel->getDivisi('divisi', '1'),
            'nodoc' => $this->deklarModel->cekForm('dokumen', 'kasum', '1', '', '', ''),
            'minta' => $this->tranModel->getKasinduk($idunik),
            'selnama' => $this->deklarModel->distSelect('bebanum'),
            'proyek1' => $this->deklarModel->satuID('m_proyek', '1', $cabang),
            'camp1' => $this->deklarModel->satuID('m_camp', '1', $cabang),
            'alat1' => $this->deklarModel->satuID('m_alat', '1', $cabang),
            'tanah1' => $this->deklarModel->satuID('m_tanah', '1', $cabang),
            'penerima1' => $this->deklarModel->satuID('m_penerima', '1', $penerima),
            'kbli1' => $this->deklarModel->satuID('m_kbli', '1', $kbli),
            'norevisi' => $norevisi,
            'revisi' => $revisi,
            'menu' => 'kasum',
            'tuser' => $this->user,
            'validation' => \config\Services::validation()
        ];

        if ((empty($data['nodoc'])) || (empty($data['minta']) && (empty($data['idu'])))) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        return view('kas/kasum_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function savedata()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();

            //status 0 belum sama antara peminta dan penginput
            $status = '1';
            $rule_akses = 'permit_empty';
            if (session()->usernama != $this->request->getVar('userid')) {
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
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang("app.errpilih"),
                    ]
                ],
                'vtotal' => [
                    'rules' => 'required|greater_than_equal_to[1]',
                    'errors' => [
                        'required' => lang("app.errblank"),
                        'greater_than_equal_to' => lang("app.err0"),
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
                        'noakun' => $validation->getError('noakun'),
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
                        'userid' => session()->usernama,
                        'peminta' => $this->request->getVar('userid'),
                        'nodoc' => $nomordokumen,
                        'tgl_minta' => $this->request->getVar('tanggal'),
                        'norevisi' => $this->request->getVar('norev'),
                        'pilihan' => $this->request->getVar('xpilihan'),
                        'cabang_id' => $this->request->getVar('idbeban'),
                        'penerima_id' => $this->request->getVar('penerima'),
                        'level_aw' => $this->request->getVar('xlevel'),
                        'level_pos' => $this->request->getVar('xlevel'),
                        'asal' => 'kasum',
                        'jenis' => 'ju',
                        'status' => $status,
                    ]);
                }

                $kasin1 = $this->deklarModel->satuID('kas_induk', '', $this->request->getVar('idunik'), '1');
                $this->kasanakModel->save([
                    'kasinduk_id' => $kasin1['0']->id,
                    'akun_id' => $this->request->getVar('noakun'),
                    'supir_id' => $this->request->getVar('supir'),
                    'barang_id' => $this->request->getVar('barang'),
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

                $akun1 = $this->deklarModel->satuID('m_akun', '', $this->request->getVar('noakun'));
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
            if (session()->usernama != $this->request->getVar('user')) {
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

            $this->logModel->saveLog('/kasum', $db['0']->id, 'Cancel', $db['0']->nodoc);
            session()->setflashdata('judul', lang("app.bataljudul"));
            session()->setflashdata('pesan', lang("app.bataldoc") . ' ' . $db['0']->nodoc . ' ' . lang("app.sukses"));
            session()->setflashdata('perus', $db['0']->perusahaan_id);
            session()->setflashdata('div', $db['0']->divisi_id);
        }
        return redirect()->to('/kasum');
    }

    // ____________________________________________________________________________________________________________________________
    public function deletekas()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();

            $id = $this->request->getVar('id');
            $this->kasanakModel->delete($id);

            $msg = [
                'sukses' => lang("app.delitem") . ' ' . $this->request->getVar('noakun') . ' ' . lang("app.sukses"),
                'judul' => lang("app.deljudul"),
            ];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function loadakun()
    {
        if ($this->request->isAJAX()) {
            $penerima1 = $this->deklarModel->satuID('m_penerima', '1', $this->request->getvar('penerima'));
            ($this->request->getvar('xpilihan') == 'uangjalan') ? $strakun = 'akun3_id' : $strakun = 'akun1_id';

            $isiakun = "";
            $isiakun .= '<option value="">' . lang("app.pilih-") . '</option>';
            if (!empty($penerima1)) {
                if ($penerima1['0']->kakun_pel != "0") {
                    $akun1 = $this->deklarModel->akunPenerima($penerima1['0']->kakun_pel, $strakun);
                    $isiakun .= '<option value="' . $akun1['0']->idakun . '">' .  $akun1['0']->noakun . " => " . $akun1['0']->namaakun . " ( " . $akun1['0']->nama . " )" . '</option>';
                }
                if ($penerima1['0']->kakun_sup != "0") {
                    $akun1 = $this->deklarModel->akunPenerima($penerima1['0']->kakun_sup, $strakun);
                    $isiakun .= '<option value="' . $akun1['0']->idakun . '">' .  $akun1['0']->noakun . " => " . $akun1['0']->namaakun . " ( " . $akun1['0']->nama . " )" . '</option>';
                }
                if ($penerima1['0']->kakun_lain != "0") {
                    $akun1 = $this->deklarModel->akunPenerima($penerima1['0']->kakun_lain, $strakun);
                    $isiakun .= '<option value="' . $akun1['0']->idakun . '">' .  $akun1['0']->noakun . " => " . $akun1['0']->namaakun . " ( " . $akun1['0']->nama . " )" . '</option>';
                }
                if ($penerima1['0']->kakun_peg != "0") {
                    $akun1 = $this->deklarModel->akunPenerima($penerima1['0']->kakun_peg, $strakun);
                    $isiakun .= '<option value="' . $akun1['0']->idakun . '">' .  $akun1['0']->noakun . " => " . $akun1['0']->namaakun . " ( " . $akun1['0']->nama . " )" . '</option>';
                }
            }
            $data = [
                'akun' => $isiakun,
            ];
            echo json_encode($data);
        } else {
            exit('out');
        }
    }
}
