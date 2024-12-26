<?php

namespace App\Controllers\trkas\pengeluaran;

use Config\App;
use App\Controllers\BaseController;
use App\Models\trkas\KasindukModel;
use App\Models\trkas\KasanakModel;
use App\Models\extra\LogaksiModel;

class Keuangan extends BaseController
{
    protected $kasindukModel;
    protected $kasanakModel;
    protected $logaksiModel;
    public function __construct()
    {
        $this->kasindukModel = new KasindukModel();
        $this->kasanakModel = new KasanakModel();
        $this->logaksiModel = new LogaksiModel();
    }

    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        // (!preg_match("/118/i", $this->session->menu->menu_1)) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();      
        $data = [
            't_menu' => strtoupper(lang("app.keuangan")), 't_submenu' => '',
            't_icon' => '<i class="fa fa-money ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-money"></i>', 't_dir1' => lang("app.mintakas"), 't_dirac' => lang("app.keuangan"), 't_link' => '/keuangan',
            'menu' => 'keuangan', 'baru' => 'hidden', 'filstat' => 'hidden', 'filcek' => '',
            'perusahaan' => $this->deklarModel->getPerusahaan('', 't'),
            'divisi' => $this->deklarModel->getDivisi('', 'divisi', 't'),
            'selbeban' => $this->deklarModel->distSelect('beban'),
            'btnclascr' => lang('app.btncCreate'), 'btntextcr' => lang('app.btnCreate'),
            'actcreate' => ($this->user['act_create'] == '0' ? 'hidden' : ''),
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        return view('trkas/pengeluaran/mintakas_view', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function showdata($idunik)
    {
        // (!preg_match("/118/i", $this->session->menu->menu_1)) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();      
        $db1 = $this->deklarModel->satuID('kas_induk', $idunik);
        $beban = ($db1 ? 'm_' . $db1[0]->tujuan : 'm_proyek');
        $data = [
            't_menu' => strtoupper(lang("app.potongpajak")), 't_submenu' => '',
            't_icon' => '<i class="fa fa-money ' . lang("app.xinput") . '"></i>',
            't_diricon' => '<i class="fa fa-money"></i>', 't_dir1' => lang("app.mintakas"), 't_dirac' => lang("app.tandat"), 't_link' => '/potongpajak',
            'menu' => 'potongpajak',
            'idunik' => $idunik,
            'perusahaan' => $this->deklarModel->getPerusahaan('', 't'),
            'wilayah' => $this->deklarModel->getDivisi('', 'wilayah', 't'),
            'divisi' => $this->deklarModel->getDivisi('', 'divisi', 't'),
            'selaksi' => $this->deklarModel->distSelect('aksiproses'),
            'selbeban' => $this->deklarModel->distSelect('beban'),
            'user1' => $this->deklarModel->get1User($db1[0]->peminta_id),
            'beban1' => $this->deklarModel->satuID($beban, $db1[0]->beban_id ?? '', '', 'id', 't'),
            'penerima1' => $this->deklarModel->satuID('m_penerima', $db1['0']->penerima_id, '', 'id'),
            'kbli1' => $this->deklarModel->satuID('m_kbli', $db1['0']->kbli_id, '', 'id'),
            'anakbiaya' => $this->tranModel->getKasanak($db1[0]->id ?? '', 'in_pph', '1'),
            'dokumenref' => $this->deklarModel->distItem('m_kbli', 'nama', 'dokumenref'),
            'objekpajak' => $this->deklarModel->distKBLI('objekpajak'),
            'kas' => $db1,
            'anak' => $this->tranModel->getKasanak($db1[0]->id ?? ''),
            // 'levpos' => $db1[0]->level_pos == '0' ? $this->level[0]['nilai'] : $db1[0]->level_pos - 1,
            'levpos' => '0',
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        // dd($data['anakbiaya']);
        (empty($data['kas'])) && throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($data['kas']) {
            if ($this->user['act_perusahaan'] == "0" && !preg_match("/," . $data['kas'][0]->perusahaan_id . ",/i", $this->user['perusahaan'])) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
            if ($this->user['act_wilayah'] == "0" && !preg_match("/," . $data['kas'][0]->wilayah_id . ",/i", $this->user['wilayah'])) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
            if ($this->user['act_divisi'] == "0" && !preg_match("/," . $data['kas'][0]->divisi_id . ",/i", $this->user['divisi'])) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        }
        if ($db1) $this->logModel->saveLog('Read', $idunik, $db1[0]->nodoc, '-');
        return view('trkas/pengeluaran/keuangan_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function pajakdata()
    {
        if ($this->request->isAJAX()) {
            $anak1 = $this->deklarModel->satuID('kas_anak', $this->request->getVar('id'), '', 'id');
            $pajak = ($anak1[0]->in_potong == '0' ? '1' : '0');
            $this->kasanakModel->save(['id' =>  $this->request->getVar('id'), 'in_potong' => $pajak]);
            $msg = ['sukses' => $this->request->getVar('biaya') . ' ' . lang("app.judulubah")];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function savedokumen()
    {
        if (!$this->validate([
            'catatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang("app.errblank"),
                ]
            ]
        ])) {
            return redirect()->to('/cekkas/input/' . $this->request->getVar('idunik'))->withInput();
        }

        $this->logaksiModel->save([
            'idunik' => $this->request->getVar('idunik'),
            'user_id' => $this->request->getVar('iduser'),
            'menu' => 'mintakas',
            'aksi' => $this->request->getVar('aksi'),
            'nodoc' => $this->request->getVar('nodoc'),
            'level' => $this->request->getVar('levsetuju'),
            'catatan' => $this->request->getVar('catatan'),
            'ip_address' => get_ip(),
        ]);

        $db = $this->deklarModel->satuID('kas_induk', $this->request->getVar('idunik'));
        $actions = array('cek' => '2', 'terima' => '2', 'revisi' => '3', 'tolak' => '4');
        $status = (($db['0']->status) >= 6) ? $db['0']->status : $actions[$this->request->getVar('aksi')];
        $cek = ($this->request->getVar('aksi') == 'cek') ? '1' : '';
        $dbuser = $this->deklarModel->getuser($this->session->username, 't');
        $dbkas = $this->tranModel->getsumKasanak($db['0']->id);
        $setuju = ($this->request->getVar('aksi') == 'terima') ? (($dbuser['0']->batasacc * 1 >= $dbkas['0']->debit - $dbkas['0']->kredit) ? '1' : '') : '';

        $this->tranModel->updateKasinduk($this->request->getVar('idunik'), $this->request->getVar('levsetuju'), $status, $cek, $setuju, '');
        $indukbaru = $this->deklarModel->satuID('kas_induk', $this->request->getVar('idunik'));
        $this->tranModel->updateBayarKas($indukbaru['0']->id, $indukbaru['0']->st_cek, $indukbaru['0']->st_setuju, $indukbaru['0']->st_pajak);
        $this->logModel->savelog('/cekkas', 'Save', $db['0']->id, $this->request->getVar('aksi') . ' => ' . $this->request->getVar('nodoc'));
        $this->session->setflashdata(['judul' => $this->request->getVar('nodoc') . ' ' . lang("app.judulsimpan"), 'perus' => $db['0']->perusahaan_id, 'div' => $db['0']->divisi_id]);
        return redirect()->to('/cekkas');
    }
}
