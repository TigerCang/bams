<?php

namespace App\Controllers\main\deklarasi;

use Config\App;
use App\Controllers\BaseController;

class nUser extends BaseController
{
    public function index()
    {
        checkPage('102');
        $data = [
            't_judul' => lang('app.user anak'),
            't_span' => lang('app.span user anak'),
            'link' => '/nuser',
            'user' => $this->mainModel->getUser($this->urls[1], $this->user['id']),
        ];
        $this->render('admin/user_list', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function inputData()
    {
        $db1 = $this->mainModel->satuID('m_user', $this->request->getVar('datakey'), 'u');
        checkPage('101', $db1, 'y', 'n');
        $buttons = setButton($db1);
        if ($db1) $this->logModel->saveLog('Read', $this->request->getVar('datakey'), "{$db1[0]->kode}");

        $data = [
            't_judul' => lang('app.user anak'),
            't_span' => lang('app.span user'),
            'link' => "/nuser",
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
            'useratas' => $this->mainModel->satuID('m_user', $db1[0]->atasan_id ?? '', '', 'id', 't'),
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
            $dbatas = $this->mainModel->satuID('m_user', $db1[0]->atasan_id, '', 'id');
            $rule_atasan = ($db1[0]->id == $this->request->getVar('atasan') ? 'valid_email' : 'permit_empty');
            $nilai = $dbatas[0]->act_limit;
            $rule_batas = (ubahSeparator($this->request->getVar('batas')) > $nilai ? 'valid_email' : 'permit_empty');

            $validationRules = [
                'atasan' => ['rules' => $rule_atasan, 'errors' => ['valid_email' => lang("app.err unik")]],
                'batas' => ['rules' => $rule_batas, 'errors' => ['valid_email' => lang("app.err unik")]],
            ];
            if (!$this->validate($validationRules)) {
                $msg = ['error' => ['atasan' => $this->validation->getError('atasan'), 'batas' => $this->validation->getError('batas')]];
            } else {
                //Simpan
                if ($this->request->getVar('postaction') == 'save') {
                    $perusahaanmulti = (isset($_POST['daftarperusahaan']) ? ',' . implode(",", $_POST['daftarperusahaan']) . ',' : '' . ',');
                    $wilayahmulti = (isset($_POST['daftarwilayah']) ? ',' . implode(",", $_POST['daftarwilayah']) . ',' : '' . ',');
                    $divisimulti = (isset($_POST['daftardivisi']) ? ',' . implode(",", $_POST['daftardivisi']) . ',' : '' . ',');
                    $jabatanmulti = (isset($_POST['daftarjabatan']) ? ',' . implode(",", $_POST['daftarjabatan']) . ',' : '' . ',');
                    $proyekmulti = (isset($_POST['daftarproyek']) ? ',' . implode(",", $_POST['daftarproyek']) . ',' : '' . ',');
                    $cabangmulti = (isset($_POST['daftarcabang']) ? ',' . implode(",", $_POST['daftarcabang']) . ',' : '' . ',');
                    $alatmulti = (isset($_POST['daftaralat']) ? ',' . implode(",", $_POST['daftaralat']) . ',' : '' . ',');
                    $tanahmulti = (isset($_POST['daftartanah']) ? ',' . implode(",", $_POST['daftartanah']) . ',' : '' . ',');
                    $kasbankmulti = (isset($_POST['daftarkasbank']) ? ',' . implode(",", $_POST['daftarkasbank']) . ',' : '' . ',');

                    $kondisi = $db1[0]->kondisi[0] . '0' . $db1[0]->kondisi[2];
                    $fieldAksi = ['buat', 'baca', 'ubah', 'hapus', 'konf', 'aktif'];
                    $button = implode('', array_map(fn($field) => $this->request->getVar($field) == 'on' ? '1' : '0', $fieldAksi));
                    $fieldAkses = ['perusahaan', 'wilayah', 'divisi', 'jabatan', 'proyek', 'cabang', 'alat', 'tanah', 'super', 'saring'];
                    $akses = implode('', array_map(fn($field) => $this->request->getVar($field) == 'on' ? '1' : '0', $fieldAkses));

                    $this->userModel->save([
                        'id' => $db1[0]->id,
                        'role_id' => $this->request->getVar('role'),
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
                $msg = ['redirect' => '/nuser'];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
