<?php

namespace App\Controllers\main\sdm;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\PenerimaModel;

class Pegawai extends BaseController
{
    protected $penerimaModel;
    public function __construct()
    {
        $this->penerimaModel = new PenerimaModel();
    }

    public function index()
    {
        checkPage('102');
        $data = [
            't_judul' => lang('app.pegawai'),
            't_span' => lang('app.span pegawai'),
            'link' => '/pegawai',
            'perusahaan' => $this->mainModel->getPerusahaan('', 't'),
        ];
        $this->render('main/sdm/pegawai_list', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function inputData()
    {
        $db1 = $this->mainModel->satuID('m_penerima', $this->request->getVar('datakey'), 'u');
        checkPage('101', $db1, 'y', 'n');
        $buttons = setButton($db1);
        if ($db1) $this->logModel->saveLog('Read', $this->request->getVar('datakey'), "{$db1[0]->kode} ; {$db1[0]->nip} ; {$db1[0]->nama}");

        $data = [
            't_judul' => lang('app.pegawai'),
            't_span' => lang('app.span pegawai'),
            'link' => "/pegawai",
            'perusahaan' => $this->mainModel->getPerusahaan('', 't'),
            'wilayah' => $this->mainModel->getBerkas('', 'wilayah', 't'),
            'divisi' => $this->mainModel->getBerkas('', 'divisi', 't'),
            'kelakun' => $this->mainModel->loadKelakun('penerima', 'pegawai'),
            'jabatan' => $this->mainModel->getBerkas('', 'jabatan', 't'),
            'golongan' => $this->mainModel->getBerkas('', 'golongan', 't'),
            'seldarah' => $this->mainModel->distSelect('golongan darah'),
            'selkelptkp' => $this->mainModel->distSelect('ptkp', 't'),
            'selptkp' => $this->mainModel->distSelect('ptkp'),
            'selkelsim' => $this->mainModel->distSelect('sim', 't'),
            'selsim' => $this->mainModel->distSelect('sim'),
            'selijasah' => $this->mainModel->distSelect('ijasah'),
            'seljurusan' => $this->mainModel->distItem('m_penerima', 'jurusan'),
            'selstatijasah' => $this->mainModel->distSelect('status ijasah'),
            'selstatpegawai' => $this->mainModel->distSelect('status pegawai'),
            'selkeluar' => $this->mainModel->distSelect('mode keluar'),
            'cabang1' => $this->mainModel->satuID('m_cabang', $db1[0]->cabang_id ?? '', '', 'id'),
            'user1' => $this->mainModel->satuID('m_user', $db1[0]->user_id ?? '', '', 'id'),
            'atasan1' => $this->mainModel->satuID('m_penerima', $db1[0]->atasan_id ?? '', '', 'id'),
            'pegawai' => $db1,
            'button' => ['save' => $buttons['bsave'], 'conf' => $buttons['bconf'], 'del' => $buttons['bdel'], 'aktif' => $buttons['baktif']],
            'btnaktif' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.btn aktif') : lang('app.btn inaktif')),
            'acby' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.inacby') : lang('app.acby')),
        ];
        $this->render('main/sdm/pegawai_input', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->satuID('m_penerima', $this->request->getVar('idunik'));
            $rule_kode = ($db1 ? ($db1[0]->kode != strtoupper($this->request->getVar('kode')) ? 'required|is_unique[m_penerima.kode]|min_length[16]' : 'required|min_length[16]') : 'required|is_unique[m_penerima.kode]|min_length[16]');
            $idunik = $this->request->getVar('idunik');

            $validationRules = [
                'kode' => [
                    'rules' => $rule_kode,
                    'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unik"), 'min_length' => lang("app.err length", [16])]
                ],
                'nip' => ['rules' => 'required', 'errors' => ['required' => lang("app.err pilih")]],
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
                        'nip' => $this->validation->getError('nip'),
                        'deskripsi' => $this->validation->getError('deskripsi'),
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
                    $jabatan = ((isset($db1[0]->kondisi[0]) && $db1[0]->kondisi[0] == '1') ? ($this->user['act_akses'][8] == '1' ? $this->request->getVar('jabatan') : $db1[0]->jabatan_id) : $this->request->getVar('jabatan'));
                    $alias = '0001' . ($this->request->getVar('osm') == 'on' ? '1' : '0');

                    $file_gambar = $this->request->getFile('gambar');
                    $nama_gambar = ($file_gambar->getError() == 4) ? $this->request->getVar('namagambar') : $file_gambar->getName();
                    if ($file_gambar->getError() != 4) $file_gambar->move('assets/gambar/pegawai/', $nama_gambar);
                    if ($this->request->getVar('namagambar') != 'default.png' && $file_gambar->getError() != 4) unlink('assets/gambar/pegawai/' . $this->request->getVar('namagambar'));
                    if ($idunik === '') $idunik = buatID();
                    $this->penerimaModel->save([
                        'id' => $db1[0]->id ?? '',
                        'idunik' => $idunik,
                        'kode' => strtoupper($this->request->getVar('kode')),
                        'nip' => $this->request->getVar('nip'),
                        'nama' => $this->request->getVar('deskripsi'),
                        'kategori' => 'Pegawai',
                        'cabang_id' => $this->request->getVar('cabang') ?? '',
                        'lokasi' => $this->request->getVar('lokasi'),
                        'kelamin' => $this->request->getVar('kelamin'),
                        'darah' => $this->request->getVar('darah'),
                        't4lahir' => $this->request->getVar('t4lahir'),
                        'tgl_lahir' => $this->request->getVar('tgllahir'),
                        'alamat' => $this->request->getVar('alamat'),
                        'kontak' => $this->request->getVar('kontak'),
                        'email' => $this->request->getVar('surel'),
                        'ijasah' => $this->request->getVar('ijasah'),
                        'jurusan' => $this->request->getVar('jurusan'),
                        'st_ijasah' => $this->request->getVar('statijasah'),
                        'tgl_ijasah' => $this->request->getVar('tglijasah'),
                        'jenis_sim' => $this->request->getVar('jenissim'),
                        'nosim' => $this->request->getVar('nosim'),
                        'tgl_sim' => $this->request->getVar('tglsim'),
                        'st_ptkp' => $this->request->getVar('ptkp'),
                        'tgl_join' => $this->request->getVar('tglgabung'),
                        'st_pegawai' => $this->request->getVar('statpegawai'),
                        'tgl_kontrakaw' => $this->request->getVar('tglkontrakaw'),
                        'tgl_kontrakak' => $this->request->getVar('tglkontrakak'),
                        'pilih_keluar' => $this->request->getVar('keluar'),
                        'tgl_keluar' => $this->request->getVar('tglkeluar'),
                        'alasan_keluar' => $this->request->getVar('alasankeluar'),
                        'jabatan_id' => $jabatan,
                        'golongan_id' => $this->request->getVar('golongan'),
                        'user_id' => $this->request->getVar('usernama') ?? '',
                        'atasan_id' => $this->request->getVar('atasan') ?? '',
                        'asuransi' => $this->request->getVar('asuransi'),
                        'is_alias' => $alias,
                        'kakun_pegawai' => $this->request->getVar('kelakun'),
                        'perusahaan_id' => $perusahaan,
                        'wilayah_id' => $wilayah,
                        'divisi_id' => $divisi,
                        'gambar' => $nama_gambar,
                        'catatan' => $this->request->getVar('catatan'),
                        'kondisi' => $kondisi,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $idunik, strtoupper($this->request->getVar('kode')) . ' ; ' .  $this->request->getVar('nip') . ' ; ' . $this->request->getVar('deskripsi'));
                    $this->session->setFlashdata(['pesan' => strtoupper($this->request->getVar('kode')) . ' ; ' .  $this->request->getVar('nip') . ' ; ' . $this->request->getVar('deskripsi') . $judul, 'flash-perus' => $perusahaan]);
                }

                //Konfirmasi
                if ($this->request->getVar('postaction') == 'confirm') {
                    $kondisi = '11' . $db1[0]->kondisi[2];
                    $this->penerimaModel->save(['id' => $db1[0]->id, 'kondisi' => $kondisi, 'conf_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $idunik, "{$db1[0]->kode} ; {$db1[0]->nip} ; {$db1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nip} ; {$db1[0]->nama}" . lang("app.judul konf"), 'flash-perus' => $db1[0]->perusahaan_id]);
                }

                // Delete
                if ($this->request->getVar('postaction') == 'hapus') {
                    $this->penerimaModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $idunik, "{$db1[0]->kode} ; {$db1[0]->nip} ; {$db1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nip} ; {$db1[0]->nama}" . lang("app.judul hapus"), 'flash-perus' => $db1[0]->perusahaan_id]);
                }

                //Aktifasi
                if ($this->request->getVar('postaction') == 'aktif') {
                    $kondisi = $db1[0]->kondisi[2] == '1';
                    $akhir = $kondisi ? '0' : '1';
                    $onoff = $kondisi ? 'nonaktif' : 'aktif';
                    $judul = $kondisi ? lang("app.judul inaktif") : lang("app.judul aktif");

                    $this->penerimaModel->save(['id' => $db1[0]->id, 'kondisi' => substr($db1[0]->kondisi, 0, 2) . $akhir, 'aktif_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $idunik, "{$db1[0]->kode} ; {$db1[0]->nip} ; {$db1[0]->nama} {$onoff}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nip} ; {$db1[0]->nama} {$judul}", 'flash-perus' => $db1[0]->perusahaan_id]);
                }
                $msg = ['redirect' => '/pegawai'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    public function cariPegawai()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'pegawai' => $this->mainModel->getPenerima($this->urls[1], '1', '', '', $this->request->getVar('perusahaan')),
                'tuser' => $this->user,
            ];
            $msg = ['data' => view('x-main/pegawai_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
