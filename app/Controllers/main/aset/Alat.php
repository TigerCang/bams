<?php

namespace App\Controllers\main\aset;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\AlatModel;

class Alat extends BaseController
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
            't_judul' => lang('app.alat'),
            't_span' => lang('app.span alat'),
            'link' => '/alat',
            'perusahaan' => $this->mainModel->getPerusahaan('', 't'),
        ];
        $this->render('main/aset/alat_list', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function inputData()
    {
        $db1 = $this->mainModel->satuID('m_alat', $this->request->getVar('datakey'), 'u');
        checkPage('101', $db1, 'y', 'n');
        $buttons = setButton($db1);
        if ($db1) $this->logModel->saveLog('Read', $this->request->getVar('datakey'), "{$db1[0]->kode} ; {$db1[0]->nama}");

        $data = [
            't_judul' => lang('app.alat'),
            't_span' => lang('app.span alat'),
            'link' => "/alat",
            'perusahaan' => $this->mainModel->getPerusahaan('', 't'),
            'wilayah' => $this->mainModel->getBerkas('', 'wilayah', 't'),
            'divisi' => $this->mainModel->getBerkas('', 'divisi', 't'),
            'selbentuk' => $this->mainModel->distSelect('bentuk'),
            'selsusut' => $this->mainModel->distSelect('sistem susut'),
            'kelakun' => $this->mainModel->loadKelakun('aset', 'alat tool'),
            'kbli' => $this->mainModel->getKBLI('', 'kode baku', 't'),
            'selkategori' => $this->mainModel->distItem('m_alat', 'kategori', 'param', 'alat'),
            'seljenis' => $this->mainModel->distItem('m_alat', 'jenis'),
            'biaya1' => $this->mainModel->satuID('m_biaya', $db1[0]->sumberdaya_id ?? '', '', 'id'),
            'alat' => $db1,
            'button' => ['save' => $buttons['bsave'], 'conf' => $buttons['bconf'], 'del' => $buttons['bdel'], 'aktif' => $buttons['baktif']],
            'btnaktif' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.btn aktif') : lang('app.btn inaktif')),
            'acby' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.inacby') : lang('app.acby')),
        ];
        $this->render('main/aset/alat_input', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->satuID('m_alat', $this->request->getVar('idunik'));
            $rule_kode = ($db1 ? ($db1[0]->kode != strtoupper($this->request->getVar('kode')) ? 'required|is_unique[m_alat.kode]|min_length[10]' : 'required|min_length[10]') : 'required|is_unique[m_alat.kode]|min_length[10]');
            $idunik = $this->request->getVar('idunik');

            $validationRules = [
                'kode' => [
                    'rules' => $rule_kode,
                    'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unik"), 'min_length' => lang("app.err length", [10])]
                ],
                'deskripsi' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'biaya' => ['rules' => 'required', 'errors' => ['required' => lang("app.err pilih")]],
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
                        'biaya' => $this->validation->getError('biaya'),
                        'gambar' => $this->validation->getError('gambar'),
                    ]
                ];
            } else {
                //Simpan
                if ($this->request->getVar('postaction') == 'save') {
                    $kondisi = (empty($db1) ? '001' : $db1[0]->kondisi[0] . '0' . $db1[0]->kondisi[2]);
                    $judul = (empty($db1) ? lang('app.judul buat') : lang('app.judul ubah'));
                    $perusahaan = (isset($db1[0]->kondisi[0]) && $db1[0]->kondisi[0] == '1' ? $db1[0]->perusahaan_id : $this->request->getVar('perusahaan'));
                    $wilayah = ((isset($db1[0]->kondisi[0]) && $db1[0]->kondisi[0] == '1') ? ($this->user['act_akses'][8] == '1' ? $this->request->getVar('wilayah') : $db1[0]->wilayah_id) : $this->request->getVar('wilayah'));
                    $divisi = (isset($db1[0]->kondisi[0]) && $db1[0]->kondisi[0] == '1' ? $db1[0]->divisi_id : $this->request->getVar('divisi'));

                    $file_gambar = $this->request->getFile('gambar');
                    $nama_gambar = ($file_gambar->getError() == 4) ? $this->request->getVar('namagambar') : $file_gambar->getName();
                    if ($file_gambar->getError() != 4) $file_gambar->move('assets/gambar/alat/', $nama_gambar);
                    if ($this->request->getVar('namagambar') != 'default.png' && $file_gambar->getError() != 4) unlink('assets/gambar/alat/' . $this->request->getVar('namagambar'));
                    if ($idunik === '') $idunik = buatID();
                    $this->alatModel->save([
                        'id' => $db1[0]->id ?? '',
                        'idunik' => $idunik,
                        'param' => 'alat',
                        'kode' => strtoupper($this->request->getVar('kode')),
                        'nomor' => strtoupper($this->request->getVar('nomor')),
                        'nama' => $this->request->getVar('deskripsi'),
                        'model' => $this->request->getVar('model'),
                        'merk' => $this->request->getVar('merk'),
                        'kategori' => $this->request->getVar('kategori'),
                        'jenis' => $this->request->getVar('jenis'),
                        // 'pegawai_id' => $this->request->getVar('pegawai'),
                        'sumberdaya_id' => $this->request->getVar('biaya'),
                        'kbli_id' => $this->request->getVar('kbli'),
                        'kakun_id' => $this->request->getVar('kelakun'),
                        'bukti' => $this->request->getVar('faktur'),
                        'ibbm' => $this->request->getVar('ibbm'),
                        'berat' => $this->request->getVar('kapasitas'),
                        'tgl_beli' => $this->request->getVar('tglbeli'),
                        'tgl_produksi' => $this->request->getVar('tglbuat'),
                        'tgl_stnk' => $this->request->getVar('tglstnk'),
                        'tgl_keur' => $this->request->getVar('tglkir'),
                        'mode_susut' => $this->request->getVar('modesusut'),
                        'umur' => $this->request->getVar('umur'),
                        'sisa' => $this->request->getVar('sisa'),
                        'ni_beli' => ubahSeparator($this->request->getVar('nibeli')),
                        'ni_residu' => ubahSeparator($this->request->getVar('niresidu')),
                        'ni_sewa' => ubahSeparator($this->request->getVar('nisewa')),
                        'ni_susut' => ubahSeparator($this->request->getVar('nisusut')),
                        'perusahaan_id' => $perusahaan,
                        'wilayah_id' => $wilayah,
                        'divisi_id' => $divisi,
                        'perusahaanin_id' => $this->request->getVar('perusahaaninternal'),
                        'gambar' => $nama_gambar,
                        'dokumen' => $this->request->getVar('dokumen'),
                        'mesin' => $this->request->getVar('mesin'),
                        'transmisi' => $this->request->getVar('transmisi'),
                        'catatan' => $this->request->getVar('catatan'),
                        'kondisi' => $kondisi,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $idunik, strtoupper($this->request->getVar('kode')) . ' ; ' . $this->request->getVar('deskripsi'));
                    $this->session->setFlashdata(['pesan' => strtoupper($this->request->getVar('kode')) . ' ; ' . $this->request->getVar('deskripsi') . $judul, 'flash-perus' => $perusahaan]);
                }

                //Konfirmasi
                if ($this->request->getVar('postaction') == 'confirm') {
                    $kondisi = '11' . $db1[0]->kondisi[2];
                    $this->alatModel->save(['id' => $db1[0]->id, 'kondisi' => $kondisi, 'conf_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama}" . lang("app.judul konf"), 'flash-perus' => $db1[0]->perusahaan_id]);
                }

                // Delete
                if ($this->request->getVar('postaction') == 'hapus') {
                    $this->alatModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama}" . lang("app.judul hapus"), 'flash-perus' => $db1[0]->perusahaan_id]);
                }

                //Aktifasi
                if ($this->request->getVar('postaction') == 'aktif') {
                    $kondisi = $db1[0]->kondisi[2] == '1';
                    $akhir = $kondisi ? '0' : '1';
                    $onoff = $kondisi ? 'nonaktif' : 'aktif';
                    $judul = $kondisi ? lang("app.judul inaktif") : lang("app.judul aktif");

                    $this->alatModel->save(['id' => $db1[0]->id, 'kondisi' => substr($db1[0]->kondisi, 0, 2) . $akhir, 'aktif_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama} {$onoff}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama} {$judul}", 'flash-perus' => $db1[0]->perusahaan_id]);
                }
                $msg = ['redirect' => '/alat'];
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
                'alat' => $this->mainModel->getAlat($this->urls[1], '', 'alat', $this->request->getVar('perusahaan')),
                'tuser' => $this->user,
                'pckn' => '1100', //perusahaan code kategori nomor
            ];
            $msg = ['data' => view('x-main/alat_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
