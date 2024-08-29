<?php

namespace App\Controllers\main\aset;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\CabangModel;

class Cabang extends BaseController
{
    protected $cabangModel;
    public function __construct()
    {
        $this->cabangModel = new CabangModel();
    }

    public function index()
    {
        checkPage('102');
        $data = [
            't_judul' => lang('app.cabang'),
            't_span' => lang('app.span cabang'),
            'link' => '/cabang',
            'cabang' => $this->mainModel->getCabang($this->urls[1]),
        ];
        $this->render('main/aset/cabang_list', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function inputData()
    {
        $db1 = $this->mainModel->satuID('m_cabang', $this->request->getVar('datakey'), 'u');
        checkPage('101', $db1, 'y', 'n');
        $buttons = setButton($db1);
        if ($db1) $this->logModel->saveLog('Read', $this->request->getVar('datakey'), "{$db1[0]->kode} ; {$db1[0]->nama}");

        $data = [
            't_judul' => lang('app.cabang'),
            't_span' => lang('app.span cabang'),
            'link' => "/cabang",
            'perusahaan' => $this->mainModel->getPerusahaan('', 't'),
            'wilayah' => $this->mainModel->getBerkas('', 'wilayah', 't'),
            'divisi' => $this->mainModel->getBerkas('', 'divisi', 't'),
            'cabang' => $db1,
            'button' => ['save' => $buttons['bsave'], 'conf' => $buttons['bconf'], 'del' => $buttons['bdel'], 'aktif' => $buttons['baktif']],
            'btnaktif' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.btn aktif') : lang('app.btn inaktif')),
            'acby' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.inacby') : lang('app.acby')),
        ];
        $this->render('main/aset/cabang_input', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->satuID('m_cabang', $this->request->getVar('idunik'));
            $rule_kode = ($db1 ? ($db1[0]->kode != strtoupper($this->request->getVar('kode')) ? 'required|is_unique[m_cabang.kode]|min_length[10]' : 'required|min_length[10]') : 'required|is_unique[m_cabang.kode]|min_length[10]');
            $idunik = $this->request->getVar('idunik');

            $validationRules = [
                'kode' => ['rules' => $rule_kode, 'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unik"), 'min_length' => lang("app.err length", [10])]],
                'deskripsi' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'kode' => $this->validation->getError('kode'),
                        'deskripsi' => $this->validation->getError('deskripsi'),
                    ]
                ];
            } else {
                //Simpan
                if ($this->request->getVar('postaction') == 'save') {
                    $kondisi = (empty($db1) ? '001' : $db1[0]->kondisi[0] . '0' . $db1[0]->kondisi[2]);
                    $judul = (empty($db1) ? lang('app.judul buat') : lang('app.judul ubah'));

                    $perusahaan = (isset($db1[0]->kondisi[0]) && $db1[0]->kondisi[0] == '1' ? $db1[0]->perusahaan_id : $this->request->getVar('perusahaan'));
                    $wilayah = (isset($db1[0]->kondisi[0]) && $db1[0]->kondisi[0] == '1' ? $db1[0]->wilayah_id : $this->request->getVar('wilayah'));
                    $divisi = (isset($db1[0]->kondisi[0]) && $db1[0]->kondisi[0] == '1' ? $db1[0]->divisi_id : $this->request->getVar('divisi'));
                    if ($idunik === '') $idunik = buatID();
                    $this->cabangModel->save([
                        'id' => $db1[0]->id ?? '',
                        'idunik' => $idunik,
                        'kode' => strtoupper($this->request->getVar('kode')),
                        'nama' => $this->request->getVar('deskripsi'),
                        'alamat' => $this->request->getVar('alamat'),
                        'perusahaan_id' => $perusahaan,
                        'wilayah_id' => $wilayah,
                        'divisi_id' => $divisi,
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
                    $this->cabangModel->save(['id' => $db1[0]->id, 'kondisi' => $kondisi, 'conf_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama}" . lang("app.judul konf")]);
                }

                // Delete
                if ($this->request->getVar('postaction') == 'hapus') {
                    $this->cabangModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama}" . lang("app.judul hapus")]);
                }

                //Aktifasi
                if ($this->request->getVar('postaction') == 'aktif') {
                    $kondisi = $db1[0]->kondisi[2] == '1';
                    $akhir = $kondisi ? '0' : '1';
                    $onoff = $kondisi ? 'nonaktif' : 'aktif';
                    $judul = $kondisi ? lang("app.judul inaktif") : lang("app.judul aktif");

                    $this->cabangModel->save(['id' => $db1[0]->id, 'kondisi' => substr($db1[0]->kondisi, 0, 2) . $akhir, 'aktif_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama} {$onoff}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama} {$judul}"]);
                }
                $msg = ['redirect' => '/cabang'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
