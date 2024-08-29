<?php

namespace App\Controllers\admin;

use Config\App;
use App\Controllers\BaseController;

class User extends BaseController
{
    public function index()
    {
        checkPage('102');
        $data = [
            't_judul' => lang('app.user'),
            't_span' => lang('app.span user'),
            'link' => '/user',
            'user' => $this->mainModel->getUser($this->urls[1]),
        ];
        $this->render('admin/user_list', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function inputData()
    {
        $db1 = $this->mainModel->satuID('m_user', $this->request->getVar('datakey'), 'u');
        checkPage('101', $db1, 'y', 'n');
        $buttons = setButton($db1);
        if ($this->request->getVar('datakey')) $this->logModel->saveLog('Read', $this->request->getVar('datakey'), "{$db1[0]->kode}");

        $data = [
            't_judul' => lang('app.user'),
            't_span' => lang('app.span user'),
            'link' => "/user",
            'perusahaan' => $this->mainModel->getPerusahaan('', 't'),
            'wilayah' => $this->mainModel->getBerkas('', 'wilayah', 't'),
            'divisi' => $this->mainModel->getBerkas('', 'divisi', 't'),
            'jabatan' => $this->mainModel->getBerkas('', 'jabatan', 't'),
            'proyek' => $this->mainModel->getProyek('', 't'),
            'cabang' => $this->mainModel->getCabang('', 't'),
            'alat' => $this->mainModel->getAlat('', 't', 'multi'),
            'tanah' => $this->mainModel->getTanah('', 't'),
            'kasbank' => $this->mainModel->getKelakun('', 'kas', 't'),
            'role' => $this->mainModel->getRole('', 't'),
            'token' => $this->mainModel->getToken('', $db1[0]->token_id),
            'useratas' => $this->mainModel->satuID('m_user', $db1[0]->atasan_id ?? '', '', 'kode', 't'),
            'user' => $db1,
            'button' => ['save' => $buttons['bsave'], 'conf' => $buttons['bconf'], 'del' => $buttons['bdel'], 'aktif' => $buttons['baktif']],
            'btnaktif' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.btn aktif') : lang('app.btn inaktif')),
            'acby' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.inacby') : lang('app.acby')),
        ];
        $this->render('admin/user_input', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->satuID('m_user', $this->request->getVar('idunik'));
            $rule_atasan = ($this->request->getVar('usernama') == $this->request->getVar('atasan') ? 'valid_email' : 'permit_empty');

            $validationRules = [
                'atasan' => ['rules' => $rule_atasan, 'errors' => ['valid_email' => lang("app.err unik")]],
            ];
            if (!$this->validate($validationRules)) {
                $msg = ['error' => ['atasan' => $this->validation->getError('atasan')]];
            } else {
                //Simpan
                if ($this->request->getVar('postaction') == 'save') {
                    $perusahaanmulti = (empty($this->request->getPost('aksesPerusahaan')) || $this->request->getPost('aksesPerusahaan') == ',') ? ',' : ',' . $this->request->getPost('aksesPerusahaan') . ',';
                    $wilayahmulti = (empty($this->request->getPost('aksesWilayah')) || $this->request->getPost('aksesWilayah') == ',') ? ',' : ',' . $this->request->getPost('aksesWilayah') . ',';
                    $divisimulti = (empty($this->request->getPost('aksesDivisi')) || $this->request->getPost('aksesDivisi') == ',') ? ',' : ',' . $this->request->getPost('aksesDivisi') . ',';
                    $jabatanmulti = (!empty($_POST['daftarjabatan']) ? ',' . implode(",", $_POST['daftarjabatan']) . ',' : '' . ',');
                    $proyekmulti = (!empty($_POST['daftarproyek']) ? ',' . implode(",", $_POST['daftarproyek']) . ',' : '' . ',');
                    $cabangmulti = (!empty($_POST['daftarcabang']) ? ',' . implode(",", $_POST['daftarcabang']) . ',' : '' . ',');
                    $alatmulti = (!empty($_POST['daftaralat']) ? ',' . implode(",", $_POST['daftaralat']) . ',' : '' . ',');
                    $tanahmulti = (!empty($_POST['daftartanah']) ? ',' . implode(",", $_POST['daftartanah']) . ',' : '' . ',');
                    $kasbankmulti = (!empty($_POST['daftarkasbank']) ? ',' . implode(",", $_POST['daftarkasbank']) . ',' : '' . ',');
                    $kondisi = $db1[0]->kondisi[0] . '0' . $db1[0]->kondisi[2];
                    $fieldAksi = ['buat', 'baca', 'ubah', 'hapus', 'konf', 'aktif'];
                    $button = implode('', array_map(fn($field) => $this->request->getVar($field) == 'on' ? '1' : '0', $fieldAksi));
                    $fieldAkses = ['perusahaan', 'wilayah', 'divisi', 'jabatan', 'proyek', 'cabang', 'alat', 'tanah', 'super', 'saring'];
                    $akses = implode('', array_map(fn($field) => $this->request->getVar($field) == 'on' ? '1' : '0', $fieldAkses));

                    var_dump($db1[0]->id, $this->request->getVar('atasan'));
                    die;

                    $this->userModel->save([
                        'id' => $db1[0]->id,
                        'role_id' => $this->request->getVar('role'),
                        'atasan_id' => $this->request->getVar('atasan'),
                        'act_setuju' => $this->request->getVar('setuju'),
                        'act_limit' => ubahSeparator($this->request->getVar('batas')),
                        'act_button' => $button,
                        'act_akses' => $akses,
                        'perusahaan' => $perusahaanmulti,
                        'wilayah' => $wilayahmulti,
                        'divisi' => $divisimulti,
                        'jabatan' => $jabatanmulti,
                        'proyek' => $proyekmulti,
                        'cabang' => $cabangmulti,
                        'alat' => $alatmulti,
                        'tanah' => $tanahmulti,
                        'kasbank' => $kasbankmulti,
                        'kondisi' => $kondisi,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $db1[0]->idunik, $db1[0]->kode);
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode}" . lang("app.judul ubah")]);
                }

                //Konfirmasi
                if ($this->request->getVar('postaction') == 'confirm') {
                    $kondisi = '11' . $db1[0]->kondisi[2];
                    $this->userModel->save(['id' => $db1[0]->id, 'kondisi' => $kondisi, 'conf_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', "{$db1[0]->idunik}", "{$db1[0]->kode}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode}" . lang("app.judul konf")]);
                }

                // Delete
                if ($this->request->getVar('postaction') == 'hapus') {
                    $this->alatModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', "{$db1[0]->idunik}", "{$db1[0]->kode}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode}" . lang("app.judul hapus")]);
                }

                //Aktifasi
                if ($this->request->getVar('postaction') == 'aktif') {
                    $kondisi = $db1[0]->kondisi[2] == '1';
                    $akhir = $kondisi ? '0' : '1';
                    $onoff = $kondisi ? 'nonaktif' : 'aktif';
                    $judul = $kondisi ? lang("app.judul inaktif") : lang("app.judul aktif");

                    $this->alatModel->save(['id' => $db1[0]->id, 'kondisi' => substr($db1[0]->kondisi, 0, 2) . $akhir, 'aktif_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', "{$db1[0]->idunik}", "{$db1[0]->kode} {$onoff}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} {$judul}"]);
                }
                $msg = ['redirect' => '/user'];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
