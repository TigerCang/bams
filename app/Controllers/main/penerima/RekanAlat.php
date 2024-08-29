<?php

namespace App\Controllers\main\penerima;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\AlatModel;

class RekanAlat extends BaseController
{
    protected $alatModel;
    public function __construct()
    {
        $this->alatModel = new AlatModel();
    }

    public function index()
    {
        checkPage('102');
        $data = [
            't_judul' => lang('app.rekan alat'),
            't_span' => lang('app.span rekan alat'),
            'link' => '/rekanalat',
            'penerima1' => $this->mainModel->satuID('m_penerima', session()->getFlashdata('flash-penerima') ?? '', '', 'id'),
        ];
        $this->render('main/penerima/rekan_list', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->satuID('m_alat', $this->request->getVar('datakey'), 'u');
            checkPage('102', $db1, 'y', 'n');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $this->request->getVar('datakey'), $db1[0]->nama);

            $data = [
                't_modal' => lang('app.rekan alat'),
                'link' => "/rekanalat",
                'selbentuk' => $this->mainModel->distSelect('bentuk'),
                'selkategori' => $this->mainModel->distItem('m_alat', 'kategori', 'param', 'rekan'),
                'penerima1' => $this->mainModel->satuID('m_penerima', $db1[0]->rekan_id ?? '', '', 'id'),
                'alat' => $db1,
                'tuser' => $this->user,
                'button' => ['save' => $buttons['bsave'], 'conf' => $buttons['bconf'], 'del' => $buttons['bdel'], 'aktif' => $buttons['baktif']],
                'btnaktif' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.btn aktif') : lang('app.btn inaktif')),
                'acby' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.inacby') : lang('app.acby')),
            ];
            $msg = ['data' => view('main/penerima/rekan_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->satuID('m_alat', $this->request->getVar('idunik'));
            $idunik = $this->request->getVar('idunik');

            $validationRules = [
                'penerima' => ['rules' => 'required', 'errors' => ['required' => lang("app.err pilih")]],
                'nomor' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'deskripsi' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'penerima' => $this->validation->getError('penerima'),
                        'nomor' => $this->validation->getError('nomor'),
                        'deskripsi' => $this->validation->getError('deskripsi'),
                    ]
                ];
            } else {
                //Simpan
                if ($this->request->getVar('postaction') == 'save') {
                    $kondisi = (empty($db1) ? '001' : $db1[0]->kondisi[0] . '0' . $db1[0]->kondisi[2]);
                    $judul = (empty($db1) ? lang('app.judul buat') : lang('app.judul ubah'));
                    if ($idunik === '') $idunik = buatID();
                    $this->alatModel->save([
                        'id' => $db1[0]->id ?? '',
                        'idunik' => $idunik,
                        'param' => 'rekan',
                        'rekan_id' => $this->request->getVar('penerima'),
                        'nomor' => strtoupper($this->request->getVar('nomor')),
                        'model' => $this->request->getVar('model'),
                        'kategori' => $this->request->getVar('kategori'),
                        'nama' => $this->request->getVar('deskripsi'),
                        'catatan' => $this->request->getVar('catatan'),
                        'kondisi' => $kondisi,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $idunik, $this->request->getVar('deskripsi'));
                    $this->session->setFlashdata(['pesan' => $this->request->getVar('deskripsi') . $judul, 'flash-penerima' => $this->request->getVar('penerima')]);
                }

                // Konfirmasi
                if ($this->request->getVar('postaction') == 'confirm') {
                    $kondisi = '11' . $db1[0]->kondisi[2];
                    $this->alatModel->save(['id' => $db1[0]->id, 'kondisi' => $kondisi, 'conf_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $idunik, $db1[0]->nama);
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->nama}" . lang("app.judul konf"), 'flash-penerima' => $db1[0]->rekan_id]);
                }

                // Delete
                if ($this->request->getVar('postaction') == 'hapus') {
                    $this->alatModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $idunik, $db1[0]->nama);
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->nama}" . lang("app.judul hapus"), 'flash-penerima' => $db1[0]->rekan_id]);
                }

                //Aktifasi
                if ($this->request->getVar('postaction') == 'aktif') {
                    $hasil = $db1[0]->kondisi[2] == '1' ? ['0', 'nonaktif', lang("app.judul inaktif")] : ['1', 'aktif', lang("app.judul aktif")];
                    $this->alatModel->save(['id' => $db1[0]->id, 'kondisi' => substr($db1[0]->kondisi, 0, 2) . $hasil[0], 'aktif_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $idunik, "{$db1[0]->nama} {$hasil[1]}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->nama} {$hasil[2]}", 'flash-penerima' => $db1[0]->rekan_id]);
                }
                $msg = ['redirect' => '/rekanalat'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function cariAlat()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'alat' => $this->mainModel->getAlat($this->urls[1], '', 'rekan', '', $this->request->getVar('penerima')),
                'tuser' => $this->user,
                'pckn' => '0011',
            ];
            $msg = ['data' => view('x-main/alat_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
