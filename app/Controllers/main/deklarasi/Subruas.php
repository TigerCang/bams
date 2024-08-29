<?php

namespace App\Controllers\file\deklarasi;

use Config\App;
use App\Controllers\BaseController;
use App\Models\file\RuasModel;

class Subruas extends BaseController
{
    protected $ruasModel;
    public function __construct()
    {
        $this->ruasModel = new RuasModel();
    }

    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        (!preg_match("/119/i", $this->menu['menu_1'])) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $data = [
            't_menu' => lang("app.tt_subruas"), 't_submenu' => '',
            't_icon' => '<i class="fa fa-road ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-map-signs"></i>', 't_dir1' => lang("app.deklar"), 't_dir2' => lang("app.jarak"), 't_dirac' => lang("app.subruas"), 't_link' => '/subruas',
            'menu' => 'subruas', 'chid' => '', 'phid' => '', 'ket' => '',
            'camp' => $this->deklarModel->getCamp('', 't'),
            'proyek1' => $this->deklarModel->satuID('m_proyek', session()->getFlashdata('proyek') ?? '', '', 'id', 't'),
            'btnclascr' => lang('app.btncCreate'), 'btntextcr' => lang('app.btnCreate'),
            'actcreate' => ($this->user['act_create'] == '0' ? 'hidden' : ''),
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        return view('file/deklarasi/jarak_view', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function crany()
    {
        do {
            $idu = buatid();
            $db = $this->deklarModel->satuID('m_ruas', $idu);
        } while ($db);
        $this->iduModel->saveID($idu);
        return redirect()->to('/subruas/input/' . $idu);
    }

    // ____________________________________________________________________________________________________________________________
    public function showdata($idunik)
    {
        (!preg_match("/119/i", $this->menu['menu_1'])) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $db1 = $this->deklarModel->satuID('m_ruas', $idunik, 'y');
        $ticon = ($db1 ? lang("app.xdetil") : lang("app.xinput"));
        $data = [
            't_menu' => lang("app.tt_subruas"), 't_submenu' => '',
            't_icon' => '<i class="fa fa-road ' . $ticon . '"></i>',
            't_diricon' => '<i class="fa fa-map-signs"></i>', 't_dir1' => lang("app.deklar"), 't_dir2' => lang("app.jarak"), 't_dirac' => lang("app.subruas"), 't_link' => '/subruas',
            'idu' => $this->iduModel->cekID($idunik), 'idunik' => $idunik,
            'menu' => 'subruas', 'chid' => '', 'phid' => '', 'bkode' => 'off',
            'perusahaan' => $this->deklarModel->getPerusahaan('', 't'),
            'wilayah' => $this->deklarModel->getDivisi('', 'wilayah', 't'),
            'camp' => $this->deklarModel->getCamp('', 't'),
            'proyek1' => $this->deklarModel->satuID('m_proyek', $db1[0]->proyek_id ?? '', '', 'id', 't'),
            'btnhid' => ($db1 ? 'hidden' : ''),
            'btnclas1' => ($db1 ? lang('app.btncUpdate') : lang('app.btncSave')),
            'btntext1' => ($db1 ? lang('app.btnUpdate') : lang('app.btnSave')),
            'btnclas2' => (($db1 && $db1[0]->is_aktif == '0') ? lang('app.btncAktif') : lang('app.btncNoaktif')),
            'btntext2' => (($db1 && $db1[0]->is_aktif == '0') ? lang('app.btnAktif') : lang('app.btnNoaktif')),
            'btnsama' => ($db1 ? ($db1[0]->is_confirm == '1' ? 'disabled' : ($db1[0]->updated_by == $this->user['id'] ? 'disabled' : '')) : ''),
            'actcreate' => ($db1 ? ($this->user['act_edit'] == '0' ? 'disabled' : '') : ($this->user['act_create'] == '0' ? 'disabled' : '')),
            'actconf' => ($db1 ? ($this->user['act_confirm'] == '0' ? 'disabled hidden' : '') : 'disabled hidden'),
            'actaktif' => ($db1 ? ($this->user['act_aktif'] == '0' ? 'disabled hidden' : '') : 'disabled hidden'),
            'jarak' => $db1,
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        if ($db1) $this->logModel->saveLog('Read', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama}", '-');
        return view('file/deklarasi/jarak_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function savedata()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->deklarModel->satuID('m_ruas', $this->request->getVar('idunik'));
            $savj = ($db1 ? lang("app.judulubah") : lang("app.judulsimpan"));
            $cekRuas = $this->deklarModel->cekRuas($this->request->getVar('idunik'), 'subruas', $this->request->getVar('kode'), $this->request->getVar('idproyek'), $this->request->getVar('idcamp'), $this->request->getVar('ruas'));
            $rule_kode = ($cekRuas ? 'required|is_unique[m_ruas.kode]' : 'required|min_length[8]');
            $stconf = (($db1 && $db1[0]->is_confirm != '0') ? '2' : '0');
            $rule_km = ((substr($this->request->getVar('km'), 0, 1)) == '0' ? 'required|valid_email' : 'required');

            $validationRules = [
                'kode' => [
                    'rules' => $rule_kode,
                    'errors' => ['required' => lang("app.errblank"), 'min_length' => lang("app.errlength", [8]), 'is_unique' => lang("app.errunik")]
                ],
                'nama' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
                'idcamp' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
                'idproyek' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
                'idruas' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'catatan' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
                'km' => [
                    'rules' => $rule_km,
                    'errors' => ['required' => lang("app.errblank"), 'valid_email' => lang("app.errunik")]
                ],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'kode' => $this->validation->getError('kode'),
                        'nama' => $this->validation->getError('nama'),
                        'camp' => $this->validation->getError('idcamp'),
                        'proyek' => $this->validation->getError('idproyek'),
                        'ruas' => $this->validation->getError('idruas'),
                        'catatan' => $this->validation->getError('catatan'),
                        'km' => $this->validation->getError('km'),
                    ]
                ];
            } else {
                //Simpan
                if ($this->request->getVar('postaction') == 'save') {
                    $this->ruasModel->save([
                        'id' => $db1[0]->id ?? '',
                        'idunik' => $this->request->getVar('idunik'),
                        'pilihan' => 'subruas',
                        'proyek_id' => $this->request->getVar('idproyek'),
                        'ruas_id' => $this->request->getVar('idruas'),
                        'camp_id' => $this->request->getVar('idcamp'),
                        'kode' => strtoupper($this->request->getVar('kode')),
                        'nama' => $this->request->getVar('nama'),
                        'jarak' => ubahSeparator($this->request->getVar('km')),
                        'catatan' => $this->request->getVar('catatan'),
                        'is_confirm' => $stconf,
                        'updated_by' => $this->user['id'],
                        'confirmed_by' => '0',
                    ]);
                    $db1 = $this->deklarModel->satuID('m_ruas', $this->request->getVar('idunik'));
                    $this->logModel->saveLog('Save', $this->request->getVar('idunik'), "{$db1[0]->kode} ; {$db1[0]->nama}");
                    $this->session->setFlashdata(['judul' => "{$db1[0]->kode} ; {$db1[0]->nama} {$savj}", 'camp' => $db1[0]->camp_id, 'proyek' => $db1[0]->proyek_id]);
                }
                //Konfirmasi
                if ($this->request->getVar('postaction') == 'confirm') {
                    $this->ruasModel->save(['id' => $db1[0]->id, 'is_confirm' => '1', 'confirmed_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $this->request->getVar('idunik'), "{$db1[0]->kode} ; {$db1[0]->nama}");
                    $this->session->setFlashdata(['judul' => "{$db1[0]->kode} ; {$db1[0]->nama}" . lang("app.judulkonf"), 'camp' => $db1[0]->camp_id, 'proyek' => $db1[0]->proyek_id]);
                }
                //Aktifasi
                if ($this->request->getVar('postaction') == 'aktif') {
                    $akby = (($this->request->getVar('niaktif') == '0') ? $this->user['id'] : '0');
                    $savj = (($this->request->getVar('niaktif') == '0') ? lang("app.judulnoaktif") : lang("app.judulaktif"));
                    $onoff = (($this->request->getVar('niaktif') == '0') ? 'nonaktif' : 'aktif');
                    $this->ruasModel->save(['id' => $db1[0]->id, 'is_aktif' => $this->request->getVar('niaktif'), 'activated_by' => $akby]);
                    $this->logModel->saveLog('Active', $this->request->getVar('idunik'), "{$db1[0]->kode} ; {$db1[0]->nama} {$onoff}");
                    $this->session->setFlashdata(['judul' => "{$db1[0]->kode} ; {$db1[0]->nama} {$savj}", 'camp' => $db1[0]->camp_id, 'proyek' => $db1[0]->proyek_id]);
                }
                $msg = ['redirect' => '/subruas'];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function tabeldata()
    {
        if ($this->request->isAJAX()) {
            $camp = ($this->request->getvar('camp') != '' ? $this->request->getvar('camp') : '-');
            $proyek = ($this->request->getvar('proyek') != '' ? $this->request->getvar('proyek') : '');
            $data = [
                'jarak' => $this->deklarModel->getRuas($this->urls[1], 'subruas', '', $proyek, $camp),
                'menu' => 'subruas', 'chid' => '', 'phid' => '',
            ];
            $msg = ['data' => view('x-file/jarak_tabel', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
