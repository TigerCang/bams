<?php

namespace App\Controllers\main\aset;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\ProyekModel;

class Proyek extends BaseController
{
    protected $proyekModel;
    public function __construct()
    {
        $this->proyekModel = new ProyekModel();
    }

    public function index()
    {
        checkPage('102');
        $data = [
            't_judul' => lang('app.proyek'),
            't_span' => lang('app.span proyek'),
            'link' => '/proyek',
            'perusahaan' => $this->mainModel->getPerusahaan('', 't'),
        ];
        $this->render('main/aset/proyek_list', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function inputData()
    {
        $db1 = $this->mainModel->satuID('m_proyek', $this->request->getVar('datakey'), 'u');
        checkPage('101', $db1, 'y', 'n');
        $buttons = setButton($db1);
        if ($db1) $this->logModel->saveLog('Read', $this->request->getVar('datakey'), "{$db1[0]->kode} ; {$db1[0]->paket}");

        $data = [
            't_judul' => lang('app.proyek'),
            't_span' => lang('app.span proyek'),
            'link' => "/proyek",
            'perusahaan' => $this->mainModel->getPerusahaan('', 't'),
            'wilayah' => $this->mainModel->getBerkas('', 'wilayah', 't'),
            'divisi' => $this->mainModel->getBerkas('', 'divisi', 't'),
            'kbli' => $this->mainModel->getKBLI('', 'kode baku', 't'),
            'kategori' => $this->mainModel->getBerkas('', 'kategori proyek'),
            'propinsi' => $this->mainModel->distItem('m_proyek', 'propinsi'),
            'proyek' => $db1,
            'button' => ['save' => $buttons['bsave'], 'conf' => $buttons['bconf'], 'del' => $buttons['bdel'], 'aktif' => $buttons['baktif']],
            'btnaktif' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.btn aktif') : lang('app.btn inaktif')),
            'acby' => (isset($db1[0]->kondisi[2]) && $db1[0]->kondisi[2] == '0' ? lang('app.inacby') : lang('app.acby')),
        ];
        $this->render('main/aset/proyek_input', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function savedata()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->satuID('m_proyek', $this->request->getVar('idunik'));
            $rule_kode = ($db1 ? ($db1[0]->kode != strtoupper($this->request->getVar('kode')) ? 'required|is_unique[m_proyek.kode]|min_length[10]' : 'required|min_length[10]') : 'required|is_unique[m_proyek.kode]|min_length[10]');
            $idunik = $this->request->getVar('idunik');

            $validationRules = [
                'kode' => [
                    'rules' => $rule_kode,
                    'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unik"), 'min_length' => lang("app.err length", [10])]
                ],
                'deskripsi' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'paket' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'nikontrak' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'kode' => $this->validation->getError('kode'),
                        'deskripsi' => $this->validation->getError('deskripsi'),
                        'paket' => $this->validation->getError('paket'),
                        'nikontrak' => $this->validation->getError('nikontrak'),
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
                    if ($idunik === '') $idunik = buatID();
                    $this->proyekModel->save([
                        'id' => $db1[0]->id ?? '',
                        'idunik' => $idunik,
                        'kode' => strtoupper($this->request->getVar('kode')),
                        'nama' => $this->request->getVar('deskripsi'),
                        'paket' => $this->request->getVar('paket'),
                        'atasnama' => $this->request->getVar('atasnama'),
                        'lokasi' => $this->request->getVar('lokasi'),
                        'propinsi' => $this->request->getVar('propinsi'),
                        'kabupaten' => $this->request->getVar('kabupaten'),
                        'pemilik' => $this->request->getVar('pemilik'),
                        'lingkup' => $this->request->getVar('lingkup'),
                        'carabayar' => $this->request->getVar('carabayar'),
                        'kate_id' => $this->request->getVar('kategori'),
                        'kbli_id' => $this->request->getVar('kbli'),
                        'tgl_kontrak' => $this->request->getVar('tglkontrak'),
                        'tgl_pho' => $this->request->getVar('tglpho'),
                        'tgl_fho' => $this->request->getVar('tglfho'),
                        'ppn' => $this->request->getVar('ppnps'),
                        'pph' => $this->request->getVar('pphps'),
                        'ni_kontrak' => ubahSeparator($this->request->getVar('nikontrak')),
                        'ni_tambah' => ubahSeparator($this->request->getVar('nitbhkur')),
                        'ni_lain' => ubahSeparator($this->request->getVar('nilain')),
                        'ni_bruto' => ubahSeparator($this->request->getVar('nibruto')),
                        'ni_ppn' => ubahSeparator($this->request->getVar('nippn')),
                        'ni_pph' => ubahSeparator($this->request->getVar('nipph')),
                        'ni_netto' => ubahSeparator($this->request->getVar('ninetto')),
                        'periode1' => $this->request->getVar('periode1'),
                        'periode2' => $this->request->getVar('periode2'),
                        'modeyear' => ($this->request->getVar('periode1') == $this->request->getVar('periode2') ? 'Single Year' : 'Multi Year'),
                        'perusahaan_id' => $perusahaan,
                        'wilayah_id' => $wilayah,
                        'divisi_id' => $divisi,
                        'konsultan' => $this->request->getVar('konsultan'),
                        'asuransi' => $this->request->getVar('asuransi'),
                        'keuangan' => $this->request->getVar('keuangan'),
                        'pelaksanaan' => $this->request->getVar('pelaksanaan'),
                        'catatan' => $this->request->getVar('catatan'),
                        'is_pajak' => ($this->request->getVar('pajak') == 'on' ? '1' : '0'),
                        'kondisi' => $kondisi,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $idunik, strtoupper($this->request->getVar('kode')) . ' ; ' . $this->request->getVar('paket'));
                    $this->session->setFlashdata(['pesan' => strtoupper($this->request->getVar('kode')) . ' ; ' . $this->request->getVar('paket') . $judul, 'flash-perus' => $perusahaan]);
                }

                //Konfirmasi
                if ($this->request->getVar('postaction') == 'confirm') {
                    $kondisi = '11' . $db1[0]->kondisi[2];
                    $this->proyekModel->save(['id' => $db1[0]->id, 'kondisi' => $kondisi, 'conf_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $idunik, "{$db1[0]->kode} ; {$db1[0]->paket}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->paket}" . lang("app.judul konf"), 'flash-perus' => $db1[0]->perusahaan_id]);
                }

                // Delete
                if ($this->request->getVar('postaction') == 'hapus') {
                    $this->proyekModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $idunik, "{$db1[0]->kode} ; {$db1[0]->paket}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->paket}" . lang("app.judul hapus"), 'flash-perus' => $db1[0]->perusahaan_id]);
                }

                //Aktifasi
                if ($this->request->getVar('postaction') == 'aktif') {
                    $kondisi = $db1[0]->kondisi[2] == '1';
                    $akhir = $kondisi ? '0' : '1';
                    $onoff = $kondisi ? 'nonaktif' : 'aktif';
                    $judul = $kondisi ? lang("app.judul inaktif") : lang("app.judul aktif");

                    $this->proyekModel->save(['id' => $db1[0]->id, 'kondisi' => substr($db1[0]->kondisi, 0, 2) . $akhir, 'aktif_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $idunik, "{$db1[0]->kode} ; {$db1[0]->paket} {$onoff}");
                    $this->session->setFlashdata(['pesan' => "{$db1[0]->kode} ; {$db1[0]->paket} {$judul}", 'flash-perus' => $db1[0]->perusahaan_id]);
                }
                $msg = ['redirect' => '/proyek'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function cariProyek()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'proyek' => $this->mainModel->getProyek($this->urls[1], '', $this->request->getVar('perusahaan')),
                'tuser' => $this->user,
            ];
            $msg = ['data' => view('x-main/proyek_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function loadKabupaten()
    {
        if ($this->request->isAJAX()) {
            $skabupaten = $this->request->getvar('kabupaten');
            $kabupaten = $this->mainModel->distItem('m_proyek', 'kabupaten', 'propinsi', $this->request->getvar('propinsi'));
            $isikabupaten = "";
            foreach ($kabupaten as $db) :
                $terpilih = "";
                if ($db->kabupaten == $skabupaten) $terpilih = 'selected';
                $isikabupaten .= "<option value='{$db->kabupaten}'" . $terpilih . ">{$db->kabupaten}</option>";
            endforeach;
            $data = ['kabupaten' => $isikabupaten];
            echo json_encode($data);
        } else {
            exit('out');
        }
    }
}
