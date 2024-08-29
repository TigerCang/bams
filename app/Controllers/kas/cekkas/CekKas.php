<?php

namespace App\Controllers\kas\cekkas;

use Config\App;
use App\Controllers\BaseController;
use App\Models\kas\KasindukModel;

class Cekkas extends BaseController
{
    protected $kasindukModel;
    // protected $logaksiModel;
    public function __construct()
    {
        $this->kasindukModel = new KasindukModel();
    }

    public function index()
    {
        checkPage('102');
        $data = [
            't_judul' => lang('app.tanda tangan'),
            't_span' => lang('app.span tanda tangan'),
            'link' => '/cekkas',
            'perusahaan' => $this->mainModel->getPerusahaan('', 't'),
            'divisi' => $this->mainModel->getBerkas('', 'divisi', 't'),
            'param' => '',
            'cari1' => 'hidden',
            'cari2' => '',
            'idunik' => buatID(120),
        ];
        $this->iduModel->saveUnik($data['idunik']);
        $this->render('kas/mintakas/mintakas_list', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function inputData()
    {
        $db1 = $this->mainModel->satuID('kas_induk', $this->request->getVar('datakey'));
        if ($db1) {
            checkPage('101', $db1, 'y', 'n');
        } else {
            $dbid = $this->mainModel->satuID('id_unik', $this->request->getVar('datakey'), '', 'idunik', '', 't');
            checkPage('101', $dbid, 'y', 'n');
        }
        // $buttons = setButton($db1);
        // if ($db1) $this->logModel->saveLog('Read', $this->request->getVar('datakey'), "{$db1[0]->kode} ; {$db1[0]->nama}");
        $data = [
            't_judul' => lang('app.tanda tangan'),
            't_span' => lang('app.span tanda tangan'),
            'link' => '/cekkas',
            'perusahaan' => $this->mainModel->getPerusahaan('', 't'),
            'wilayah' => $this->mainModel->getBerkas('', 'wilayah', 't'),
            'divisi' => $this->mainModel->getBerkas('', 'divisi', 't'),
            'selbeban' => $this->mainModel->distSelect('beban'),
            'selaksi' => $this->mainModel->distSelect('aksi'),
            'dokumen' => $this->mainModel->cekForm('dokumen', 'uang  jalan', '', 't'),
            'user1' => $this->mainModel->get1User($db1[0]->user_id ?? $this->user['id']),
            'penerima1' => $this->mainModel->satuID('m_penerima', $db1[0]->penerima_id ?? '', '', 'id'),
            'idunik' => $this->request->getVar('datakey'),
            'kas' => $db1,
            'kasanak' => $this->mainModel->satuID('kas_anak', $db1[0]->id ?? '', '', 'kasinduk_id'),
            // 'button' => ['save' => $buttons['bsave'], 'conf' => $buttons['bconf'], 'del' => $buttons['bdel'], 'aktif' => $buttons['baktif']],
        ];
        $this->render('kas/mintakas/cekkas_input', $data);
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
