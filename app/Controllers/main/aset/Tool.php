<?php

namespace App\Controllers\main\aset;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\AlatModel;

class Tool extends BaseController
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
            't_judul' => lang('app.tool'),
            't_span' => lang('app.span tool'),
            'link' => '/tool',
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
            't_judul' => lang('app.tool'),
            't_span' => lang('app.span tool'),
            'link' => "/tool",
            'perusahaan' => $this->mainModel->getPerusahaan('', 't'),
            'wilayah' => $this->mainModel->getBerkas('', 'wilayah', 't'),
            'divisi' => $this->mainModel->getBerkas('', 'divisi', 't'),
            'selbentuk' => $this->mainModel->distSelect('bentuk'),
            'kbli' => $this->mainModel->getKBLI('', 'kode baku', 't'),
            'selkategori' => $this->mainModel->distItem('m_alat', 'kategori', 'param', 'tool'),
            'seljenis' => $this->mainModel->distItem('m_alat', 'jenis'),
            'biaya1' => $this->mainModel->satuID('m_biaya', $db1[0]->sumberdaya_id ?? '', '', 'id'),
            'tool' => $db1,
            'button' => ['save' => $buttons['bsave'], 'conf' => $buttons['bconf'], 'del' => $buttons['bdel'], 'aktif' => $buttons['baktif']],
            'btnaktif' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.btn aktif') : lang('app.btn inaktif')),
            'acby' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.inacby') : lang('app.acby')),
        ];
        $this->render('main/aset/tool_input', $data);
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
                    if ($file_gambar->getError() != 4) $file_gambar->move('assets/gambar/tool/', $nama_gambar);
                    if ($this->request->getVar('namagambar') != 'default.png' && $file_gambar->getError() != 4) unlink('assets/gambar/tool/' . $this->request->getVar('namagambar'));
                    if ($idunik === '') $idunik = buatID();
                    $this->alatModel->save([
                        'id' => $db1[0]->id ?? '',
                        'idunik' => $idunik,
                        'param' => 'tool',
                        'kode' => strtoupper($this->request->getVar('kode')),
                        'nama' => $this->request->getVar('deskripsi'),
                        'merk' => $this->request->getVar('merk'),
                        'kategori' => $this->request->getVar('kategori'),
                        'jenis' => $this->request->getVar('jenis'),
                        // 'pegawai_id' => $this->request->getVar('pegawai'),
                        'sumberdaya_id' => $this->request->getVar('biaya'),
                        'kbli_id' => $this->request->getVar('kbli'),
                        'bukti' => $this->request->getVar('faktur'),
                        'tgl_beli' => $this->request->getVar('tglbeli'),
                        'ni_beli' => ubahSeparator($this->request->getVar('nibeli')),
                        'ni_sewa' => ubahSeparator($this->request->getVar('nisewa')),
                        'perusahaan_id' => $perusahaan,
                        'wilayah_id' => $wilayah,
                        'divisi_id' => $divisi,
                        'gambar' => $nama_gambar,
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
                $msg = ['redirect' => '/tool'];
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
                'alat' => $this->mainModel->getAlat($this->urls[1], '', 'tool', $this->request->getVar('perusahaan')),
                'tuser' => $this->user,
                'pckn' => '1100',
            ];
            $msg = ['data' => view('x-main/alat_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}