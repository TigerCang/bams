<?php

namespace App\Controllers\main\akuntansi;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\KelakunModel;

class AkunGrup extends BaseController
{
    protected $kelakunModel;
    public function __construct()
    {
        $this->kelakunModel = new KelakunModel();
    }

    public function index()
    {
        checkPage('102');
        $data = [
            't_judul' => lang('app.akun grup'),
            't_span' => lang('app.span akun grup'),
            'link' => '/akungrup',
            'khid' => '',
            'phid' => 'hidden',
            'nhid' => 'hidden',
            'kelakun' => $this->mainModel->getKelakun($this->urls[1], 'grup'),
        ];
        $this->render('main/akuntansi/kelakun_list', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->satuID('m_kelakun', $this->request->getVar('datakey'), 'u');
            checkPage('102', $db1, 'y', 'n');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $this->request->getVar('datakey'), "{$db1[0]->nama}");

            $data = [
                't_modal' => lang('app.akun grup'),
                'link' => "/akungrup",
                'selkel' => $this->mainModel->distSelect('akun grup', 't'),
                'selnama' => $this->mainModel->distSelect('akun grup'),
                'perusahaan' => [],
                'wilayah' => [],
                'divisi' => [],

                'akun1' => $this->mainModel->satuID('m_akun', $db1[0]->akun1_id ?? '', '', 'id'),
                'akun2' => $this->mainModel->satuID('m_akun', $db1[0]->akun2_id ?? '', '', 'id'),
                'akun3' => $this->mainModel->satuID('m_akun', $db1[0]->akun3_id ?? '', '', 'id'),
                'akun4' => $this->mainModel->satuID('m_akun', $db1[0]->akun4_id ?? '', '', 'id'),
                'kelakun' => $db1,
                'tuser' => $this->user,
                'button' => ['save' => $buttons['bsave'], 'conf' => $buttons['bconf'], 'del' => $buttons['bdel'], 'aktif' => $buttons['baktif']],
                'btnaktif' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.btn aktif') : lang('app.btn inaktif')),
                'acby' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.inacby') : lang('app.acby')),
            ];
            $msg = ['data' => view('main/akuntansi/kelakun_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->satuID('m_kelakun', $this->request->getVar('idunik'));
            $nama = $this->mainModel->cekKelakun($this->request->getVar('xsubparam'), $this->request->getVar('deskripsi'), $this->request->getVar('idunik'));
            $rule_nama = ($nama ? 'required|is_unique[m_kelakun.nama]' : 'required');
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
                    $this->kelakunModel->save([
                        'id' => $db1[0]->id ?? '',
                        'idunik' => $idunik,
                        'asal' => 'grup',
                        'param' => $this->request->getVar('xparam'),
                        'sub_param' => $this->request->getVar('xsubparam'),
                        'nama' => $this->request->getVar('deskripsi'),
                        'nilai' => $this->request->getVar('nilai'),
                        'akun1_id' => $this->request->getVar('akun1') ?? 0,
                        'akun2_id' => $this->request->getVar('akun2') ?? 0,
                        'akun3_id' => $this->request->getVar('akun3') ?? 0,
                        'akun4_id' => $this->request->getVar('akun4') ?? 0,
                        'catatan' => $this->request->getVar('catatan'),
                        'kondisi' => $kondisi,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $idunik, $this->request->getVar('deskripsi'));
                    $this->session->setFlashdata(['pesan' => "{$this->request->getVar('deskripsi')} {$judul}"]);
                }

                // Konfirmasi
                if ($this->request->getVar('postaction') == 'confirm') {
                    $kondisi = '11' . $db1[0]->kondisi[2];
                    $this->akunModel->save(['id' => $db1[0]->id, 'kondisi' => $kondisi, 'conf_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $idunik, "{$db1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->nama}" . lang("app.judul konf")]);
                }

                // Delete
                if ($this->request->getVar('postaction') == 'hapus') {
                    $this->akunModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $idunik, "{$db1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->nama}" . lang("app.judul hapus")]);
                }

                //Aktifasi
                if ($this->request->getVar('postaction') == 'aktif') {
                    $hasil = $db1[0]->kondisi[2] == '1' ? ['0', 'nonaktif', lang("app.judul inaktif")] : ['1', 'aktif', lang("app.judul aktif")];
                    $this->akunModel->save(['id' => $db1[0]->id, 'kondisi' => substr($db1[0]->kondisi, 0, 2) . $hasil[0], 'aktif_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $idunik, "{$db1[0]->nama} {$hasil[1]}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->nama} {$hasil[2]}"]);
                }
                $msg = ['redirect' => '/akungrup'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
