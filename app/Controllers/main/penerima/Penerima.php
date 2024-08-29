<?php

namespace App\Controllers\main\penerima;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\PenerimaModel;

class Penerima extends BaseController
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
            't_judul' => lang('app.penerima'),
            't_span' => lang('app.span penerima'),
            'link' => '/penerima',
            'kategori' => $this->mainModel->distItem('m_penerima', 'kategori'),
        ];
        $this->render('main/penerima/penerima_list', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->satuID('m_penerima', $this->request->getVar('datakey'), 'u');
            checkPage('102', $db1, 'y', 'n');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $this->request->getVar('datakey'), "{$db1[0]->kode} ; {$db1[0]->nama}");

            $data = [
                't_modal' => lang('app.penerima'),
                'link' => "/penerima",
                'kategori' => $this->mainModel->distItem('m_penerima', 'kategori'),
                'kelakun1' => $this->mainModel->loadKelakun('penerima', 'pelanggan'),
                'kelakun2' => $this->mainModel->loadKelakun('penerima', 'subkon'),
                'kelakun3' => $this->mainModel->loadKelakun('penerima', 'suplier'),
                'kelakun4' => $this->mainModel->loadKelakun('penerima', 'pegawai'),
                'penerima' => $db1,
                'tuser' => $this->user,
                'button' => ['save' => $buttons['bsave'], 'conf' => $buttons['bconf'], 'del' => $buttons['bdel'], 'aktif' => $buttons['baktif']],
                'btnaktif' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.btn aktif') : lang('app.btn inaktif')),
                'acby' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.inacby') : lang('app.acby')),
            ];
            $msg = ['data' => view('main/penerima/penerima_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->satuID('m_penerima', $this->request->getVar('idunik'));
            $rule_kode = ($db1 ? ($db1[0]->kode != strtoupper($this->request->getVar('kode')) ? 'required|is_unique[m_penerima.kode]|min_length[16]' : 'required|min_length[16]') : 'required|is_unique[m_penerima.kode]|min_length[16]');
            $rule_kel1 = ($this->request->getVar('pelanggan') == 'on' ? 'required' : 'permit_empty');
            $rule_kel2 = ($this->request->getVar('lain') == 'on' ? 'required' : 'permit_empty');
            $rule_kel3 = ($this->request->getVar('suplier') == 'on' ? 'required' : 'permit_empty');
            $idunik = $this->request->getVar('idunik');

            $validationRules = [
                'kode' => [
                    'rules' => $rule_kode,
                    'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unik"), 'min_length' => lang("app.err length", [16])]
                ],
                'deskripsi' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'kategori' => ['rules' => 'required', 'errors' => ['required' => lang("app.err pilih")]],
                'kelakun1' => ['rules' => $rule_kel1, 'errors' => ['required' => lang("app.err pilih")]],
                'kelakun2' => ['rules' => $rule_kel2, 'errors' => ['required' => lang("app.err pilih")]],
                'kelakun3' => ['rules' => $rule_kel3, 'errors' => ['required' => lang("app.err pilih")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'kode' => $this->validation->getError('kode'),
                        'deskripsi' => $this->validation->getError('deskripsi'),
                        'kategori' => $this->validation->getError('kategori'),
                        'kelakun1' => $this->validation->getError('kelakun1'),
                        'kelakun2' => $this->validation->getError('kelakun2'),
                        'kelakun3' => $this->validation->getError('kelakun3'),
                    ]
                ];
            } else {
                //Simpan
                if ($this->request->getVar('postaction') == 'save') {
                    $kondisi = (empty($db1) ? '001' : $db1[0]->kondisi[0] . '0' . $db1[0]->kondisi[2]);
                    $judul = (empty($db1) ? lang('app.judul buat') : lang('app.judul ubah'));
                    $pel = ($this->request->getVar('pelanggan') == 'on' ? '1' : '0');
                    $sup = ($this->request->getVar('suplier') == 'on' ? '1' : '0');
                    $lain = ($this->request->getVar('lain') == 'on' ? '1' : '0');
                    $peg = (empty($db1) ? '00' : substr($db1[0]->is_alias, -2));
                    $alias = $pel . $sup . $lain . $peg;
                    if ($idunik === '') $idunik = buatID();
                    $this->penerimaModel->save([
                        'id' => $db1[0]->id ?? '',
                        'idunik' => $idunik,
                        'kode' => strtoupper($this->request->getVar('kode')),
                        'nama' => $this->request->getVar('deskripsi'),
                        'email' => $this->request->getVar('surel'),
                        'kategori' => $this->request->getVar('kategori'),
                        'alamat' => $this->request->getVar('alamat'),
                        'kontak' => $this->request->getVar('kontak'),
                        'is_alias' => $alias,
                        'kakun_pelanggan' => ($this->request->getVar('pelanggan') == 'on' ? $this->request->getVar('kelakun1') : ''),
                        'kakun_suplier' => ($this->request->getVar('suplier') == 'on' ? $this->request->getVar('kelakun3') : ''),
                        'kakun_lain' => ($this->request->getVar('lain') == 'on' ? $this->request->getVar('kelakun2') : ''),
                        'catatan' => $this->request->getVar('catatan'),
                        'kondisi' => $kondisi,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $idunik, "{$this->request->getVar('kode')} ; {$this->request->getVar('deskripsi')}");
                    $this->session->setFlashdata(['pesan' => "{$this->request->getVar('kode')} ; {$this->request->getVar('deskripsi')} {$judul}", 'flash-kate' => $this->request->getVar('kategori')]);
                }

                // Konfirmasi
                if ($this->request->getVar('postaction') == 'confirm') {
                    $kondisi = '11' . $db1[0]->kondisi[2];
                    $this->penerimaModel->save(['id' => $db1[0]->id, 'kondisi' => $kondisi, 'conf_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama}" . lang("app.judul konf"), 'flash-kate' => $db1[0]->kategori]);
                }

                // Delete
                if ($this->request->getVar('postaction') == 'hapus') {
                    $this->penerimaModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama}" . lang("app.judul hapus"), 'flash-kate' => $db1[0]->kategori]);
                }

                //Aktifasi
                if ($this->request->getVar('postaction') == 'aktif') {
                    $hasil = $db1[0]->kondisi[2] == '1' ? ['0', 'nonaktif', lang("app.judul inaktif")] : ['1', 'aktif', lang("app.judul aktif")];
                    $this->penerimaModel->save(['id' => $db1[0]->id, 'kondisi' => substr($db1[0]->kondisi, 0, 2) . $hasil[0], 'aktif_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama} {$hasil[1]}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama} {$hasil[2]}", 'flash-kate' => $db1[0]->kategori]);
                }
                $msg = ['redirect' => '/penerima'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function cariPenerima()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'penerima' => $this->mainModel->getPenerima($this->urls[1], '', '', '', '', $this->request->getVar('kategori')),
                'tuser' => $this->user,
            ];
            $msg = ['data' => view('x-main/penerima_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
