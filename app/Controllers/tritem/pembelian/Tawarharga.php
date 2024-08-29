<?php

namespace App\Controllers\tritem\pembelian;

use Config\App;
use App\Controllers\BaseController;
use App\Models\tritem\POmintaModel;
use App\Models\tritem\POanakModel;
use App\Models\tritem\POtawarModel;

class Tawarharga extends BaseController
{
    protected $pomintaModel;
    protected $poanakModel;
    protected $potawarModel;
    public function __construct()
    {
        $this->pomintaModel = new POmintaModel();
        $this->poanakModel = new POanakModel();
        $this->potawarModel = new POtawarModel();
    }

    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        // (!preg_match("/107/i", $this->menu['menu_1'])) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $data = [
            't_menu' => strtoupper(lang("app.tawarharga")), 't_submenu' => '',
            't_icon' => '<i class="fa fa-tags ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-product-hunt"></i>', 't_dir1' => lang("app.pembelian"), 't_dirac' => lang("app.tawarharga"), 't_link' => '/tawarharga',
            'menu' => 'tawarharga', 'baru' => 'hidden', 'filstat' => 'hidden', 'filcek' => 'hidden',
            'perusahaan' => $this->deklarModel->getPerusahaan('', 't'),
            'divisi' => $this->deklarModel->getDivisi('', 'divisi', 't'),
            'btnclascr' => lang('app.btncCreate'), 'btntextcr' => lang('app.btnCreate'),
            'actcreate' => ($this->user['act_create'] == '0' ? 'hidden' : ''),
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        return view('tritem/pembelian/mintabarang_view', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function showdata($idunik)
    {
        // (!preg_match("/126/i", $this->menu['menu_1'])) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $db1 = $this->deklarModel->satuID('po_minta', $idunik);
        $data = [
            't_menu' => strtoupper(lang("app.tawarharga")), 't_submenu' => '',
            't_icon' => '<i class="fa fa-tags ' . lang("app.xinput") . '"></i>',
            't_diricon' => '<i class="fa fa-product-hunt"></i>', 't_dir1' => lang("app.pembelian"), 't_dirac' => lang("app.tawarharga"), 't_link' => '/tawarharga',
            'idunik' => $idunik,
            'perusahaan' => $this->deklarModel->getPerusahaan('', 't'),
            'wilayah' => $this->deklarModel->getDivisi('', 'wilayah', 't'),
            'divisi' => $this->deklarModel->getDivisi('', 'divisi', 't'),
            'anak' => $this->tranModel->getPOanak($db1[0]->id),
            'user1' => $this->deklarModel->get1User($db1[0]->peminta_id),
            'selnama' => $this->deklarModel->distSelect('beban'),
            'barang' => $db1,
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        (empty($data['barang'])) && throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($data['barang']) {
            if ($this->user['act_perusahaan'] == "0" && !preg_match("/," . $data['barang'][0]->perusahaan_id . ",/i", $this->user['perusahaan'])) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
            if ($this->user['act_wilayah'] == "0" && !preg_match("/," . $data['barang'][0]->wilayah_id . ",/i", $this->user['wilayah'])) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
            if ($this->user['act_divisi'] == "0" && !preg_match("/," . $data['barang'][0]->divisi_id . ",/i", $this->user['divisi'])) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        }
        if ($db1) $this->logModel->saveLog('Read', $idunik, $db1[0]->nodoc, '-');
        return view('tritem/pembelian/tawarharga_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function tambahdata()
    {
        if ($this->request->isAJAX()) {
            $rule_akses = ($this->request->getVar('iduser') == '' ? 'valid_email' : 'permit_empty');
            $rule_tawar = 'required';
            if (ubahSeparator($this->request->getVar('jltawar')) > ubahSeparator($this->request->getVar('jumlah'))) $rule_tawar = 'required|valid_email';

            $validationRules = [
                'akses' => [
                    'rules' => $rule_akses,
                    'errors' => ['valid_email' => lang("app.erruserlog")]
                ],
                'item' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'jltawar' => [
                    'rules' => $rule_tawar,
                    'errors' => ['required' => lang("app.errblank"), 'valid_email' => lang("app.errunik")]
                ],
                'suplier' => [
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
                        'item' => $this->validation->getError('item'),
                        'jltawar' => $this->validation->getError('jltawar'),
                        'suplier' => $this->validation->getError('suplier'),
                        'total' => $this->validation->getError('total'),
                        'catatan' => $this->validation->getError('catatan'),
                    ]
                ];
            } else {
                $anak1 = $this->deklarModel->satuID('po_anak', $this->request->getVar('item'), '', 'id');
                $this->potawarModel->save([
                    'pominta_id' =>  $anak1[0]->pominta_id,
                    'poanak_id' =>  $this->request->getVar('item'),
                    'penerima_id' => $this->request->getVar('suplier'),
                    'jumlah' => ubahSeparator($this->request->getVar('jltawar')),
                    'harga' => ubahSeparator($this->request->getVar('harga')),
                    'diskon' => ubahSeparator($this->request->getVar('diskon')),
                    'total' => ubahSeparator($this->request->getVar('total')),
                    'st_pajak' => $this->request->getVar('pajak') == 'on' ? '1' : '0',
                    'catatan' => $this->request->getVar('catatan'),
                ]);
                $this->pomintaModel->save(['id' => $anak1[0]->pominta_id, 'status' => '8']);
                $penerima1 = $this->deklarModel->satuID('m_penerima', $this->request->getVar('suplier'), '', 'id');
                $this->logModel->saveLog('Add', $this->request->getVar('idunik'), "{$this->request->getVar('nodoc')} => {$this->request->getVar('nama')} ; {$penerima1[0]->nama}");
                $msg = ['sukses' => "{$this->request->getVar('nodoc')} => {$this->request->getVar('nama')} ; {$penerima1[0]->nama}" . " " . lang("app.judultambah")];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $rule_tawar = 'required';
            if (ubahSeparator($this->request->getVar('mjltawar')) > ubahSeparator($this->request->getVar('mjumlah'))) $rule_tawar = 'required|valid_email';

            $validationRules = [
                'mjltawar' => [
                    'rules' => $rule_tawar,
                    'errors' => ['required' => lang("app.errblank"), 'valid_email' => lang("app.errunik")]
                ],
                'msuplier' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'mtotal' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
                'mcatatan' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'mjltawar' => $this->validation->getError('mjltawar'),
                        'msuplier' => $this->validation->getError('msuplier'),
                        'mtotal' => $this->validation->getError('mtotal'),
                        'mcatatan' => $this->validation->getError('mcatatan'),
                    ]
                ];
            } else {
                var_dump($this->request->getVar('mbarang'));
                die;

                $this->poanakModel->save([
                    'id' => $this->request->getVar('mid'),
                    'jumlah' => ubahSeparator($this->request->getVar('mjltawar')),
                    'harga' => ubahSeparator($this->request->getVar('mharga')),
                    'diskon' => ubahSeparator($this->request->getVar('mdiskon')),
                    'total' => ubahSeparator($this->request->getVar('mtotal')),
                    'st_pajak' => $this->request->getVar('mpajak') == 'on' ? '1' : '0',
                    'catatan' => $this->request->getVar('mcatatan'),
                ]);
                // $this->pomintaModel->save(['id' => $anak1[0]->pominta_id, 'status' => '8']);
                $penerima1 = $this->deklarModel->satuID('m_penerima', $this->request->getVar('suplier'), '', 'id');
                $this->logModel->saveLog('Add', $this->request->getVar('idunik'), "{$this->request->getVar('nodoc')} => {$this->request->getVar('nama')} ; {$penerima1[0]->nama}");
                $msg = ['sukses' => "{$this->request->getVar('nodoc')} => {$this->request->getVar('nama')} ; {$penerima1[0]->nama}" . " " . lang("app.judultambah")];


                $penerima1 = $this->deklarModel->satuID('m_penerima', $this->request->getVar('msuplier'), '', 'id');
                $this->logModel->saveLog('Update', $this->request->getVar('midunik'), "{$this->request->getVar('mnodoc')} => {$this->request->getVar('mbarang')} ; {$penerima1[0]->nama}");
                // $this->logModel->saveLog('Update', $this->request->getVar('midunik'), "{$this->request->getVar('mnodoc')} => {$db2[0]->nama}");
                $msg = ['sukses' => "{$this->request->getVar('nama')} ; {$penerima1[0]->nama}" . " " . lang("app.judulubah")];
                // $msg = ['sukses' => "{$db2[0]->nama}" . lang("app.judulubah")];


                // $tabel = ($this->request->getVar('mjenis') == '1' ? 'm_barang' : 'm_akun');
                // $db2 = $this->deklarModel->satuID($tabel, $item, '', 'id');
                // $deskripsi = ($this->request->getVar('mjenis') == '1' ? $db2[0]->kode : $db2[0]->noakun);
                // $msg = ['sukses' => $deskripsi . " " . lang("app.judulubah")];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function modaldata()
    {
        if ($this->request->isAJAX()) {
            $poanak = $this->request->getvar('poanak');
            $db = $this->deklarModel->satuID('po_anak', $poanak, '', 'id');
            $db2 = $this->deklarModel->satuID('po_tawar', $this->request->getvar('id'), '', 'id');
            $data = [
                'po' => $db,
                'tawar' => $db2,
                'induk' => $this->deklarModel->satuID('po_minta', $db[0]->pominta_id, '', 'id'),
                'suplier1' => $this->deklarModel->satuID('m_penerima', $db2[0]->penerima_id ?? '', '', 'id'),
                'barang1' => $this->deklarModel->satuID('m_barang', $db[0]->item_id ?? '', '', 'id'),
                'jasa1' => $this->deklarModel->satuID('m_akun', $db[0]->item_id ?? '', '', 'id'),
            ];
            $msg = ['data' => view('x-modal/koreksi_tawarharga', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    // public function modalinput()
    // {
    //     if ($this->request->isAJAX()) {
    //         $id = $this->request->getvar('id');
    //         $db = $this->deklarModel->satuID('po_anak', $id, '', 'id');
    //         $data = [
    //             'po' => $db,
    //             'barang1' => $this->deklarModel->satuID('m_barang', $db[0]->item_id, '', 'id'),
    //             'jasa1' => $this->deklarModel->satuID('m_akun', $db[0]->item_id, '', 'id'),
    //         ];
    //         $msg = ['data' => view('x-modal/input_tawarharga', $data)];
    //         echo json_encode($msg);
    //     } else {
    //         exit('out');
    //     }
    // }
    // public function deletepenawaran()
    // {
    //     if ($this->request->isAJAX()) {
    //         $validation = \config\Services::validation();

    //         $id = $this->request->getVar('id');
    //         $suplier1 = $this->deklarModel->satuID('m_penerima', '', $this->request->getVar('suplier'));
    //         $this->potawarModel->delete($id);
    //         $msg = [
    //             'sukses' => lang("app.deldata") . ' ' . $suplier1[0]->nama . ' ' . lang("app.sukses"),
    //             'judul' => lang("app.deljudul"),
    //         ];
    //         echo json_encode($msg);
    //     } else {
    //         exit('out');
    //     }
    // }
    // public function pilihpenawaran()
    // {
    //     if ($this->request->isAJAX()) {
    //         $this->poanakModel->save([
    //             'id' => $this->request->getVar('poanak'),
    //             'harga' => ubahkoma($this->request->getVar('harga')),
    //             'diskon' => ubahkoma($this->request->getVar('diskon')),
    //             'total' => ubahkoma($this->request->getVar('total')),
    //             'penerima_id' => $this->request->getVar('suplier'),
    //             'st_pajak' => $this->request->getVar('pajak'),
    //         ]);
    //         $suplier1 = $this->deklarModel->satuID('m_penerima', '', $this->request->getVar('suplier'));
    //         $msg = [
    //             'sukses' => lang("app.titlepilihsuplier") . ' ' .  $suplier1[0]->nama . ' ' . lang("app.sukses"),
    //             'judul' => lang("app.titlepilihsuplier"),
    //         ];
    //         echo json_encode($msg);
    //     } else {
    //         exit('out');
    //     }
    // }


    // ____________________________________________________________________________________________________________________________
    public function koreksidata()
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
                $deskripsi = ($this->request->getVar('mjenis') == '1' ? $db2[0]->kode : $db2[0]->noakun);
                $msg = ['sukses' => $deskripsi . " " . lang("app.judulubah")];
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
            $this->potawarModel->delete($id);
            $msg = ['sukses' => "{$this->request->getVar('barang')} ; {$this->request->getVar('suplier')}" . ' ' . lang("app.judulhapus")];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
