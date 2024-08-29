<?php

namespace App\Controllers\file\item;

use Config\App;
use App\Controllers\BaseController;
use App\Models\file\SerialModel;

class Noseri extends BaseController
{
    protected $serialModel;
    public function __construct()
    {
        $this->serialModel = new SerialModel();
    }

    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        (!preg_match("/136/i", $this->menu['menu_1'])) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $data = [
            't_menu' => lang("app.tt_serial"), 't_submenu' => '',
            't_icon' => '<i class="fa fa-braille ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-cubes"></i>', 't_dir1' => lang("app.item"), 't_dirac' => lang("app.sn"), 't_link' => '/noseri',
            'barang' => $this->deklarModel->getBarang('', 'barang', '', '1'),
            'btnclascr' => lang('app.btncCreate'), 'btntextcr' => lang('app.btnCreate'),
            'actcreate' => ($this->user['act_create'] == '0' ? 'hidden' : ''),
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        return view('file/item/serial_view', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function crany()
    {
        do {
            $idu = buatid();
            $db = $this->deklarModel->satuID('m_serial', $idu);
        } while ($db);
        $this->iduModel->saveID($idu);
        return redirect()->to('/noseri/input/' . $idu);
    }

    // ____________________________________________________________________________________________________________________________
    public function showdata($idunik)
    {
        (!preg_match("/136/i", $this->menu['menu_1'])) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $db1 = $this->deklarModel->satuID('m_serial', $idunik, 'y');
        $ticon = ($db1 ? lang("app.xdetil") : lang("app.xinput"));
        $data = [
            't_menu' => lang("app.tt_serial"), 't_submenu' => '',
            't_icon' => '<i class="fa fa-braille ' . $ticon . '"></i>',
            't_diricon' => '<i class="fa fa-cubes"></i>', 't_dir1' => lang("app.item"), 't_dirac' => lang("app.sn"), 't_link' => '/noseri',
            'idu' => $this->iduModel->cekID($idunik), 'idunik' => $idunik,
            'barang' => $this->deklarModel->getBarang('', 'barang', '', '1'),
            'alat1' => $this->deklarModel->satuID('m_alat', $db1[0]->alat_id ?? '', '', 'id', 't'),
            'btnhid' => ($db1 ? 'hidden' : ''),
            'btnclas1' => ($db1 ? lang('app.btncUpdate') : lang('app.btncSave')),
            'btntext1' => ($db1 ? lang('app.btnUpdate') : lang('app.btnSave')),
            'btnclas2' => (($db1 && $db1[0]->is_aktif == '0') ? lang('app.btncAktif') : lang('app.btncNoaktif')),
            'btntext2' => (($db1 && $db1[0]->is_aktif == '0') ? lang('app.btnAktif') : lang('app.btnNoaktif')),
            'btnsama' => ($db1 ? ($db1[0]->is_confirm == '1' ? 'disabled' : ($db1[0]->updated_by == $this->user['id'] ? 'disabled' : '')) : ''),
            'actcreate' => ($db1 ? ($this->user['act_edit'] == '0' ? 'disabled' : '') : ($this->user['act_create'] == '0' ? 'disabled' : '')),
            'actconf' => ($db1 ? ($this->user['act_confirm'] == '0' ? 'disabled hidden' : '') : 'disabled hidden'),
            'actaktif' => ($db1 ? ($this->user['act_aktif'] == '0' ? 'disabled hidden' : '') : 'disabled hidden'),
            'serial' => $db1,
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        (empty($data['serial']) && empty($data['idu'])) && throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($db1) $this->logModel->saveLog('Read', $idunik, $db1[0]->noseri, '-');
        return view('file/item/serial_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function savedata()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->deklarModel->satuID('m_serial', $this->request->getVar('idunik'));
            $savj = ($db1 ? lang("app.judulubah") : lang("app.judulsimpan"));
            $rule_kode = ($db1 ? ($db1[0]->noseri != $this->request->getVar('noseri') ? 'required|is_unique[m_serial.noseri]' : 'required') : 'required|is_unique[m_serial.noseri]');
            $stconf = (($db1 && $db1[0]->is_confirm != '0') ? '2' : '0');

            $validationRules = [
                'noseri' => [
                    'rules' => $rule_kode,
                    'errors' => ['required' => lang("app.errblank"), 'is_unique' => lang("app.errunik")]
                ],
                'barang' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'harga' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'barang' => $this->validation->getError('barang'),
                        'noseri' => $this->validation->getError('noseri'),
                        'harga' => $this->validation->getError('harga'),
                    ]
                ];
            } else {
                //Simpan
                if ($this->request->getVar('postaction') == 'save') {
                    $this->serialModel->save([
                        'id' => $db1[0]->id ?? '',
                        'idunik' => $this->request->getVar('idunik'),
                        'barang_id' => $this->request->getVar('barang'),
                        'noseri' => $this->request->getVar('noseri'),
                        'harga' => ubahSeparator($this->request->getVar('harga')),
                        'alat_id' => $this->request->getVar('alat') ?? '',
                        'reparasi' => $this->request->getVar('perbaikan'),
                        'is_confirm' => $stconf,
                        'updated_by' => $this->user['id'],
                        'confirmed_by' => '0',
                    ]);
                    $db1 = $this->deklarModel->satuID('m_serial', $this->request->getVar('idunik'));
                    $this->logModel->saveLog('Save', $this->request->getVar('idunik'), $db1[0]->noseri);
                    $this->session->setFlashdata(['judul' => "{$db1[0]->noseri} {$savj}", 'barang' => $db1[0]->barang_id]);
                }
                //Konfirmasi
                if ($this->request->getVar('postaction') == 'confirm') {
                    $this->serialModel->save(['id' => $db1[0]->id, 'is_confirm' => '1', 'confirmed_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $this->request->getVar('idunik'), $db1[0]->noseri);
                    $this->session->setFlashdata(['judul' => $db1[0]->noseri . lang("app.judulkonf"), 'barang' => $db1[0]->barang_id]);
                }
                //Aktifasi
                if ($this->request->getVar('postaction') == 'aktif') {
                    $akby = (($this->request->getVar('niaktif') == '0') ? $this->user['id'] : '0');
                    $savj = (($this->request->getVar('niaktif') == '0') ? lang("app.judulnoaktif") : lang("app.judulaktif"));
                    $onoff = (($this->request->getVar('niaktif') == '0') ? 'nonaktif' : 'aktif');
                    $this->serialModel->save(['id' => $db1[0]->id, 'is_aktif' => $this->request->getVar('niaktif'), 'activated_by' => $akby]);
                    $this->logModel->saveLog('Active', $this->request->getVar('idunik'), "{$db1[0]->noseri} {$onoff}");
                    $this->session->setFlashdata(['judul' => "{$db1[0]->noseri} {$savj}", 'barang' => $db1[0]->barang_id]);
                }
                $msg = ['redirect' => '/noseri'];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function tabelbarang()
    {
        if ($this->request->isAJAX()) {
            $barang = ($this->request->getvar('barang') != 'all' ? $this->request->getvar('barang') : '');
            $data = ['serial' => $this->deklarModel->getSerial($this->urls[1], $barang)];
            $msg = ['data' => view('x-file/serial_tabel', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
