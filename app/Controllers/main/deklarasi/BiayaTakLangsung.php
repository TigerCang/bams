<?php

namespace App\Controllers\main\deklarasi;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\BiayaModel;

class BiayaTakLangsung extends BaseController
{
    protected $biayaModel;
    public function __construct()
    {
        $this->biayaModel = new BiayaModel();
    }

    public function index()
    {
        checkPage('102');
        $data = [
            't_judul' => lang('app.biaya taklangsung'),
            't_span' => lang('app.span biaya taklangsung'),
            'link' => '/biayataklangsung',
            'asal' => 'biaya taklangsung',
            'kategori' => $this->mainModel->distinctBiaya('biaya taklangsung', '1'),
        ];
        $this->render('main/deklarasi/biaya_list', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->satuID('m_biaya', $this->request->getVar('datakey'), 'u');
            checkPage('102', $db1, 'y', 'n');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $this->request->getVar('datakey'), "{$db1[0]->kode} ; {$db1[0]->nama}");

            $data = [
                't_modal' => lang('app.biaya taklangsung'),
                'link' => "/biayataklangsung",
                'mphid' => 'hidden',
                'khid' => 'hidden',
                'jlhid' => 'hidden',
                'ahid' => '',
                'satuan' => $this->mainModel->getBerkas('', 'satuan', 't'),
                'akun1' => $this->mainModel->satuID('m_akun', $db1[0]->akun_id ?? '', '', 'id'),
                'kategori' => $this->mainModel->getBerkas('', 'kategori proyek'),
                'biaya' => $db1,
                'tuser' => $this->user,
                'button' => ['save' => $buttons['bsave'], 'conf' => $buttons['bconf'], 'del' => $buttons['bdel'], 'aktif' => $buttons['baktif']],
                'btnaktif' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.btn aktif') : lang('app.btn inaktif')),
                'acby' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.inacby') : lang('app.acby')),
            ];
            $msg = ['data' => view('main/deklarasi/biaya_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->satuID('m_biaya', $this->request->getVar('idunik'));
            $idunik = $this->request->getVar('idunik');
            if (substr($this->request->getVar('kode'), 2) == '000000') {
                $level = "1";
            } elseif (substr($this->request->getVar('kode'), 4) == '0000') {
                $level = "2";
                $levelInduk = "1";
                $biayaInduk = substr($this->request->getVar('kode'), 0, 2) . "000000";
            } elseif (substr($this->request->getVar('kode'), 6) == '00') {
                $level = "3";
                $levelInduk = "2";
                $biayaInduk = substr($this->request->getVar('kode'), 0, 4) . "0000";
            } else {
                $level = "4";
                $levelInduk = "3";
                $biayaInduk = substr($this->request->getVar('kode'), 0, 6) . "00";
            }
            $rule_lev4 = ($level == "4" ? 'required' : 'permit_empty');
            $satuan = ($level == "4" ? $this->request->getVar('satuan') : '');
            $akun = ($level == "4" ? $this->request->getVar('akun') : '');
            $cekKode = $this->mainModel->cekBiaya($this->request->getVar('kode'), '', $this->request->getVar('idunik'));
            $rule_kode = ($cekKode ? 'required|is_unique[m_biaya.kode]' : 'required|min_length[8]');
            $indukID = "0";
            if (strlen($this->request->getVar('kode')) == "8" && $level != "1") {
                $cekInduk = $this->mainModel->cekIndukbiaya('biaya taklangsung', strtoupper($biayaInduk), $levelInduk, '');
                ($cekInduk ? $indukID = $cekInduk[0]->id : $rule_kode = 'valid_email');
            }

            $validationRules = [
                'kode' => [
                    'rules' => $rule_kode,
                    'errors' => ['required' => lang("app.err blank"), 'min_length' => lang("app.err length", [8]), 'is_unique' => lang("app.err unik"), 'valid_email' => lang("app.err unik")]
                ],
                'deskripsi' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'satuan' => ['rules' => $rule_lev4, 'errors' => ['required' => lang("app.err pilih")]],
                'akun' => ['rules' => $rule_lev4, 'errors' => ['required' => lang("app.err pilih")]],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'kode' => $this->validation->getError('kode'),
                        'deskripsi' => $this->validation->getError('deskripsi'),
                        'satuan' => $this->validation->getError('satuan'),
                        'akun' => $this->validation->getError('akun'),
                    ]
                ];
            } else {
                //Simpan
                if ($this->request->getVar('postaction') == 'save') {
                    $kondisi = (empty($db1) ? '001' : $db1[0]->kondisi[0] . '0' . $db1[0]->kondisi[2]);
                    $judul = (empty($db1) ? lang('app.judul buat') : lang('app.judul ubah'));
                    if ($idunik === '') $idunik = buatID();
                    $this->biayaModel->save([
                        'id' => $db1[0]->id ?? '',
                        'idunik' => $idunik,
                        'param' => 'biaya taklangsung',
                        'induk_id' => $indukID,
                        'kode' => strtoupper($this->request->getVar('kode')),
                        'nama' => $this->request->getVar('deskripsi'),
                        'satuan' => $satuan,
                        'level' => $level,
                        'akun_id' => $akun,
                        'kondisi' => $kondisi,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $idunik, strtoupper($this->request->getVar('kode')) . ' ; ' . $this->request->getVar('deskripsi'));
                    $this->session->setFlashdata(['pesan' => strtoupper($this->request->getVar('kode')) . ' ; ' . $this->request->getVar('deskripsi') . $judul, 'flash-kate' => substr(strtoupper($this->request->getVar('kode')), 0, 2)]);
                }

                // Konfirmasi
                if ($this->request->getVar('postaction') == 'confirm') {
                    $kondisi = '11' . $db1[0]->kondisi[2];
                    $this->biayaModel->save(['id' => $db1[0]->id, 'kondisi' => $kondisi, 'conf_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama}" . lang("app.judul konf"), 'flash-kate' => substr($db1[0]->kode, 0, 2)]);
                }

                // Delete
                if ($this->request->getVar('postaction') == 'hapus') {
                    $this->biayaModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama}" . lang("app.judul hapus"), 'flash-kate' => substr($db1[0]->kode, 0, 2)]);
                }

                //Aktifasi
                if ($this->request->getVar('postaction') == 'aktif') {
                    $kondisi = $db1[0]->kondisi[2] == '1';
                    $akhir = $kondisi ? '0' : '1';
                    $onoff = $kondisi ? 'nonaktif' : 'aktif';
                    $judul = $kondisi ? lang("app.judul inaktif") : lang("app.judul aktif");

                    $this->biayaModel->save(['id' => $db1[0]->id, 'kondisi' => substr($db1[0]->kondisi, 0, 2) . $akhir, 'aktif_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $idunik, "{$db1[0]->kode} ; {$db1[0]->nama} {$onoff}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->nama} {$judul}", 'flash-kate' => substr($db1[0]->kode, 0, 2)]);
                }
                $msg = ['redirect' => '/biayataklangsung'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
