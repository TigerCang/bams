<?php

namespace App\Controllers\main\deklarasi;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\RuasModel;

class Jarak extends BaseController
{
    protected $ruasModel;
    public function __construct()
    {
        $this->ruasModel = new RuasModel();
    }

    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        checkPage('102');
        $data = [
            't_judul' => lang('app.jarak'),
            't_span' => lang('app.span jarak'),
            'link' => '/jarak',
            'filproyek' => 'hidden',
            'cpl' => '001',
            'tujuan' => 'jarak',
        ];
        $this->render('main/aset/ruas_list', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->satuID('m_ruas', $this->request->getVar('datakey'), 'u');
            checkPage('101', $db1, 'y', 'n');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $this->request->getVar('datakey'), "{$db1[0]->kode} ; {$db1[0]->nama}");

            $data = [
                't_modal' => lang('app.jarak'),
                'link' => "/jarak",
                'ruas' => $db1,
                'tuser' => $this->user,
                'button' => ['save' => $buttons['bsave'], 'conf' => $buttons['bconf'], 'del' => $buttons['bdel'], 'aktif' => $buttons['baktif']],
                'btnaktif' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.btn aktif') : lang('app.btn inaktif')),
                'acby' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.inacby') : lang('app.acby')),
            ];
            $msg = ['data' => view('main/deklarasi/jarak_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->satuID('m_ruas', $this->request->getVar('idunik'));
            $kode = $this->mainModel->cekRuas('jarak', $this->request->getVar('kode'), $this->request->getVar('idunik'));
            $rule_kode = ($kode ? 'required|is_unique[m_ruas.kode]|min_length[6]' : 'required|min_length[6]');
            $idunik = $this->request->getVar('idunik');

            $validationRules = [
                'kode' => [
                    'rules' => $rule_kode,
                    'errors' => ['required' => lang("app.err blank"), 'min_length' => lang("app.err length", [6]), 'is_unique' => lang("app.err unik")]
                ],
                'deskripsi' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'jarak' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'kode' => $this->validation->getError('kode'),
                        'deskripsi' => $this->validation->getError('deskripsi'),
                        'jarak' => $this->validation->getError('jarak'),
                    ]
                ];
            } else {
                //Simpan
                if ($this->request->getVar('postaction') == 'save') {
                    $kondisi = (empty($db1) ? '001' : $db1[0]->kondisi[0] . '0' . $db1[0]->kondisi[2]);
                    $judul = (empty($db1) ? lang('app.judul buat') : lang('app.judul ubah'));
                    if ($idunik === '') $idunik = buatID();
                    $this->ruasModel->save([
                        'id' => $db1[0]->id ?? '',
                        'idunik' => $idunik,
                        'param' => 'jarak',
                        'kode' => strtoupper($this->request->getVar('kode')),
                        'nama' => $this->request->getVar('deskripsi'),
                        'jarak' => ubahSeparator($this->request->getVar('jarak')),
                        'catatan' => $this->request->getVar('catatan'),
                        'kondisi' => $kondisi,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $idunik, strtoupper($this->request->getVar('kode')) . ' ; ' . $this->request->getVar('deskripsi'));
                    $this->session->setFlashdata(['pesan' => strtoupper($this->request->getVar('kode')) . ' ; ' . $this->request->getVar('deskripsi') . $judul]);
                }

                // Konfirmasi
                if ($this->request->getVar('postaction') == 'confirm') {
                    $kondisi = '11' . $db1[0]->kondisi[2];
                    $this->ruasModel->save(['id' => $db1[0]->id, 'kondisi' => $kondisi, 'conf_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama}" . lang("app.judul konf")]);
                }

                // Delete
                if ($this->request->getVar('postaction') == 'hapus') {
                    $this->ruasModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama}" . lang("app.judul hapus")]);
                }

                //Aktifasi
                if ($this->request->getVar('postaction') == 'aktif') {
                    $hasil = $db1[0]->kondisi[2] == '1' ? ['0', 'nonaktif', lang("app.judul inaktif")] : ['1', 'aktif', lang("app.judul aktif")];
                    $this->ruasModel->save(['id' => $db1[0]->id, 'kondisi' => substr($db1[0]->kondisi, 0, 2) . $hasil[0], 'aktif_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama} {$hasil[1]}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama} {$hasil[2]}"]);
                }
                $msg = ['redirect' => '/jarak'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
