<?php

namespace App\Controllers\tritem\pembelian;

use Config\App;
use App\Controllers\BaseController;
use App\Models\tritem\POmintaModel;
use App\Models\tritem\POanakModel;

class Cekada extends BaseController
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
            't_menu' => strtoupper(lang("app.ceksedia")), 't_submenu' => '',
            't_icon' => '<i class="icofont icofont-document-search ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="icofont icofont-document-search"></i>', 't_dir1' => lang("app.mintabarang"), 't_dirac' => lang("app.ceksedia"), 't_link' => '/cekada',
            'menu' => 'cekada', 'baru' => 'hidden', 'filstat' => 'hidden', 'filcek' => 'hidden',
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
            't_menu' => strtoupper(lang("app.ceksedia")), 't_submenu' => '',
            't_icon' => '<i class="icofont icofont-document-search ' . lang("app.xinput") . '"></i>',
            't_diricon' => '<i class="icofont icofont-document-search"></i>', 't_dir1' => lang("app.mintabarang"), 't_dirac' => lang("app.ceksedia"), 't_link' => '/cekada',
            'idunik' => $idunik,
            'perusahaan' => $this->deklarModel->getPerusahaan('', 't'),
            'wilayah' => $this->deklarModel->getDivisi('', 'wilayah', 't'),
            'divisi' => $this->deklarModel->getDivisi('', 'divisi', 't'),
            'anak' => $this->tranModel->getPOanak($db1[0]->id),
            'user1' => $this->deklarModel->get1User($db1[0]->peminta_id),
            'barang' => $db1,
            'statpo' => $db1[0]->status == '7' ? 'disabled' : '',
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        (empty($data['barang'])) && throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($data['barang']) {
            if ($this->user['act_perusahaan'] == "0" && !preg_match("/," . $data['barang'][0]->perusahaan_id . ",/i", $this->user['perusahaan'])) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
            if ($this->user['act_wilayah'] == "0" && !preg_match("/," . $data['barang'][0]->wilayah_id . ",/i", $this->user['wilayah'])) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
            if ($this->user['act_divisi'] == "0" && !preg_match("/," . $data['barang'][0]->divisi_id . ",/i", $this->user['divisi'])) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        }
        if ($db1) $this->logModel->saveLog('Read', $idunik, $db1[0]->nodoc, '-');
        return view('tritem/pembelian/cekada_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function tambahdata()
    {
        if ($this->request->isAJAX()) {
            $konversi = ($this->request->getVar('jenis') == '1') ? ubahSeparator($this->request->getVar('konversi')) : '';
            $rule_konversi = 'permit_empty';
            $rule_ada = 'required';
            if (ubahSeparator($this->request->getVar('mada')) > ubahSeparator($this->request->getVar('jumlah'))) $rule_ada = 'required|valid_email';
            if ($this->request->getVar('jenis') == '1' && ((($this->request->getVar('satuan') != $this->request->getVar('satuan2')) && ($this->request->getVar('konversi') == '1,0000')) ||
                (($this->request->getVar('satuan') == $this->request->getVar('satuan2')) && ($this->request->getVar('konversi') != '1,0000')))) {
                $rule_konversi = 'valid_email';
            }

            $validationRules = [
                'mada' => [
                    'rules' => $rule_ada,
                    'errors' => ['required' => lang("app.errblank"), 'valid_email' => lang("app.errunik")]
                ],
                'konversi' => [
                    'rules' => $rule_konversi,
                    'errors' => ['valid_email' => lang("app.errunik")]
                ],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'mada' => $this->validation->getError('mada'),
                        'konversi' => $this->validation->getError('konversi'),
                    ]
                ];
            } else {
                $this->poanakModel->save([
                    'id' => $this->request->getVar('item'),
                    'ada' => ubahSeparator($this->request->getVar('mada')),
                    'konversi' => $konversi,
                    'is_ada' => '1',
                ]);
                $this->logModel->saveLog('Add', $this->request->getVar('idunik'), "{$this->request->getVar('nodoc')} => {$this->request->getVar('nama')}");
                $msg = ['sukses' => "{$this->request->getVar('nama')}" . lang("app.judultambah")];
            }
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
            $cekpog = $this->tranModel->cekPOgudang($db1[0]->id); //cek masih ada yg belum diperiksa
            $rule_akses = (empty($cekpog) ? 'permit_empty' : 'required');
            if ($this->request->getVar('user') == '') $rule_akses = 'valid_email';

            $validationRules = [
                'akses' => [
                    'rules' => $rule_akses,
                    'errors' => ['required' => lang("app.errunik2"), 'valid_email' => lang("app.errnoakses")]
                ],
            ];
            if (!$this->validate($validationRules)) {
                $msg = ['error' => ['akses' => $this->validation->getError('akses')]];
            } else {
                $this->pomintaModel->save(['id' => $db1[0]->id, 'status' => '7']);
                $this->logModel->saveLog('Save', $this->request->getVar('idunik'), $this->request->getVar('nodoc'));
                $this->session->setFlashdata(['judul' => $this->request->getVar('nodoc') . " " . lang("app.judulsimpan"), 'perus' => $db1[0]->perusahaan_id, 'div' => $db1[0]->divisi_id]);
                $msg = ['redirect' => '/cekada'];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
