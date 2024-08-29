<?php

namespace App\Controllers\file\penerima;

use Config\App;
use App\Controllers\BaseController;
use App\Models\file\PerusahaanModel;

class Tautp extends BaseController
{
    protected $perusahaanModel;
    public function __construct()
    {
        $this->perusahaanModel = new PerusahaanModel();
    }

    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        (!preg_match("/142/i", $this->menu['menu_1'])) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $data = [
            't_menu' => lang("app.tt_tautperusahaan"), 't_submenu' => '',
            't_icon' => '<i class="icofont icofont-link ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="icofont icofont-link"></i>', 't_dir1' => lang("app.penerima"), 't_dirac' => lang("app.tautperusahaan"), 't_link' => '/tautp',
            'menu' => 'tautp', 'phid' => '', 'ahid' => 'hidden',
            'perusahaan' => $this->deklarModel->getPerusahaan($this->urls[1]),
            'btnclascr' => lang('app.btncCreate'), 'btntextcr' => lang('app.btnCreate'),
            'actcreate' => ($this->user['act_create'] == '0' ? 'hidden' : ''),
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        return view('file/deklarasi/perusahaan_view', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function showdata($idunik)
    {
        (!preg_match("/142/i", $this->menu['menu_1'])) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $db1 = $this->deklarModel->satuID('m_perusahaan', $idunik, 'y');
        $ticon = ($db1 ? lang("app.xdetil") : lang("app.xinput"));
        $data = [
            't_menu' => lang("app.tt_tautperusahaan"), 't_submenu' => '',
            't_icon' => '<i class="icofont icofont-link ' . $ticon . '"></i>',
            't_diricon' => '<i class="icofont icofont-link"></i>', 't_dir1' => lang("app.penerima"), 't_dirac' => lang("app.tautperusahaan"), 't_link' => '/tautp',
            'idu' => $this->iduModel->cekID($idunik), 'idunik' => $idunik,
            'penerima1' => $this->deklarModel->satuID('m_penerima', $db1[0]->penerima_id ?? '', '', 'id', 't'),
            'menu' => 'tautp', 'phid' => '', 'ahid' => 'hidden', 'penro' => 'readonly',
            'btnhid' => ($db1 ? 'hidden' : ''), 'btnlam' => 'hidden',
            'btnclas1' => ($db1 ? lang('app.btncUpdate') : lang('app.btncSave')),
            'btntext1' => ($db1 ? lang('app.btnUpdate') : lang('app.btnSave')),
            'btnclas2' => (($db1 && $db1[0]->is_aktif == '0') ? lang('app.btncAktif') : lang('app.btncNoaktif')),
            'btntext2' => (($db1 && $db1[0]->is_aktif == '0') ? lang('app.btnAktif') : lang('app.btnNoaktif')),
            'btnsama' => ($db1 ? ($db1[0]->is_confirm == '1' ? 'disabled' : ($db1[0]->updated_by == $this->user['id'] ? 'disabled' : '')) : ''),
            'actcreate' => ($db1 ? ($this->user['act_edit'] == '0' ? 'disabled' : '') : ($this->user['act_create'] == '0' ? 'disabled' : '')),
            'actconf' => ($db1 ? ($this->user['act_confirm'] == '0' ? 'disabled hidden' : '') : 'disabled hidden'),
            'actaktif' => ($db1 ? ($this->user['act_aktif'] == '0' ? 'disabled hidden' : '') : 'disabled hidden'),
            'perusahaan' => $db1,
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        (empty($data['perusahaan']) && empty($data['idu'])) && throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($db1) $this->logModel->saveLog('Read', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama}", '-');
        return view('file/deklarasi/perusahaan_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function savedata()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->deklarModel->satuID('m_perusahaan', $this->request->getVar('idunik'));
            $validationRules = [
                'penerima' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
            ];
            if (!$this->validate($validationRules)) {
                $msg = ['error' => ['penerima' => $this->validation->getError('penerima')]];
            } else {
                //Simpan
                if ($this->request->getVar('postaction') == 'save') {
                    $this->perusahaanModel->save(['id' => $db1[0]->id, 'penerima_id' => $this->request->getVar('penerima')]);
                    $this->logModel->saveLog('Save', $this->request->getVar('idunik'), "{$db1[0]->kode} ; {$db1[0]->nama}");
                    $this->session->setFlashdata(['judul' => "{$db1[0]->kode} ; {$db1[0]->nama}" . " " . lang("app.judulubah")]);
                }
                $msg = ['redirect' => '/tautp'];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
