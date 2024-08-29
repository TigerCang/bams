<?php

namespace App\Controllers\main\akuntansi;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\AkunModel;

class Akuntansi extends BaseController
{
    protected $akunModel;
    public function __construct()
    {
        $this->akunModel = new AkunModel();
    }

    public function index()
    {
        checkPage('102');
        $data = [
            't_judul' => lang('app.akuntansi'),
            't_span' => lang('app.span akuntansi'),
            'link' => '/akuntansi',
            'selkategori' => $this->mainModel->distSelect('kategori akun'),
        ];
        $this->render('main/akuntansi/akun_list', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->satuID('m_akun', $this->request->getVar('datakey'), 'u');
            checkPage('102', $db1, 'y', 'n');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $this->request->getVar('datakey'), "{$db1[0]->kode} ; {$db1[0]->nama}");

            $data = [
                't_modal' => lang('app.akuntansi'),
                'link' => "/akuntansi",
                'selkategori' => $this->mainModel->distSelect('kategori akun'),
                'akun' => $db1,
                'tuser' => $this->user,
                'button' => ['save' => $buttons['bsave'], 'conf' => $buttons['bconf'], 'del' => $buttons['bdel'], 'aktif' => $buttons['baktif']],
                'btnaktif' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.btn aktif') : lang('app.btn inaktif')),
                'acby' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.inacby') : lang('app.acby')),
            ];
            $msg = ['data' => view('main/akuntansi/akun_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->satuID('m_akun', $this->request->getVar('idunik'));
            $kode = $this->mainModel->cekAkun($this->request->getVar('noakun'), $this->request->getVar('idunik'));
            $rule_kode = ($kode ? 'required|is_unique[m_akun.kode]' : 'required');
            $idunik = $this->request->getVar('idunik');
            if (substr($this->request->getVar('kode'), 1) == '00.000') {
                $level = "1";
                $akunInduk = '';
            } elseif (substr($this->request->getVar('kode'), 2) == '0.000') {
                $level = "2";
                $levelInduk = "1";
                $akunInduk = substr($this->request->getVar('noakun'), 0, 2) . "00.000";
            } elseif (substr($this->request->getVar('kode'), 3) == '.000') {
                $level = "3";
                $levelInduk = "2";
                $akunInduk = substr($this->request->getVar('noakun'), 0, 3) . "0.000";
            } else {
                $level = "4";
                $levelInduk = "3";
                $akunInduk = substr($this->request->getVar('noakun'), 0, 4) . ".000";
            }
            if (strlen($this->request->getVar('kode')) == "7") {
                if ($level != "1") {
                    $cekInduk = $this->mainModel->cekAkun($akunInduk, '', $levelInduk);
                    ($cekInduk ? $indukid = $cekInduk[0]->id : $rule_kode = 'valid_email');
                } else {
                    $indukid = "0";
                }
            }

            $validationRules = [
                'kode' =>      ['rules' => $rule_kode, 'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unik"), 'valid_email' => lang("app.err unik")]],
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
                    if ($idunik === '') $idunik = buatID();
                    $this->akunModel->save([
                        'id' => $db1[0]->id ?? '',
                        'idunik' => $idunik,
                        'kode' => $this->request->getVar('noakun'),
                        'nama' => $this->request->getVar('deskripsi'),
                        'level' => $level,
                        'kategori' => $this->request->getVar('xkategori'),
                        'induk_id' => $indukid,
                        'posisi' => ($this->request->getVar('posisi') == 'on' ? '1' : '0'),
                        'kondisi' => $kondisi,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $idunik, "{$this->request->getVar('noakun')} ; {$this->request->getVar('deskripsi')}");
                    $this->session->setFlashdata(['pesan' => "{$this->request->getVar('noakun')} ; {$this->request->getVar('deskripsi')} {$judul}", 'flash-kate' => $this->request->getVar('xkategori')]);
                }

                // Konfirmasi
                if ($this->request->getVar('postaction') == 'confirm') {
                    $kondisi = '11' . $db1[0]->kondisi[2];
                    $this->akunModel->save(['id' => $db1[0]->id, 'kondisi' => $kondisi, 'conf_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama}" . lang("app.judul konf"), 'flash-kate' => $db1[0]->kategori]);
                }

                // Delete
                if ($this->request->getVar('postaction') == 'hapus') {
                    $this->akunModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama}" . lang("app.judul hapus"), 'flash-kate' => $db1[0]->kategori]);
                }

                //Aktifasi
                if ($this->request->getVar('postaction') == 'aktif') {
                    $hasil = $db1[0]->kondisi[2] == '1' ? ['0', 'nonaktif', lang("app.judul inaktif")] : ['1', 'aktif', lang("app.judul aktif")];
                    $this->akunModel->save(['id' => $db1[0]->id, 'kondisi' => substr($db1[0]->kondisi, 0, 2) . $hasil[0], 'aktif_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama} {$hasil[1]}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama} {$hasil[2]}", 'flash-kate' => $db1[0]->kategori]);
                }
                $msg = ['redirect' => '/akuntansi'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function cariData()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'akun' => $this->mainModel->getAkun($this->urls[1], $this->request->getVar('kategori')),
                'tuser' => $this->user,
            ];
            $msg = ['data' => view('x-main/akun_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
