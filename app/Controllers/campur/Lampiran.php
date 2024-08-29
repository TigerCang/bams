<?php

namespace App\Controllers\campur;

use Config\App;
use App\Controllers\BaseController;
use App\Models\campur\LampiranModel;

class Lampiran extends BaseController
{
    protected $lampiranModel;
    public function __construct()
    {
        $this->lampiranModel = new LampiranModel();
    }

    public function tabelLampiran()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'lampiran' => $this->lampiranModel->getLampiran($this->request->getvar('param'), $this->request->getvar('idunik')),
                'param' => $this->request->getvar('param'),
            ];
            $msg = ['data' => view('lampiran/lampiran_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function modalLampiran()
    {
        if ($this->request->isAJAX()) {
            $data = [
                't_modal' => lang('app.lampiran'),
                'idunik' => $this->request->getVar('idunik'),
                'param' => $this->request->getvar('param')
            ];
            $msg = ['data' => view('lampiran/lampiran_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function saveLampiran()
    {
        if ($this->request->isAJAX()) {
            $validationRules = [
                'judul' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'lampiran' => [
                    'rules' => 'uploaded[lampiran]|max_size[lampiran,20480]|ext_in[lampiran,pdf]',
                    'errors' => ['uploaded' => lang("app.err blank"), 'max_size' => lang("app.err filebesar20"), 'ext_in' => lang("app.err fileext")]
                ]
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'judul' => $this->validation->getError('judul'),
                        'lampiran' => $this->validation->getError('lampiran')
                    ]
                ];
            } else {
                $lampiran = $this->request->getFile('lampiran');
                $lampiran->move('assets/berkas/' . $this->request->getVar('param'));
                $nama_lampiran = $lampiran->getName();
                $this->lampiranModel->save([
                    'idunik' => $this->request->getVar('idunik'),
                    'param' => $this->request->getVar('param'),
                    'judul' => $this->request->getVar('judul'),
                    'deskripsi' => $this->request->getVar('deskripsi'),
                    'tanggal' => $this->request->getVar('tanggal'),
                    'lampiran' => $nama_lampiran,
                    'save_by' => $this->user['id'],
                ]);
                $msg = ['sukses' => "{$this->request->getVar('judul')}" . lang("app.judul simpan")];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function deleteLampiran()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->lampiranModel->getLampiran('', $this->request->getVar('id'), 'id');
            unlink('assets/berkas/' . $db1[0]->param . '/' . $db1[0]->lampiran);
            $this->lampiranModel->delete($this->request->getVar('id'));
            $msg = ['sukses' => ""];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
