<?php

namespace App\Controllers\tritem\pembelian;

use Config\App;
use App\Controllers\BaseController;
use App\Models\tritem\POmintaModel;
use App\Models\tritem\POanakModel;

class Mintabarang extends BaseController
{
    protected $pomintaModel;
    protected $poanakModel;
    public function __construct()
    {
        $this->pomintaModel = new POmintaModel();
        $this->poanakModel = new POanakModel();
    }

    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        // (!preg_match("/107/i", $this->menu['menu_1'])) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $data = [
            't_menu' => strtoupper(lang("app.mintabarang")), 't_submenu' => '',
            't_icon' => '<i class="icofont icofont-paper ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="icofont icofont-paper"></i>', 't_dir1' => lang("app.mintabarang"), 't_dirac' => lang("app.mintabarang"), 't_link' => '/mintabarang',
            'menu' => 'mintabarang', 'baru' => '', 'filstat' => '', 'filcek' => 'hidden',
            'perusahaan' => $this->deklarModel->getPerusahaan('', 't'),
            'divisi' => $this->deklarModel->getDivisi('', 'divisi', 't'),
            'btnclascr' => lang('app.btncCreate'), 'btntextcr' => lang('app.btnCreate'),
            'actcreate' => ($this->user['act_create'] == '0' ? 'hidden' : ''),
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        return view('tritem/pembelian/mintabarang_view', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function crany()
    {
        do {
            $idu = buatid(60);
            $db = $this->deklarModel->satuID('po_minta', $idu);
        } while ($db);
        $this->iduModel->saveID($idu);
        return redirect()->to('/mintabarang/input/' . $idu);
    }

    // ____________________________________________________________________________________________________________________________
    public function showdata($idunik)
    {
        // (!preg_match("/126/i", $this->menu['menu_1'])) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $db1 = $this->deklarModel->satuID('po_minta', $idunik);
        $data = [
            't_menu' => strtoupper(lang("app.mintabarang")), 't_submenu' => '',
            't_icon' => '<i class="icofont icofont-paper ' . lang("app.xinput") . '"></i>',
            't_diricon' => '<i class="icofont icofont-paper"></i>', 't_dir1' => lang("app.mintabarang"), 't_dirac' => lang("app.mintabarang"), 't_link' => '/mintabarang',
            'idu' => $this->iduModel->cekID($idunik), 'idunik' => $idunik,
            'perusahaan' => $this->deklarModel->getPerusahaan('', 't'),
            'wilayah' => $this->deklarModel->getDivisi('', 'wilayah', 't'),
            'divisi' => $this->deklarModel->getDivisi('', 'divisi', 't'),
            'satuan' => $this->deklarModel->getDivisi('', 'satuan', 't'),
            'nodoc' => $this->deklarModel->cekForm('dokumen', 'mintabarang', 't', '', '', ''),
            'user1' => $this->deklarModel->get1User($db1[0]->peminta_id ?? $this->user['id']),
            'barang' => $db1,
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        // dd($data['user1'], $db1[0]->peminta_id);
        (empty($data['barang']) && empty($data['idu'])) && throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($data['barang']) {
            if ($this->user['act_perusahaan'] == "0" && !preg_match("/," . $data['barang'][0]->perusahaan_id . ",/i", $this->user['perusahaan'])) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
            if ($this->user['act_wilayah'] == "0" && !preg_match("/," . $data['barang'][0]->wilayah_id . ",/i", $this->user['wilayah'])) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
            if ($this->user['act_divisi'] == "0" && !preg_match("/," . $data['barang'][0]->divisi_id . ",/i", $this->user['divisi'])) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
            if ($data['barang'][0]->user_id != $this->user['id'] && $data['barang'][0]->peminta_id != $this->user['id']) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        }
        if ($db1) $this->logModel->saveLog('Read', $idunik, $db1[0]->nodoc, '-');
        return view('tritem/pembelian/mintabarang_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function tambahdata()
    {
        if ($this->request->isAJAX()) {
            $sama = ($this->request->getVar('iduser') == $this->request->getVar('idpeminta') ? '1' : '0');
            $rule_akses = ($this->request->getVar('iduser') == '' ? 'valid_email' : 'permit_empty');
            $rule_item = ($this->request->getVar('jenis') == 'on' ? 'required' : 'permit_empty');
            $rule_jasa = ($this->request->getVar('jenis') == 'on' ? 'permit_empty' : 'required');
            $satuan = ($this->request->getVar('jenis') == 'on' ? $this->request->getVar('satuan') : '');
            $konversi = ($this->request->getVar('jenis') == 'on' ? ubahSeparator($this->request->getVar('konversi')) : '');
            $item = ($this->request->getVar('jenis') == 'on' ? $this->request->getVar('item') : $this->request->getVar('jasa'));
            $rule_satuan = 'permit_empty';
            if ($this->request->getVar('jenis') == 'on' && ((($this->request->getVar('satuan') != $this->request->getVar('satuan2')) && ($this->request->getVar('konversi') == '1,0000')) ||
                (($this->request->getVar('satuan') == $this->request->getVar('satuan2')) && ($this->request->getVar('konversi') != '1,0000')))) {
                $rule_satuan = 'valid_email';
            }

            $validationRules = [
                'akses' => [
                    'rules' => $rule_akses,
                    'errors' => ['valid_email' => lang("app.errnoakses")]
                ],
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
                'idpeminta' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
                'item' => [
                    'rules' => $rule_item,
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'jasa' => [
                    'rules' => $rule_jasa,
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'jumlah' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
                'satuan' => [
                    'rules' => $rule_satuan,
                    'errors' => ['valid_email' => lang("app.errunik")]
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
                        'peminta' => $this->validation->getError('idpeminta'),
                        'item' => $this->validation->getError('item'),
                        'jasa' => $this->validation->getError('jasa'),
                        'jumlah' => $this->validation->getError('jumlah'),
                        'satuan' => $this->validation->getError('satuan'),
                        'catatan' => $this->validation->getError('catatan'),
                    ]
                ];
            } else {
                $nodokumen = $this->request->getVar('nodoc');
                if ($nodokumen == "") {
                    $db = $this->tranModel->getNomordoc('po_minta', $this->request->getVar('kui'), "-" . substr($this->request->getVar('tanggal'), 2, 2));
                    $nomor = ($db ? substr($db[0]->nodoc, -4) + 1 : '1');
                    $nodokumen = nodokumen($this->request->getVar('kui'), $this->request->getVar('tanggal'), $nomor);
                }
                $pominta1 = $this->deklarModel->satuID('po_minta', $this->request->getVar('idunik'));
                if ($pominta1) {
                    $this->pomintaModel->save(['id' =>  $pominta1[0]->id, 'status' => '0', 'is_sama' => $sama]);
                } else {
                    $this->pomintaModel->save([
                        'idunik' =>  $this->request->getVar('idunik'),
                        'user_id' => $this->request->getVar('iduser'),
                        'perusahaan_id' => $this->request->getVar('idperusahaan'),
                        'wilayah_id' => $this->request->getVar('idwilayah'),
                        'divisi_id' => $this->request->getVar('iddivisi'),
                        'peminta_id' => $this->request->getVar('idpeminta'),
                        'nodoc' => $nodokumen,
                        'tanggal' => $this->request->getVar('tanggal'),
                        'revisi' => $this->request->getVar('revisi'),
                        'level_aw' => $this->request->getVar('xlevel'),
                        'level_pos' => $this->request->getVar('xlevel'),
                        'is_sama' => $sama,
                        'status' => '0',
                    ]);
                }
                $idinduk = $this->deklarModel->satuID('po_minta', $this->request->getVar('idunik'));
                $this->poanakModel->save([
                    'pominta_id' => $idinduk[0]->id,
                    'jenis' => ($this->request->getVar('jenis') == 'on' ? '1' : '0'),
                    'item_id' => $item,
                    'spesifikasi' => $this->request->getVar('spesifikasi'),
                    'jumlah' => ubahSeparator($this->request->getVar('jumlah')),
                    'satuan' => $satuan,
                    'konversi' => $konversi,
                    'level_pos' => $this->request->getVar('xlevel'),
                    'catatan' => $this->request->getVar('catatan'),
                    // 'status' => $status,
                ]);
                $tabel = ($this->request->getVar('jenis') == 'on' ? 'm_barang' : 'm_akun');
                $db2 = $this->deklarModel->satuID($tabel, $item, '', 'id');
                // $this->logModel->saveLog('Add', $this->request->getVar('idunik'), "{$nodokumen} => {$db2[0]->nama}");
                $msg = ['sukses' => "{$nodokumen} => {$db2[0]->nama}" . lang('app.judultambah'), 'nodoc' => $nodokumen, 'stat' => lang('app.baru')];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $rule_item = ($this->request->getVar('mjenis') == '1') ? 'required' : 'permit_empty';
            $rule_jasa = ($this->request->getVar('mjenis') == '1') ? 'permit_empty' : 'required';
            $satuan = ($this->request->getVar('mjenis') == '1') ? $this->request->getVar('msatuan') : '';
            $konversi = ($this->request->getVar('mjenis') == '1') ? ubahSeparator($this->request->getVar('mkonversi')) : '';
            $item = ($this->request->getVar('mjenis') == '1') ? $this->request->getVar('mitem') : $this->request->getVar('mjasa');
            $rule_satuan = 'permit_empty';
            if ($this->request->getVar('mjenis') == '1' && ((($this->request->getVar('msatuan') != $this->request->getVar('msatuan2')) && ($this->request->getVar('mkonversi') == '1,0000')) ||
                (($this->request->getVar('msatuan') == $this->request->getVar('msatuan2')) && ($this->request->getVar('mkonversi') != '1,0000')))) {
                $rule_satuan = 'valid_email';
            }

            $validationRules = [
                'mitem' => [
                    'rules' => $rule_item,
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'mjasa' => [
                    'rules' => $rule_jasa,
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'mjumlah' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
                'msatuan' => [
                    'rules' => $rule_satuan,
                    'errors' => ['valid_email' => lang("app.errunik")]
                ],
                'mcatatan' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'mitem' => $this->validation->getError('mitem'),
                        'mjasa' => $this->validation->getError('mjasa'),
                        'mjumlah' => $this->validation->getError('mjumlah'),
                        'msatuan' => $this->validation->getError('msatuan'),
                        'mcatatan' => $this->validation->getError('mcatatan'),
                    ]
                ];
            } else {
                $this->poanakModel->save([
                    'id' => $this->request->getVar('mid'),
                    'item_id' => $item,
                    'spesifikasi' => $this->request->getVar('mspesifikasi'),
                    'jumlah' => ubahSeparator($this->request->getVar('mjumlah')),
                    'satuan' => $satuan,
                    'konversi' => $konversi,
                    'catatan' => $this->request->getVar('mcatatan'),
                ]);
                $tabel = ($this->request->getVar('mjenis') == '1' ? 'm_barang' : 'm_akun');
                $db2 = $this->deklarModel->satuID($tabel, $item, '', 'id');
                // $this->logModel->saveLog('Update', $this->request->getVar('midunik'), "{$this->request->getVar('mnodoc')} => {$db2[0]->nama}");
                $msg = ['sukses' => "{$db2[0]->nama}" . lang("app.judulubah")];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
    public function deletedata()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $this->poanakModel->delete($id);
            $msg = ['sukses' => $this->request->getVar('barang') . ' ' . lang("app.judulhapus")];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function modaldata()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getvar('id');
            $db = $this->deklarModel->satuID('po_anak', $id, '', 'id');
            $data = [
                'po' => $db,
                'induk' => $this->deklarModel->satuID('po_minta', $db[0]->pominta_id, '', 'id'),
                'satuan' => $this->deklarModel->getDivisi('', 'satuan', 't'),
                'barang1' => $this->deklarModel->satuID('m_barang', $db[0]->item_id, '', 'id'),
                'jasa1' => $this->deklarModel->satuID('m_akun', $db[0]->item_id, '', 'id'),
            ];
            $msg = ['data' => view('x-modal/koreksi_mintabarang', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function savedata()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->deklarModel->satuID('po_minta', $this->request->getVar('idunik'));
            $rule_akses = (empty($db1) ? 'required' : ($this->request->getVar('user') == '' ? 'valid_email' : 'permit_empty'));

            $validationRules = [
                'akses' => [
                    'rules' => $rule_akses,
                    'errors' => ['required' => lang("app.errunik2"), 'valid_email' => lang("app.erruserlog")]
                ],
            ];
            if (!$this->validate($validationRules)) {
                $msg = ['error' => ['akses' => $this->validation->getError('akses')]];
            } else {
                $revisi = $db1[0]->status > '1' ? $db1[0]->revisi + 1 : $db1[0]->revisi;
                $stsetuju = ($this->request->getVar('user') == $this->request->getVar('peminta') ? '1' : 'c');
                $this->pomintaModel->save(['id' => $db1[0]->id, 'revisi' => $revisi, 'status' => $stsetuju]);
                $this->logModel->saveLog('Save', $this->request->getVar('idunik'), $this->request->getVar('nodoc'));
                $this->session->setFlashdata(['judul' => $this->request->getVar('nodoc') . " " . lang("app.judulsimpan"), 'perus' => $db1[0]->perusahaan_id, 'div' => $db1[0]->divisi_id]);
                $msg = ['redirect' => '/mintabarang'];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
    public function canceldata()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->deklarModel->satuID('po_minta', $this->request->getVar('idunik'));
            $rule_akses = 'permit_empty';
            if (empty($db1)) $rule_akses = 'required';
            if ($this->request->getVar('user') == '') $rule_akses = 'valid_email';
            $validationRules = [
                'akses' => [
                    'rules' => $rule_akses,
                    'errors' => ['required' => lang("app.errunik2"), 'valid_email' => lang("app.erruserlog")]
                ],
            ];

            if (!$this->validate($validationRules)) {
                $msg = ['error' => ['akses' => $this->validation->getError('akses')]];
            } else {
                $this->pomintaModel->save(['id' => $db1[0]->id, 'status' => '5']);
                $this->logModel->saveLog('Cancel', $this->request->getVar('idunik'), $this->request->getVar('nodoc'));
                $this->session->setFlashdata(['judul' => $this->request->getVar('nodoc') . " " . lang("app.judulbatal"), 'perus' => $db1[0]->perusahaan_id, 'div' => $db1[0]->divisi_id]);
                $msg = ['redirect' => '/mintabarang'];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________
    public function confirmdata()
    {
        if ($this->request->isAJAX()) {
            var_dump("asd");
            die;
            $db1 = $this->deklarModel->satuID('po_minta', $this->request->getVar('idunik'));
            $rule_akses = (($this->request->getVar('user') == '') ? 'valid_email' : 'permit_empty');

            $validationRules = [
                'akses' => [
                    'rules' => $rule_akses,
                    'errors' => ['valid_email' => lang("app.erruserlog")]
                ],
            ];
            if (!$this->validate($validationRules)) {
                $msg = ['error' => ['akses' => $this->validation->getError('akses')]];
            } else {
                //Konfirmasi
                if ($this->request->getVar('postaction') == 'confirm') {
                    $level = $this->request->getVar('level');
                    $konf = $this->konfigurasiModel->getKonfigurasi('acc_mintaitem');
                    $status = (($konf[0]['nilai'] >= $level && $level != '0') ? '6' : '1');
                    $this->pomintaModel->save(['id' => $db1[0]->id, 'level_aw' => $level, 'level_pos' => $level, 'status' => $status]);
                    $this->tranModel->update1Data('po_anak', 'level_pos', $level, 'pominta_id', $db1[0]->id);
                    $this->logModel->saveLog('Confirm', $this->request->getVar('idunik'), $this->request->getVar('nodoc'));
                    $this->session->setFlashdata(['judul' => $this->request->getVar('nodoc') . " " . lang("app.judulkonf"), 'perus' => $db1[0]->perusahaan_id, 'div' => $db1[0]->divisi_id]);
                }
                $msg = ['redirect' => '/mintabarang'];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
    // ____________________________________________________________________________________________________________________________
    public function loadsatuan()
    {
        if ($this->request->isAJAX()) {
            $db = $this->deklarModel->satuID('m_barang', $this->request->getvar('barang'), '', 'id');
            $data = ['barang' => $db];
            echo json_encode($data);
        } else {
            exit('out');
        }
    }
}
