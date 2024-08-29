<?php

namespace App\Controllers\tritem\pembelian;

use Config\App;
use App\Controllers\BaseController;
use App\Models\tritem\POmintaModel;
use App\Models\extra\LogaksiModel;

class Cekbarang extends BaseController
{
    protected $pomintaModel;
    protected $logaksiModel;
    public function __construct()
    {
        $this->pomintaModel = new POmintaModel();
        $this->logaksiModel = new LogaksiModel();
    }

    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        // (!preg_match("/107/i", $this->menu['menu_1'])) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $data = [
            't_menu' => lang("app.tt_cekmintabarang"), 't_submenu' => '',
            't_icon' => '<i class="icofont icofont-stamp ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="icofont icofont-stamp"></i>', 't_dir1' => lang("app.mintabarang"), 't_dirac' => lang("app.tandat"), 't_link' => '/cekbarang',
            'menu' => 'cekbarang', 'baru' => 'hidden', 'filstat' => 'hidden', 'filcek' => '',
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
            't_menu' => lang("app.tt_cekmintabarang"), 't_submenu' => '',
            't_icon' => '<i class="icofont icofont-stamp ' . lang("app.xinput") . '"></i>',
            't_diricon' => '<i class="icofont icofont-stamp"></i>', 't_dir1' => lang("app.mintabarang"), 't_dirac' => lang("app.tandat"), 't_link' => '/cekbarang',
            'idunik' => $idunik,
            'perusahaan' => $this->deklarModel->getPerusahaan('', 't'),
            'wilayah' => $this->deklarModel->getDivisi('', 'wilayah', 't'),
            'divisi' => $this->deklarModel->getDivisi('', 'divisi', 't'),
            'selaksi' => $this->deklarModel->distSelect('aksiproses'),
            'user1' => $this->deklarModel->get1User($db1[0]->peminta_id),
            'barang' => $db1,
            'anak' => $this->tranModel->getPOanak($db1[0]->id ?? '', ''),
            'levpos' => $db1[0]->level_pos == '0' ? $this->level[0]['nilai'] : $db1[0]->level_pos - 1,
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        (empty($data['barang'])) && throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($data['barang']) {
            if ($this->user['act_perusahaan'] == "0" && !preg_match("/," . $data['barang'][0]->perusahaan_id . ",/i", $this->user['perusahaan'])) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
            if ($this->user['act_wilayah'] == "0" && !preg_match("/," . $data['barang'][0]->wilayah_id . ",/i", $this->user['wilayah'])) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
            if ($this->user['act_divisi'] == "0" && !preg_match("/," . $data['barang'][0]->divisi_id . ",/i", $this->user['divisi'])) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        }
        if ($db1) $this->logModel->saveLog('Read', $idunik, $db1[0]->nodoc, '-');
        return view('tritem/pembelian/cekbarang_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function savedata()
    {
        if ($this->request->isAJAX()) {
            $validationRules = [
                'iduser' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errnoakses")]
                ],
                'catatan' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'iduser' => $this->validation->getError('iduser'),
                        'catatan' => $this->validation->getError('catatan'),
                    ]
                ];
            } else {
                $pominta1 = $this->deklarModel->satuID('po_minta', $this->request->getVar('idunik'));
                $aksiStatus = ['cek' => '2', 'terima' => '2', 'revisi' => '3', 'tolak' => '4'];
                $status = $aksiStatus[$this->request->getVar('aksi')];
                $konf = $this->konfigurasiModel->getKonfigurasi('acc_mintaitem');
                if ($konf[0]['nilai'] == $this->request->getVar('xlevel') && $status == '2') $status = '6';
                $this->logaksiModel->save([
                    'idunik' => $this->request->getVar('idunik'),
                    'user_id' => $this->request->getVar('iduser'),
                    'menu' => $this->urls[1],
                    'pilihan' => 'cek',
                    'aksi' => $this->request->getVar('aksi'),
                    'data' => $this->request->getVar('nodoc'),
                    'level' => $this->request->getVar('xlevel'),
                    'st_seru' => ($this->request->getVar('seru') == 'on' ? '1' : '0'),
                    'catatan' => $this->request->getVar('catatan'),
                    'ip_address' => session()->ipaddress,
                ]);
                $poslev = ($this->request->getVar('xlevel') == '0' ? $pominta1[0]->level_pos : $this->request->getVar('xlevel'));
                if ($status == '3') $poslev = $pominta1[0]->level_aw;
                $this->pomintaModel->save([
                    'id' => $pominta1[0]->id,
                    'last_id' => $this->request->getVar('iduser'),
                    'level_pos' => $poslev,
                    'st_seru' => ($this->request->getVar('seru') == 'on' ? '1' : '0'),
                    'status' => $status,
                ]);
                $this->logModel->saveLog('Save', $this->request->getVar('idunik'), "{$this->request->getVar('nodoc')} => {$this->request->getVar('aksi')}");
                $this->session->setFlashdata(['judul' => "{$this->request->getVar('nodoc')} => {$this->request->getVar('aksi')}" . " " . lang("app.judulsimpan"), 'perus' => $pominta1[0]->perusahaan_id, 'div' => $pominta1[0]->divisi_id]);
                $msg = ['redirect' => '/cekbarang'];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
