<?php

namespace App\Controllers\main\akuntansi;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\KBLIModel;

class Kbli extends BaseController
{
    protected $kbliModel;
    public function __construct()
    {
        $this->kbliModel = new KBLIModel();
    }

    public function index()
    {
        checkPage('102');
        $data = [
            't_judul' => lang('app.pajak&'),
            't_span' => lang('app.span akun lain'),
            'link' => '/kbli',
            'selkategori' => $this->mainModel->distSelect('kbli'),
        ];
        $this->render('main/akuntansi/kbli_list', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->satuID('m_kbli', $this->request->getVar('datakey'), 'u');
            checkPage('102', $db1, 'y', 'n');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $this->request->getVar('datakey'), "{$db1[0]->nama}");

            $data = [
                't_modal' => lang('app.pajak&'),
                'link' => "/kbli",
                'selkategori' => $this->mainModel->distSelect('kbli'),
                'pajak' => $this->mainModel->getKelakun('', 'pajak', 't'),
                'kbli' => $db1,
                'tuser' => $this->user,
                'button' => ['save' => $buttons['bsave'], 'conf' => $buttons['bconf'], 'del' => $buttons['bdel'], 'aktif' => $buttons['baktif']],
                'btnaktif' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.btn aktif') : lang('app.btn inaktif')),
                'acby' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.inacby') : lang('app.acby')),
            ];
            $msg = ['data' => view('main/akuntansi/kbli_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->satuID('m_kbli', $this->request->getVar('idunik'));
            $kode = $this->mainModel->cekKBLI($this->request->getVar('xkategori'), $this->request->getVar('kode'), $this->request->getVar('idunik'));
            $rule_kode = ($kode ? 'required|is_unique[m_kbli.kode]|min_length[5]' : 'required|min_length[5]');
            $kode2 = $this->mainModel->cekKBLI($this->request->getVar('xkategori'), $this->request->getVar('kode2'), $this->request->getVar('idunik'));
            $rule_kode2 = ($kode2 ? 'required|is_unique[m_kbli.kode]|min_length[9]' : 'required|min_length[9]');

            if ($this->request->getVar('xkategori') != 'kode baku') $rule_kode = 'permit_empty';
            if ($this->request->getVar('xkategori') != 'objek pajak') $rule_kode2 = 'permit_empty';
            $idunik = $this->request->getVar('idunik');
            $validationRules = [
                'kode' => [
                    'rules' => $rule_kode,
                    'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unik"), 'min_length' => lang("app.err length", [5])]
                ],
                'kode2' => [
                    'rules' => $rule_kode2,
                    'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unik"), 'min_length' => lang("app.err length", [9])]
                ],
                'deskripsi' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'kode' => $this->validation->getError('kode'),
                        'kode2' => $this->validation->getError('kode2'),
                        'deskripsi' => $this->validation->getError('deskripsi'),
                    ]
                ];
            } else {
                //Simpan
                if ($this->request->getVar('postaction') == 'save') {
                    $kode = ($this->request->getVar('xkategori') == 'kode baku' ? $this->request->getVar('kode') : ($this->request->getVar('xkategori') == 'objek pajak' ? $this->request->getVar('kode2') : ''));
                    $pajak = ($this->request->getVar('xkategori') == 'objek pajak' ? $this->request->getVar('pajak') : '');
                    $kondisi = (empty($db1) ? '001' : $db1[0]->kondisi[0] . '0' . $db1[0]->kondisi[2]);
                    $judul = (empty($db1) ? lang('app.judul buat') : lang('app.judul ubah'));
                    if ($idunik === '') $idunik = buatID();
                    $this->kbliModel->save([
                        'id' => $db1[0]->id ?? '',
                        'idunik' => $idunik,
                        'param' => $this->request->getVar('xkategori'),
                        'kode' => $kode,
                        'nama' => $this->request->getVar('deskripsi'),
                        'pajak_id' => $pajak,
                        'kondisi' => $kondisi,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $idunik, "{$this->request->getVar('deskripsi')}");
                    $this->session->setFlashdata(['pesan' => "{$this->request->getVar('deskripsi')} {$judul}", 'flash-kate' => $this->request->getVar('xkategori')]);
                }

                // Konfirmasi
                if ($this->request->getVar('postaction') == 'confirm') {
                    $kondisi = '11' . $db1[0]->kondisi[2];
                    $this->berkasModel->save(['id' => $db1[0]->id, 'kondisi' => $kondisi, 'conf_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $idunik, "{$db1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->nama}" . lang("app.judul konf"), 'flash-kate' => $db1[0]->param]);
                }

                // Delete
                if ($this->request->getVar('postaction') == 'hapus') {
                    $this->berkasModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $idunik, "{$db1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->nama}" . lang("app.judul hapus"), 'flash-kate' => $db1[0]->param]);
                }

                //Aktifasi
                if ($this->request->getVar('postaction') == 'aktif') {
                    $hasil = $db1[0]->kondisi[2] == '1' ? ['0', 'nonaktif', lang("app.judul inaktif")] : ['1', 'aktif', lang("app.judul aktif")];
                    $this->berkasModel->save(['id' => $db1[0]->id, 'kondisi' => substr($db1[0]->kondisi, 0, 2) . $hasil[0], 'aktif_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $idunik, "{$db1[0]->nama} {$hasil[1]}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->nama} {$hasil[2]}", 'flash-kate' => $db1[0]->param]);
                }
                $msg = ['redirect' => '/kbli'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function cariData()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'kbli' => $this->mainModel->getKBLI($this->urls[1], $this->request->getVar('kategori')),
                'tuser' => $this->user,
            ];
            $msg = ['data' => view('x-main/kbli_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
