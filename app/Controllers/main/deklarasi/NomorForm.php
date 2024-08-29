<?php

namespace App\Controllers\main\deklarasi;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\BerkasModel;

class NomorForm extends BaseController
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
            't_judul' => lang('app.kode form'),
            't_span' => lang('app.span kode form'),
            'link' => '/noform',
            'phid' => '',
            'form' => $this->mainModel->getForm($this->urls[1], 'iso', '', ''),
        ];
        $this->render('main/deklarasi/form_list', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->satuID('m_berkas', $this->request->getVar('datakey'), 'u');
            checkPage('102', $db1, 'y', 'n');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $this->request->getVar('datakey'), "{$db1[0]->sub_param} ; {$db1[0]->nama}");

            $data = [
                't_modal' => lang('app.kode form'),
                'link' => "/noform",
                'phid' => '',
                'param' => 'kode form',
                'selkel' => $this->mainModel->distSelect('formulir', 't'),
                'selnama' => $this->mainModel->distSelect('formulir'),
                'perusahaan' => $this->mainModel->getPerusahaan('', 't'),
                'form' => $db1,
                'tuser' => $this->user,
                'button' => ['save' => $buttons['bsave'], 'conf' => $buttons['bconf'], 'del' => $buttons['bdel'], 'aktif' => $buttons['baktif']],
                'btnaktif' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.btn aktif') : lang('app.btn inaktif')),
                'acby' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.inacby') : lang('app.acby')),
            ];
            $msg = ['data' => view('main/deklarasi/form_input', $data)];
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
            $cekForm = $this->mainModel->cekForm('iso', $this->request->getVar('form'), $this->request->getVar('idunik'), '', $this->request->getVar('perusahaan'));
            $rule_form = ($cekForm ? 'valid_email' : 'permit_empty');
            $idunik = $this->request->getVar('idunik');

            $validationRules = [
                'kode' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'form' => ['rules' => $rule_form, 'errors' => ['valid_email' => lang("app.err unik")]],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'form' => $this->validation->getError('form'),
                        'kode' => $this->validation->getError('kode'),
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
                        'param' => 'iso',
                        'sub_param' => $this->request->getVar('form'),
                        'nama' => $this->request->getVar('kode'),
                        'perusahaan_id' => $this->request->getVar('perusahaan'),
                        'kondisi' => $kondisi,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $idunik, "{$this->request->getVar('form')} ; {$this->request->getVar('kode')}");
                    $this->session->setFlashdata(['pesan' => "{$this->request->getVar('form')} ; {$this->request->getVar('kode')}" . $judul]);
                }

                // Konfirmasi
                if ($this->request->getVar('postaction') == 'confirm') {
                    $kondisi = '11' . $db1[0]->kondisi[2];
                    $this->berkasModel->save(['id' => $db1[0]->id, 'kondisi' => $kondisi, 'conf_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $idunik, "{$db1[0]->sub_param} ; {$db1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->sub_param} ; {$db1[0]->nama}" . lang("app.judul konf")]);
                }

                // Delete
                if ($this->request->getVar('postaction') == 'hapus') {
                    $this->berkasModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $idunik, "{$db1[0]->sub_param} ; {$db1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->sub_param} ; {$db1[0]->nama}" . lang("app.judul hapus")]);
                }

                //Aktifasi
                if ($this->request->getVar('postaction') == 'aktif') {
                    $hasil = $db1[0]->kondisi[2] == '1' ? ['0', 'nonaktif', lang("app.judul inaktif")] : ['1', 'aktif', lang("app.judul aktif")];
                    $this->berkasModel->save(['id' => $db1[0]->id, 'kondisi' => substr($db1[0]->kondisi, 0, 2) . $hasil[0], 'aktif_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $idunik, "{$db1[0]->sub_param} ; {$db1[0]->nama} {$hasil[1]}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->sub_param} ; {$db1[0]->nama} {$hasil[2]}"]);
                }
                $msg = ['redirect' => '/noform'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
