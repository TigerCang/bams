<?php

namespace App\Controllers\main\sdm;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\BerkasModel;

class KateRating extends BaseController
{
    protected $berkasModel;
    public function __construct()
    {
        $this->berkasModel = new BerkasModel();
    }

    public function index()
    {
        checkPage('102');
        $data = [
            't_judul' => lang('app.kategori rating'),
            't_span' => lang('app.span kategori rating'),
            'link' => '/katerating',
            'satuan' => $this->mainModel->getBerkas($this->urls[1], 'kategori rating'),
            'chid' => 'hidden',
            'ghid' => 'hidden'
        ];
        $this->render('main/deklarasi/satuan_list', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->satuID('m_berkas', $this->request->getVar('datakey'), 'u');
            checkPage('102', $db1, 'y', 'n');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $this->request->getVar('datakey'), $db1[0]->nama);

            $data = [
                't_modal' => lang('app.kategori rating'),
                'link' => "/katerating",
                'chid' => 'hidden',
                'ghid' => 'hidden',
                'param' => 'kategori rating',
                'perusahaan' => [],
                'wilayah' => [],
                'divisi' => [],
                'berkas' => $db1,
                'button' => ['save' => $buttons['bsave'], 'conf' => $buttons['bconf'], 'del' => $buttons['bdel'], 'aktif' => $buttons['baktif']],
                'btnaktif' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.btn aktif') : lang('app.btn inaktif')),
                'acby' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.inacby') : lang('app.acby')),
                'tuser' => $this->user,
            ];
            $msg = ['data' => view('main/deklarasi/satuan_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->satuID('m_berkas', $this->request->getVar('idunik'));
            $nama = $this->mainModel->cekBerkas('kategori rating', 'nama', $this->request->getVar('deskripsi'), $this->request->getVar('idunik'));
            $rule_nama = ($nama ? 'required|is_unique[m_berkas.nama]' : 'required');
            $idunik = $this->request->getVar('idunik');

            $validationRules = [
                'deskripsi' => ['rules' => $rule_nama, 'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unik")]],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'deskripsi' => $this->validation->getError('deskripsi'),
                    ]
                ];
            } else {
                //Simpan
                if ($this->request->getVar('postaction') == 'save') {
                    $kondisi = (empty($db1) ? '001' : $db1[0]->kondisi[0] . '0' . $db1[0]->kondisi[2]);
                    $judul = (empty($db1) ? lang('app.judul buat') : lang('app.judul ubah'));
                    if ($idunik === '') $idunik = buatID();
                    $this->berkasModel->save([
                        'id' => $db1[0]->id ?? '',
                        'idunik' => $idunik,
                        'param' => 'kategori rating',
                        'nama' => $this->request->getVar('deskripsi'),
                        'kondisi' => $kondisi,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $idunik, $this->request->getVar('deskripsi'));
                    $this->session->setFlashdata(['pesan' => $this->request->getVar('deskripsi') . $judul]);
                }

                // Konfirmasi
                if ($this->request->getVar('postaction') == 'confirm') {
                    $kondisi = '11' . $db1[0]->kondisi[2];
                    $this->berkasModel->save(['id' => $db1[0]->id, 'kondisi' => $kondisi, 'conf_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $idunik, $db1[0]->nama);
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->nama}" . lang("app.judul konf")]);
                }

                // Delete
                if ($this->request->getVar('postaction') == 'hapus') {
                    $this->berkasModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $idunik, $db1[0]->nama);
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->nama}" . lang("app.judul hapus")]);
                }

                //Aktifasi
                if ($this->request->getVar('postaction') == 'aktif') {
                    $hasil = $db1[0]->kondisi[2] == '1' ? ['0', 'nonaktif', lang("app.judul inaktif")] : ['1', 'aktif', lang("app.judul aktif")];
                    $this->berkasModel->save(['id' => $db1[0]->id, 'kondisi' => substr($db1[0]->kondisi, 0, 2) . $hasil[0], 'aktif_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $idunik, "{$db1[0]->nama} {$hasil[1]}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->nama} {$hasil[2]}"]);
                }
                $msg = ['redirect' => '/katerating'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}