<?php

namespace App\Controllers\main\deklarasi;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\PerusahaanModel;

class Perusahaan extends BaseController
{
    protected $perusahaanModel;
    public function __construct()
    {
        $this->perusahaanModel = new PerusahaanModel();
    }

    public function index()
    {
        checkPage('101');
        $data = [
            't_judul' => lang('app.perusahaan'),
            't_span' => lang('app.span perusahaan'),
            'link' => '/perusahaan',
            'penerima_hidden' => 'hidden',
            'perusahaan' => $this->mainModel->getPerusahaan($this->urls[1]),
        ];
        $this->render('main/deklarasi/perusahaan_list', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function inputData()
    {
        $db1 = $this->mainModel->satuID('m_perusahaan', $this->request->getVar('datakey'), 'u');
        checkPage('101', $db1, 'y', 'n');
        $buttons = setButton($db1);
        if ($db1) $this->logModel->saveLog('Read', $this->request->getVar('datakey'), "{$db1[0]->kode} ; {$db1[0]->nama}");

        $data = [
            't_judul' => lang('app.perusahaan'),
            't_span' => lang('app.span perusahaan'),
            'link' => "/perusahaan",
            'perusahaan' => $db1,
            'tuser' => $this->user,
            'button' => ['save' => $buttons['bsave'], 'conf' => $buttons['bconf'], 'del' => $buttons['bdel'], 'aktif' => $buttons['baktif']],
            'btnaktif' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.btn aktif') : lang('app.btn inaktif')),
            'acby' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.inacby') : lang('app.acby')),
        ];
        $this->render('main/deklarasi/perusahaan_input', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->satuID('m_perusahaan', $this->request->getVar('idunik'));
            $rule_kode = ($db1 ? ($db1[0]->kode != $this->request->getVar('kode') ? 'required|is_unique[m_perusahaan.kode]' : 'required') : 'required|is_unique[m_perusahaan.kode]');
            $idunik = $this->request->getVar('idunik');

            $validationRules = [
                'kode' => ['rules' => $rule_kode, 'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unik")]],
                'inisial' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'deskripsi' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'gambar' => [
                    'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/bmp,image/png]',
                    'errors' => ['max_size' => lang("app.err file1"), 'is_image' => lang("app.err notimg"), 'mime_in' => lang("app.err filemime")]
                ],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'kode' => $this->validation->getError('kode'),
                        'inisial' => $this->validation->getError('inisial'),
                        'deskripsi' => $this->validation->getError('deskripsi'),
                        'gambar' => $this->validation->getError('gambar'),
                    ]
                ];
            } else {
                //Simpan
                if ($this->request->getVar('postaction') == 'save') {
                    $kondisi = (empty($db1) ? '001' : $db1[0]->kondisi[0] . '0' . $db1[0]->kondisi[2]);
                    $judul = (empty($db1) ? lang('app.judul buat') : lang('app.judul ubah'));

                    $file_gambar = $this->request->getFile('gambar');
                    $nama_gambar = ($file_gambar->getError() == 4) ? $this->request->getVar('namagambar') : $file_gambar->getName();
                    if ($file_gambar->getError() != 4) $file_gambar->move('assets/gambar/perusahaan/', $nama_gambar);
                    if ($this->request->getVar('namagambar') != 'default.png' && $file_gambar->getError() != 4) unlink('assets/gambar/perusahaan/' . $this->request->getVar('namagambar'));
                    if ($idunik === '') $idunik = buatID();

                    $this->perusahaanModel->save([
                        'id' => $db1[0]->id ?? '',
                        'idunik' => $idunik,
                        'kode' => $this->request->getVar('kode'),
                        'inisial' => strtoupper($this->request->getVar('inisial')),
                        'nama' => $this->request->getVar('deskripsi'),
                        'alamat' => $this->request->getVar('alamat'),
                        'telepon' => $this->request->getVar('telp'),
                        'kota' => $this->request->getVar('kota'),
                        'direktur' => $this->request->getVar('direktur'),
                        'gambar' => $nama_gambar,
                        'kondisi' => $kondisi,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $idunik, "{$this->request->getVar('kode')} ; {$this->request->getVar('deskripsi')}");
                    $this->session->setFlashdata(['pesan' => "{$this->request->getVar('kode')} ; {$this->request->getVar('deskripsi')} {$judul}"]);
                }

                // Konfirmasi
                if ($this->request->getVar('postaction') == 'confirm') {
                    $kondisi = '11' . $db1[0]->kondisi[2];
                    $this->perusahaanModel->save(['id' => $db1[0]->id, 'kondisi' => $kondisi, 'conf_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama}" . lang("app.judul konf")]);
                }

                // Delete
                if ($this->request->getVar('postaction') == 'hapus') {
                    $this->perusahaanModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama}" . lang("app.judul hapus")]);
                }

                //Aktifasi
                if ($this->request->getVar('postaction') == 'aktif') {
                    $hasil = $db1[0]->kondisi[2] == '1' ? ['0', 'nonaktif', lang("app.judul inaktif")] : ['1', 'aktif', lang("app.judul aktif")];
                    $this->perusahaanModel->save(['id' => $db1[0]->id, 'kondisi' => substr($db1[0]->kondisi, 0, 2) . $hasil[0], 'aktif_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama} {$hasil[1]}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama} {$hasil[2]}"]);
                }
                $msg = ['redirect' => '/perusahaan'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
