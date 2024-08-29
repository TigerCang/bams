<?php

namespace App\Controllers;

use Config\App;
use App\Controllers\BaseController;
use App\Models\admin\UserModel;

class Home extends BaseController
{
    protected $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            //     't_menu' => lang("app.dasbor"), 't_submenu' => '',
            //     't_icon' => '<i class="feather icon-home ' . lang("app.xlist") . '"></i>',
            //     't_diricon' => '<i class="icofont icofont-ui-home"></i>', 't_dir1' => lang("app.home"), 't_dirac' => lang("app.dasbor"), 't_link' => '/',
            'tuser' => $this->user,
            'tmenu' => $this->menu,
            'template' => (splitUser('tampilan', $this->user)[0]),
        ];
        // return view('dashboard/home', $data);
        // $anu = splituser('tampilan', $this->user);
        // dd($anu[0]);
        return view('dashboard/home', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function profilpegawai()
    {
        $data = [
            't_menu' => lang("app.tt_userprofil"),
            't_submenu' => '',
            't_icon' => '<i class="icofont icofont-business-man ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-home"></i>',
            't_dir1' => lang("app.home"),
            't_dirac' => lang("app.profil"),
            't_link' => '/profile',
            'biodata' => $this->deklarModel->getBiodata($this->user['id']),
            'tuser' => $this->user,
            'tmenu' => $this->menu,
        ];
        (empty($data['biodata'])) && throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('home/biodata_view', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function sandi()
    {
        $data = [
            't_menu' => lang("app.tt_gantisandi"),
            't_submenu' => '',
            't_icon' => '<i class="fa fa-unlock-alt ' . lang("app.xinput") . '"></i>',
            't_diricon' => '<i class="fa fa-home"></i>',
            't_dir1' => lang("app.home"),
            't_dirac' => lang("app.sandi"),
            't_link' => '/sandi',
            'tuser' => $this->user,
            'tmenu' => $this->menu,
        ];
        return view('home/gantipass_input', $data);
    }
    public function savepass()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->deklarModel->satuID('m_user', $this->request->getVar('idunik'));
            $passlama = password_verify($this->request->getVar('passlama'), $db1['0']->password);
            $rule_passlama = (!$passlama) ? 'valid_email' : 'required';
            $rule_passbaru = ($this->request->getVar('passbaru') != $this->request->getVar('konfirmasi')) ? 'valid_email' : 'required|password_strength[8]';
            $rule_konfirmasi = ($this->request->getVar('passbaru') != $this->request->getVar('konfirmasi')) ? 'valid_email' : 'required';

            $validationRules = [
                'passlama' => [
                    'rules' => $rule_passlama,
                    'errors' => ['required' => lang("app.errblank"), 'valid_email' => lang("app.salahpass")]
                ],
                'passbaru' => [
                    'rules' => $rule_passbaru,
                    'errors' => ['required' => lang("app.errblank"), 'password_strength' => lang("app.passstrong"), 'valid_email' => lang("app.salahpass")]
                ],
                'konfirmasi' => [
                    'rules' => $rule_konfirmasi,
                    'errors' => ['required' => lang("app.errblank"), 'valid_email' => lang("app.salahpass")]
                ],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'passlama' => $this->validation->getError('passlama'),
                        'passbaru' => $this->validation->getError('passbaru'),
                        'konfirmasi' => $this->validation->getError('konfirmasi'),
                    ]
                ];
            } else {
                $password = password_hash($this->request->getVar('passbaru'), PASSWORD_DEFAULT);
                $this->userModel->save(['id' => $db1['0']->id, 'password' => $password]);
                $this->logModel->saveLog('w', $this->request->getVar('idunik'), $db1[0]->kode);
                $this->session->setFlashdata(['judul' => lang("app.passsukses")]);
                $msg = ['redirect'];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function logdata()
    {
        $data = [
            't_menu' => lang("app.tt_aktifitas"),
            't_submenu' => '',
            't_icon' => '<i class="icofont icofont-list ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-home"></i>',
            't_dir1' => lang("app.home"),
            't_dirac' => lang("app.aktifitas"),
            't_link' => '/logdata',
            'user' => $this->deklarModel->getUser('', '', 't'),
            'uhid' => 'hidden',
            'tuser' => $this->user,
            'tmenu' => $this->menu,
        ];
        return view('file/admin/loguser_view', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function bahasa()
    {
        $session = session();
        $locale = $this->request->getLocale();
        $session->remove('lang');
        $session->set('lang', $locale);
        $backUrl = $this->request->getServer('HTTP_REFERER'); // Ambil URL sebelumnya
        return redirect()->to($backUrl);
    }

    // _________________________________________________________________________________________________________________________
    public function modaldata()
    {
        if ($this->request->isAJAX()) {
            $data = ['idunik' => "aby",];
            $msg = ['data' => view('x-modal/cari_data', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
