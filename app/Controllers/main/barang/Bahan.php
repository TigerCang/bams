<?php

namespace App\Controllers\main\barang;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\BarangModel;

class Bahan extends BaseController
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
            't_judul' => lang('app.bahan'),
            't_span' => lang('app.span bahan'),
            'link' => '/bahan',
            'kategori' => $this->mainModel->distItem('m_barang', 'kategori', 'param', 'bahan'),
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
                't_modal' => lang('app.bahan'),
                'link' => "/bahan",
                'kategori' => $this->mainModel->distItem('m_barang', 'kategori', 'param', 'bahan'),
                'kelakun' => $this->mainModel->loadKelakun('stok', 'bahan'),
                'biaya1' => $this->mainModel->satuID('m_biaya', $db1[0]->sumberdaya_id ?? '', '', 'id'),
                'barang' => $db1,
                'tuser' => $this->user,
                'button' => ['save' => $buttons['bsave'], 'conf' => $buttons['bconf'], 'del' => $buttons['bdel'], 'aktif' => $buttons['baktif']],
                'btnaktif' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.btn aktif') : lang('app.btn inaktif')),
                'acby' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.inacby') : lang('app.acby')),
            ];
            $msg = ['data' => view('main/barang/bahan_input', $data)];
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
            $rule_kode = ($db1 ? ($db1[0]->sumberdaya_id != $this->request->getVar('biaya') ? 'required|is_unique[m_barang.sumberdaya_id]' : 'required') : 'required|is_unique[m_barang.sumberdaya_id]');
            $idunik = $this->request->getVar('idunik');

            $validationRules = [
                'biaya' => ['rules' => $rule_kode, 'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unik")]],
                'kategori' => ['rules' => 'required', 'errors' => ['required' => lang("app.err pilih")]],
                'gambar' => [
                    'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/bmp,image/png]',
                    'errors' => ['max_size' => lang("app.err file1"), 'is_image' => lang("app.err notimg"), 'mime_in' => lang("app.err filemime")]
                ],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'biaya' => $this->validation->getError('biaya'),
                        'kategori' => $this->validation->getError('kategori'),
                        'gambar' => $this->validation->getError('gambar'),
                    ]
                ];
            } else {
                $biaya1 = $this->mainModel->satuID('m_biaya', $this->request->getVar('biaya'), '', 'id');
                //Simpan
                if ($this->request->getVar('postaction') == 'save') {
                    $kondisi = (empty($db1) ? '001' : $db1[0]->kondisi[0] . '0' . $db1[0]->kondisi[2]);
                    $judul = (empty($db1) ? lang('app.judul buat') : lang('app.judul ubah'));

                    $file_gambar = $this->request->getFile('gambar');
                    $nama_gambar = ($file_gambar->getError() == 4) ? $this->request->getVar('namagambar') : $file_gambar->getName();
                    if ($file_gambar->getError() != 4) $file_gambar->move('assets/gambar/barang/', $nama_gambar);
                    if ($this->request->getVar('namagambar') != 'default.png' && $file_gambar->getError() != 4) unlink('assets/gambar/barang/' . $this->request->getVar('namagambar'));
                    if ($idunik === '') $idunik = buatID();
                    $this->barangModel->save([
                        'id' => $db1[0]->id ?? '',
                        'idunik' => $idunik,
                        'param' => 'bahan',
                        'kode' => $biaya1[0]->kode,
                        'sumberdaya_id' => $this->request->getVar('biaya'),
                        'nama' => $biaya1[0]->nama,
                        'kategori' => $this->request->getVar('kategori'),
                        'satuan' => $biaya1[0]->satuan,
                        'kakun_id' => $this->request->getVar('kelakun'),
                        'harga' => ubahSeparator($this->request->getVar('harga')),
                        'sebes' => '000',
                        'gambar' => $nama_gambar,
                        'catatan' => $this->request->getVar('catatan'),
                        'kondisi' => $kondisi,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $idunik, "{$biaya1[0]->kode} ; {$biaya1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$biaya1[0]->kode} ; {$biaya1[0]->nama} {$judul}", 'flash-kate' => $this->request->getVar('kategori')]);
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
                $msg = ['redirect' => '/bahan'];
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
                'barang' => $this->mainModel->getBarang($this->urls[1], 'bahan', $this->request->getVar('kategori')),
                'tuser' => $this->user,
            ];
            $msg = ['data' => view('x-main/barang_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function loadSatuan()
    {
        if ($this->request->isAJAX()) {
            $biaya1 = $this->mainModel->satuID('m_biaya', $this->request->getVar('biaya') ?? '', '', 'id');
            $msg = ['satuan' => $biaya1[0]->satuan];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
