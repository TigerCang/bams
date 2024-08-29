<?php

namespace App\Controllers\hrd;

use Config\App;
use App\Controllers\BaseController;
use App\Models\hrd\HrdcutiModel;
use App\Models\extra\LogaksiModel;

class Cekitmk extends BaseController
{
    protected $hrdcutiModel;
    protected $logaksiModel;

    public function __construct()
    {
        $this->hrdcutiModel = new HrdcutiModel();
        $this->logaksiModel = new LogaksiModel();
    }

    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        // (!preg_match("/118/i", $this->session->menu->menu_1)) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();      
        $db2 = $this->deklarModel->getBiodata($this->session->menu->id, 't');
        $pegawai = $db2['0']->atasan_id ?? '';
        $mode = 'atasan';
        $data = [
            't_menu' => lang("app.tt_cekijincuti"),
            't_submenu' => '',
            't_icon' => '<i class="fa fa-money ' . lang("app.xinput") . '"></i>',
            't_diricon' => '<i class="fa fa-money"></i>',
            't_dir1' => lang("app.mintakas"),
            't_dirac' => lang("app.tandat"),
            't_link' => '/cekitmk',
            'menu' => 'cekitmk',
            'tandat' => '1',
            'mode' => $mode,
            'peminta' => '',
            'pegawai' => $pegawai,
            'tuser' => $this->user,
        ];

        return view('hrd/mintacuti_view', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function showdata($idunik)
    {
        // (!preg_match("/118/i", $this->session->menu->menu_1)) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();      
        $db1 = $this->deklarModel->satuID('hrd_cuti', $idunik);
        $db2 = $this->deklarModel->getBiodata($this->session->menu->id);
        $pegawai = $db2['0']->id ?? '';
        $level = $db2['0']->level ?? '';

        $data = [
            't_menu' => lang("app.tt_cekijincuti"),
            't_submenu' => '',
            't_icon' => '<i class="fa fa-money ' . lang("app.xinput") . '"></i>',
            't_diricon' => '<i class="fa fa-money"></i>',
            't_dir1' => lang("app.mintakas"),
            't_dirac' => lang("app.tandat"),
            't_link' => '/cekitmk',
            'idunik' => $idunik,
            'minta' => $this->deklarModel->satuID('hrd_cuti', $idunik),
            'selnama' => $this->deklarModel->distSelect('aksiproses'),
            'perusahaan1' => $this->deklarModel->satuID('m_perusahaan', $db1['0']->perusahaan_id, 't'),
            'divisi1' => $this->deklarModel->satuID('m_divisi', $db1['0']->divisi_id, 't'),
            'wilayah1' => $this->deklarModel->satuID('m_divisi', $db1['0']->wilayah_id, 't'),
            'pegawai1' => $this->deklarModel->satuID('m_pegawai', $db1['0']->pegawai_id, 't'),
            'kategori1' => $this->deklarModel->satuID('m_divisi', $db1['0']->cuti_id, 't'),
            'menu' => 'cekitmk',
            'userid' => $pegawai,
            'level' => $level,
            'tuser' => $this->user,
        ];

        (empty($data['minta'])) && throw new \CodeIgniter\Exceptions\PageNotFoundException();
        return view('hrd/cekcuti_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function savedata($idunik)
    {
        if (!$this->validate([
            'catatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang("app.errblank"),
                ]
            ]
        ])) {
            return redirect()->to('/cekitmk/input/' . $this->request->getVar('idunik'))->withInput();
        }

        $this->logaksiModel->save([
            'idunik' => $this->request->getVar('idunik'),
            'user_id' => $this->request->getVar('iduser'),
            'menu' => 'mintacuti',
            'aksi' => $this->request->getVar('aksi'),
            'nodoc' => $this->request->getVar('nodoc'),
            'level' => $this->request->getVar('levsetuju'),
            'catatan' => $this->request->getVar('catatan'),
            'ip_address' => get_ip(),
        ]);

        $db = $this->deklarModel->satuID('hrd_cuti', $this->request->getVar('idunik'));
        $actions = array('terima' => '0', 'revisi' => '1', 'tolak' => '2');
        $field = $actions[$this->request->getVar('aksi')] == '0' ? 'st_atasan' : '';
        $this->tranModel->updateHrdcuti($this->request->getVar('idunik'), $field, $actions[$this->request->getVar('aksi')], '');

        $this->logModel->savelog('/cekcuti', 'Save', $db['0']->id, $this->request->getVar('aksi') . ' => ' . $this->request->getVar('nodoc'));
        $this->session->setflashdata(['judul' => $this->request->getVar('nodoc') . ' ' . lang("app.judulsimpan")]);
        return redirect()->to('/cekitmk');
    }
}
