<?php

namespace App\Controllers\main\barang;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\BarangModel;

class Barang extends BaseController
{
    protected $barangModel;
    public function __construct()
    {
        $this->barangModel = new BarangModel();
    }

    public function index()
    {
        checkPage('102');
        $data = [
            't_judul' => lang('app.barang'),
            't_span' => lang('app.span barang'),
            'link' => '/barang',
            'kategori' => $this->mainModel->distItem('m_barang', 'kategori', 'param', 'barang'),
        ];
        $this->render('main/barang/barang_list', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->satuID('m_barang', $this->request->getVar('datakey'), 'u');
            checkPage('102', $db1, 'y', 'n');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $this->request->getVar('datakey'), "{$db1[0]->kode} ; {$db1[0]->nama}");

            $data = [
                't_modal' => lang('app.barang'),
                'link' => "/barang",
                'merk' => $this->mainModel->distItem('m_barang', 'merk'),
                'kelakun' => $this->mainModel->loadKelakun('stok', 'barang'),
                'satuan' => $this->mainModel->getBerkas('', 'satuan', 't'),
                'kategori' => $this->mainModel->distItem('m_barang', 'kategori', 'param', 'barang'),
                'barang' => $db1,
                'tuser' => $this->user,
                'button' => ['save' => $buttons['bsave'], 'conf' => $buttons['bconf'], 'del' => $buttons['bdel'], 'aktif' => $buttons['baktif']],
                'btnaktif' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.btn aktif') : lang('app.btn inaktif')),
                'acby' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.inacby') : lang('app.acby')),
            ];
            $msg = ['data' => view('main/barang/barang_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->satuID('m_barang', $this->request->getVar('idunik'));
            $rule_kode = ($db1 ? ($db1[0]->kode != $this->request->getVar('kode') ? 'required|is_unique[m_barang.kode]' : 'required') : 'required|is_unique[m_barang.kode]');
            $idunik = $this->request->getVar('idunik');

            $validationRules = [
                'kode' => ['rules' => $rule_kode, 'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unik")]],
                'deskripsi' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'kategori' => ['rules' => 'required', 'errors' => ['required' => lang("app.err pilih")]],
                'gambar' => [
                    'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/bmp,image/png]',
                    'errors' => ['max_size' => lang("app.err file1"), 'is_image' => lang("app.err notimg"), 'mime_in' => lang("app.err filemime")]
                ],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'kode' => $this->validation->getError('kode'),
                        'deskripsi' => $this->validation->getError('deskripsi'),
                        'kategori' => $this->validation->getError('kategori'),
                        'gambar' => $this->validation->getError('gambar'),
                    ]
                ];
            } else {
                //Simpan
                if ($this->request->getVar('postaction') == 'save') {
                    $kondisi = (empty($db1) ? '001' : $db1[0]->kondisi[0] . '0' . $db1[0]->kondisi[2]);
                    $sebes = implode('', [$this->request->getVar('serial') == 'on' ? '1' : '0', $this->request->getVar('bekas') == 'on' ? '1' : '0', $this->request->getVar('stok') == 'on' ? '1' : '0']);
                    $kelakun = $this->request->getVar('stok') == 'on' ? $this->request->getVar('kelakun') : '';
                    $judul = (empty($db1) ? lang('app.judul buat') : lang('app.judul ubah'));

                    $file_gambar = $this->request->getFile('gambar');
                    $nama_gambar = ($file_gambar->getError() == 4) ? $this->request->getVar('namagambar') : $file_gambar->getName();
                    if ($file_gambar->getError() != 4) $file_gambar->move('assets/gambar/barang/', $nama_gambar);
                    if ($this->request->getVar('namagambar') != 'default.png' && $file_gambar->getError() != 4) unlink('assets/gambar/barang/' . $this->request->getVar('namagambar'));
                    if ($idunik === '') $idunik = buatID();
                    $this->barangModel->save([
                        'id' => $db1[0]->id ?? '',
                        'idunik' => $idunik,
                        'param' => 'barang',
                        'kode' => strtoupper($this->request->getVar('kode')),
                        'partnumber' => $this->request->getVar('partnumber'),
                        'nama' => $this->request->getVar('deskripsi'),
                        'kategori' => $this->request->getVar('kategori'),
                        'merk' => $this->request->getVar('merk'),
                        'satuan' => $this->request->getVar('satuan'),
                        'kakun_id' => $kelakun,
                        'stokmin' => $this->request->getVar('stokmin'),
                        'sebes' => $sebes,
                        'gambar' => $nama_gambar,
                        'catatan' => $this->request->getVar('catatan'),
                        'kondisi' => $kondisi,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $idunik, strtoupper($this->request->getVar('kode')) . ' ; ' . $this->request->getVar('deskripsi'));
                    $this->session->setFlashdata(['pesan' => strtoupper($this->request->getVar('kode')) . ' ; ' . $this->request->getVar('deskripsi') . $judul, 'flash-kate' => $this->request->getVar('kategori')]);
                }

                // Konfirmasi
                if ($this->request->getVar('postaction') == 'confirm') {
                    $kondisi = '11' . $db1[0]->kondisi[2];
                    $this->barangModel->save(['id' => $db1[0]->id, 'kondisi' => $kondisi, 'conf_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama}" . lang("app.judul konf"), 'flash-kate' => $db1[0]->kategori]);
                }

                // Delete
                if ($this->request->getVar('postaction') == 'hapus') {
                    $this->barangModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama}" . lang("app.judul hapus"), 'flash-kate' => $db1[0]->kategori]);
                }

                //Aktifasi
                if ($this->request->getVar('postaction') == 'aktif') {
                    $hasil = $db1[0]->kondisi[2] == '1' ? ['0', 'nonaktif', lang("app.judul inaktif")] : ['1', 'aktif', lang("app.judul aktif")];
                    $this->barangModel->save(['id' => $db1[0]->id, 'kondisi' => substr($db1[0]->kondisi, 0, 2) . $hasil[0], 'aktif_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama} {$hasil[1]}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama} {$hasil[2]}", 'flash-kate' => $db1[0]->kategori]);
                }
                $msg = ['redirect' => '/barang'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function cariBarang()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'barang' => $this->mainModel->getBarang($this->urls[1], 'barang', $this->request->getVar('kategori')),
                'tuser' => $this->user,
            ];
            $msg = ['data' => view('x-main/barang_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
