<?php

namespace App\Controllers\main\aset;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\RuasModel;

class Ruas extends BaseController
{
    protected $ruasModel;
    public function __construct()
    {
        $this->ruasModel = new RuasModel();
    }

    public function index()
    {
        checkPage('102');
        $data = [
            't_judul' => lang('app.ruas'),
            't_span' => lang('app.span ruas'),
            'link' => '/ruas',
            'filproyek' => '',
            'cpl' => '010',
            'tujuan' => 'ruas',
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
                't_modal' => lang('app.ruas'),
                'link' => "/ruas",
                'proyek1' => $this->mainModel->satuID('m_proyek', $db1[0]->proyek_id ?? '', '', 'id'),
                'ruas' => $db1,
                'tuser' => $this->user,
                'button' => ['save' => $buttons['bsave'], 'conf' => $buttons['bconf'], 'del' => $buttons['bdel'], 'aktif' => $buttons['baktif']],
                'btnaktif' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.btn aktif') : lang('app.btn inaktif')),
                'acby' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.inacby') : lang('app.acby')),
            ];
            $msg = ['data' => view('main/aset/ruas_input', $data)];
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
            $kode = $this->mainModel->cekRuas('ruas', $this->request->getVar('kode'), $this->request->getVar('idunik'), $this->request->getVar('idproyek'));
            $rule_kode = ($kode ? 'required|is_unique[m_ruas.kode]|min_length[4]' : 'required|min_length[4]');
            $idunik = $this->request->getVar('idunik');

            $validationRules = [
                'kode' => [
                    'rules' => $rule_kode,
                    'errors' => ['required' => lang("app.err blank"), 'min_length' => lang("app.err length", [4]), 'is_unique' => lang("app.err unik")]
                ],
                'deskripsi' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'idproyek' => ['rules' => 'required', 'errors' => ['required' => lang("app.err pilih")]],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'kode' => $this->validation->getError('kode'),
                        'deskripsi' => $this->validation->getError('deskripsi'),
                        'proyek' => $this->validation->getError('idproyek'),
                    ]
                ];
            } else {
                //Simpan
                $db2 = $this->mainModel->satuID('m_proyek', $db1[0]->proyek_id ?? $this->request->getVar('idproyek'), '', 'id');
                if ($this->request->getVar('postaction') == 'save') {
                    $kondisi = (empty($db1) ? '001' : $db1[0]->kondisi[0] . '0' . $db1[0]->kondisi[2]);
                    $judul = (empty($db1) ? lang('app.judul buat') : lang('app.judul ubah'));
                    if ($idunik === '') $idunik = buatID();
                    $this->ruasModel->save([
                        'id' => $db1[0]->id ?? '',
                        'idunik' => $idunik,
                        'param' => 'ruas',
                        'proyek_id' => $this->request->getVar('idproyek'),
                        'kode' => strtoupper($this->request->getVar('kode')),
                        'nama' => $this->request->getVar('deskripsi'),
                        'catatan' => $this->request->getVar('catatan'),
                        'kondisi' => $kondisi,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $idunik, strtoupper($this->request->getVar('kode')) . ' ; ' . $this->request->getVar('deskripsi'));
                    $this->session->setFlashdata(['pesan' => strtoupper($this->request->getVar('kode')) . ' ; ' . $this->request->getVar('deskripsi') . $judul, 'flash-proyek' => $db2]);
                }

                // Konfirmasi
                if ($this->request->getVar('postaction') == 'confirm') {
                    $kondisi = '11' . $db1[0]->kondisi[2];
                    $this->ruasModel->save(['id' => $db1[0]->id, 'kondisi' => $kondisi, 'conf_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama}" . lang("app.judul konf"), 'flash-proyek' => $db2]);
                }

                // Delete
                if ($this->request->getVar('postaction') == 'hapus') {
                    $this->ruasModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama}" . lang("app.judul hapus"), 'flash-proyek' => $db2]);
                }

                //Aktifasi
                if ($this->request->getVar('postaction') == 'aktif') {
                    $hasil = $db1[0]->kondisi[2] == '1' ? ['0', 'nonaktif', lang("app.judul inaktif")] : ['1', 'aktif', lang("app.judul aktif")];
                    $this->ruasModel->save(['id' => $db1[0]->id, 'kondisi' => substr($db1[0]->kondisi, 0, 2) . $hasil[0], 'aktif_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama} {$hasil[1]}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama} {$hasil[2]}", 'flash-proyek' => $db2]);
                }
                $msg = ['redirect' => '/ruas'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function loadProyek()
    {
        if ($this->request->isAJAX()) {
            $proyek = $this->mainModel->loadProyek($this->request->getvar('searchTerm'));
            $proyekdata = array();
            foreach ($proyek as $row) {
                $proyekdata[] = array('id' => $row->id, 'text' => $row->kode, 'data-subtext' => $row->paket);
            }
            return $this->response->setJSON($proyekdata);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function outfocusProyek()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->satuID('m_proyek', $this->request->getvar('proyek'), '', 'id');
            $dbperus = $this->mainModel->satuID('m_perusahaan', $db1[0]->perusahaan_id ?? '', '', 'id');
            $dbwil = $this->mainModel->satuID('m_berkas', $db1[0]->wilayah_id ?? '', '', 'id');
            $data = ['perusahaan' => $dbperus[0]->kode ?? '', 'wilayah' => $dbwil[0]->nama ?? ''];
            echo json_encode($data);
        } else {
            exit('out');
        }
    }
}
