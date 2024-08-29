<?php

namespace App\Controllers\admin;

use Config\App;
use App\Controllers\BaseController;

class Konfigurasi extends BaseController
{
    public function index()
    {
        checkPage('002');
        $data = [
            't_judul' => lang('app.konfigurasi'),
            't_span' => lang('app.span konfigurasi'),
            'link' => '/konfigurasi',
            'konfigurasi' => $this->konfigurasiModel->getKonfigurasi(),
        ];
        $this->render('admin/konfigurasi_list', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->konfigurasiModel->getKonfigurasi($this->request->getVar('param'));
            checkPage('002', $db1, 'y', 'n');
            if ($db1) $this->logModel->saveLog('Read', $this->request->getVar('datakey'), $this->request->getVar('param'));
            $data = [
                'link' => "/konfigurasi",
                't_modal' => lang('app.konfigurasi'),
                'konfigurasi' => $db1,
            ];
            $msg = ['data' => view('admin/konfigurasi_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->konfigurasiModel->getKonfigurasi($this->request->getVar('xparam'));
            $rule_level = ($db1[0]['mode'] == "A" ? 'required' : 'permit_empty');
            $rule_deskripsi = ($db1[0]['mode'] == "B" ? 'required' : 'permit_empty');
            $nilai = ($db1[0]['mode'] == "A" ? $this->request->getVar('level') : $this->request->getVar('deskripsi'));

            $validationRules = [
                'level' => ['rules' => $rule_level, 'errors' => ['required' => lang("app.err blank")]],
                'deskripsi' => ['rules' => $rule_deskripsi, 'errors' => ['required' => lang("app.err blank")]],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'level' => $this->validation->getError('level'),
                        'deskripsi' => $this->validation->getError('deskripsi'),
                    ]
                ];
            } else {
                $path = FCPATH . 'assets/' . $db1[0]['sub_param'] . '/' . $this->request->getVar('deskripsi'); // Path absolut pada sistem file
                if (!is_dir($path)) mkdir($path, 0777, true);
                $this->konfigurasiModel->save(['id' => $db1[0]['id'], 'nilai' => $nilai, 'save_by' => $this->user['id']]);
                $this->logModel->saveLog('Save', $this->request->getVar('idunik'), $this->request->getVar('xparam'));
                $this->session->setFlashdata(['pesan' => $this->request->getVar('xparam') . lang('app.judul ubah')]);
                $msg = ['redirect' => '/konfigurasi'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
