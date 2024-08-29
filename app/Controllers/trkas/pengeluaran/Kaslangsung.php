<?php

namespace App\Controllers\trkas\pengeluaran;

use Config\App;
use App\Controllers\BaseController;
use App\Models\trkas\KasindukModel;
use App\Models\trkas\KasanakModel;

class Kaslangsung extends BaseController
{
    protected $kasindukModel;
    protected $kasanakModel;
    public function __construct()
    {
        $this->kasindukModel = new KasindukModel();
        $this->kasanakModel = new KasanakModel();
    }

    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        // (!preg_match("/118/i", $this->session->menu->menu_1)) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();      
        $data = [
            't_menu' => strtoupper(lang("app.kaslangsung")), 't_submenu' => '',
            't_icon' => '<i class="fa fa-money ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-money"></i>', 't_dir1' => lang("app.mintakas"), 't_dirac' => lang("app.kaslangsung"), 't_link' => '/mintakas',
            'menu' => 'kaslangsung', 'baru' => '', 'filstat' => '', 'filcek' => 'hidden',
            'perusahaan' => $this->deklarModel->getPerusahaan('', 't'),
            'divisi' => $this->deklarModel->getDivisi('', 'divisi', 't'),
            'selbeban' => $this->deklarModel->distSelect('beban'),
            'btnclascr' => lang('app.btncCreate'), 'btntextcr' => lang('app.btnCreate'),
            'actcreate' => ($this->user['act_create'] == '0' ? 'hidden' : ''),
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        return view('trkas/pengeluaran/mintakas_view', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function crany()
    {
        do {
            $idu = buatid('60');
            $db = $this->deklarModel->satuID('kas_induk', $idu);
        } while ($db);
        $this->iduModel->saveID($idu);
        return redirect()->to('/kaslangsung/input/' . $idu);
    }

    // ____________________________________________________________________________________________________________________________
    public function showdata($idunik)
    {
        // (!preg_match("/118/i", $this->session->menu->menu_1)) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();      
        $db1 = $this->deklarModel->satuID('kas_induk', $idunik);
        $beban = ($db1 ? 'm_' . $db1[0]->tujuan : 'm_proyek');
        $data = [
            't_menu' => strtoupper(lang("app.kaslangsung")), 't_submenu' => '',
            't_icon' => '<i class="fa fa-money ' . lang("app.xinput") . '"></i>',
            't_diricon' => '<i class="fa fa-money"></i>', 't_dir1' => lang("app.mintakas"), 't_dirac' => lang("app.kaslangsung"), 't_link' => '/kaslangsung',
            'idu' => $this->iduModel->cekID($idunik), 'idunik' => $idunik,
            'menu' => 'kaslangsung',
            'perusahaan' => $this->deklarModel->getPerusahaan('', 't'),
            'wilayah' => $this->deklarModel->getDivisi('', 'wilayah', 't'),
            'divisi' => $this->deklarModel->getDivisi('', 'divisi', 't'),
            'nodoc' => $this->deklarModel->cekForm('dokumen', 'kaslangsung', 't', '', '', ''),
            'user1' => $this->deklarModel->get1User($db1[0]->peminta_id ?? $this->user['id']),
            'selbeban' => $this->deklarModel->distSelect('beban'),
            'beban1' => $this->deklarModel->satuID($beban, $db1[0]->beban_id ?? '', '', 'id', 't'),
            'penerima1' => $this->deklarModel->satuID('m_penerima', $db1[0]->penerima_id ?? '', '', 'id', 't'),
            'kas' => $db1,
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        (empty($data['kas']) && empty($data['idu'])) && throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($data['kas']) {
            if ($this->user['act_perusahaan'] == "0" && !preg_match("/," . $data['kas'][0]->perusahaan_id . ",/i", $this->user['perusahaan'])) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
            if ($this->user['act_wilayah'] == "0" && !preg_match("/," . $data['kas'][0]->wilayah_id . ",/i", $this->user['wilayah'])) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
            if ($this->user['act_divisi'] == "0" && !preg_match("/," . $data['kas'][0]->divisi_id . ",/i", $this->user['divisi'])) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
            if ($data['kas'][0]->user_id != $this->user['id'] && $data['kas'][0]->peminta_id != $this->user['id']) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        }
        if ($db1) $this->logModel->saveLog('Read', $idunik, $db1[0]->nodoc, '-');
        return view('trkas/pengeluaran/kaslangsung_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function tambahdata()
    {
        if ($this->request->isAJAX()) {
            $sama = ($this->request->getVar('iduser') == $this->request->getVar('idpeminta') ? '1' : '0');
            $rule_akses = ($this->request->getVar('iduser') == '' ? 'valid_email' : 'permit_empty');
            // $cek = $this->tranModel->cekAnggaraninduk($this->request->getVar('idunik'), $this->request->getVar('xpilih'), $this->request->getVar('xtujuan'), $this->request->getVar('xjenis'), $this->request->getVar('idbeban'), '', $this->request->getVar('noadd'), $this->request->getVar('norev'));
            // $rule_akses = ($cek) ? ($cek[0]->idunik == $this->request->getVar('idunik') ? 'permit_empty' : 'required') : 'permit_empty';
            $tujuan = ($this->request->getVar('xtujuan') == '' ? 'proyek' : $this->request->getVar('xtujuan'));
            if ($tujuan == 'tool') $cekbeban = $this->deklarModel->satuID('m_alat', $this->request->getVar('idbeban'), '', 'id', 't');
            if ($tujuan != 'tool') if (in_array($tujuan, ['proyek', 'camp', 'alat', 'tanah'])) $cekbeban = $this->deklarModel->satuID("m_$tujuan", $this->request->getVar('idbeban'), '', 'id', 't');
            $rule_perusahaan = (($cekbeban && $this->request->getVar('idperusahaan') == $cekbeban[0]->perusahaan_id) ? 'permit_empty' : 'valid_email');
            $rule_wilayah = (($cekbeban && $this->request->getVar('idwilayah') == $cekbeban[0]->wilayah_id) ? 'permit_empty' : 'valid_email');
            $rule_divisi = (($cekbeban && $this->request->getVar('iddivisi') == $cekbeban[0]->divisi_id) ? 'permit_empty' : 'valid_email');
            $rule_biaya = ($tujuan == 'proyek' ? 'required' : 'permit_empty');
            $rule_akun = ($tujuan == 'proyek' ? 'permit_empty' : 'required');
            $rule_sd = (($tujuan == 'proyek' && $this->request->getVar('ruas') != '') ? 'required' : 'permit_empty');

            $validationRules = [
                'akses' => [
                    'rules' => $rule_akses,
                    'errors' => ['valid_email' => lang("app.errunik2")]
                ],
                'idperusahaan' => [
                    'rules' => $rule_perusahaan,
                    'errors' => ['valid_email' => lang("app.errunik")]
                ],
                'idwilayah' => [
                    'rules' => $rule_wilayah,
                    'errors' => ['valid_email' => lang("app.errunik")]
                ],
                'iddivisi' => [
                    'rules' => $rule_divisi,
                    'errors' => ['valid_email' => lang("app.errunik")]
                ],
                'idpeminta' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
                'kodebeban' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
                'idpenerima' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
                'biaya' => [
                    'rules' => $rule_biaya,
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'sumberdaya' => [
                    'rules' => $rule_sd,
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'akun' => [
                    'rules' => $rule_akun,
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'total' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
                'catatan' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'akses' => $this->validation->getError('akses'),
                        'perusahaan' => $this->validation->getError('idperusahaan'),
                        'wilayah' => $this->validation->getError('idwilayah'),
                        'divisi' => $this->validation->getError('iddivisi'),
                        'peminta' => $this->validation->getError('idpeminta'),
                        'kodebeban' => $this->validation->getError('kodebeban'),
                        'penerima' => $this->validation->getError('idpenerima'),
                        'biaya' => $this->validation->getError('biaya'),
                        'sumberdaya' => $this->validation->getError('sumberdaya'),
                        'akun' => $this->validation->getError('akun'),
                        'total' => $this->validation->getError('total'),
                        'catatan' => $this->validation->getError('catatan'),
                    ]
                ];
            } else {
                $nodokumen = $this->request->getVar('nodoc');
                if ($nodokumen == "") {
                    $db = $this->tranModel->getNomordoc('kas_induk', $this->request->getVar('kui'), "-" . substr($this->request->getVar('tanggal'), 2, 2));
                    $nomor = ($db ? substr($db[0]->nodoc, -4) + 1 : '1');
                    $nodokumen = nodokumen($this->request->getVar('kui'), $this->request->getVar('tanggal'), $nomor);
                }
                $kasinduk1 = $this->deklarModel->satuID('kas_induk', $this->request->getVar('idunik'));
                if ($kasinduk1) {
                    $this->kasindukModel->save(['id' =>  $kasinduk1[0]->id, 'status' => '0', 'is_sama' => $sama]);
                } else {
                    $this->kasindukModel->save([
                        'idunik' =>  $this->request->getVar('idunik'),
                        'user_id' => $this->request->getVar('iduser'),
                        'peminta_id' => $this->request->getVar('idpeminta'),
                        'pilihan' => 'pengeluaran',
                        'tujuan' => $this->request->getVar('xtujuan'),
                        'perusahaan_id' => $this->request->getVar('idperusahaan'),
                        'wilayah_id' => $this->request->getVar('idwilayah'),
                        'divisi_id' => $this->request->getVar('iddivisi'),
                        'nodoc' => $nodokumen,
                        'tgl_minta' => $this->request->getVar('tanggal'),
                        'revisi' => $this->request->getVar('revisi'),
                        'beban_id' => $this->request->getVar('idbeban'),
                        'penerima_id' => $this->request->getVar('idpenerima'),
                        'asal' => 'kaslangsung',
                        'jenis' => 'ju',
                        'is_sama' => $sama,
                        'status' => '0',
                    ]);
                }
                $idinduk = $this->deklarModel->satuID('kas_induk', $this->request->getVar('idunik'));
                $total = ubahSeparator($this->request->getVar('total'));
                $debit = $total > 0 ? $total : 0;
                $kredit = $total > 0 ? 0 : -1 * $total;
                $this->kasanakModel->save([
                    'kasinduk_id' => $idinduk['0']->id,
                    'ruas_id' => $this->request->getVar('ruas'),
                    'anggaran_id' => $this->request->getVar('ruas'),
                    'biaya_id' => $this->request->getVar('iditem'),
                    'akun_id' => $this->request->getVar('idakun'),
                    'sumberdaya_id' => $this->request->getVar('sumberdaya'),
                    'jumlah' => ubahSeparator($this->request->getVar('jumlah')),
                    'harga' => ubahSeparator($this->request->getVar('harga')),
                    'debit' => $debit,
                    'kredit' => $kredit,
                    'catatan' => $this->request->getVar('catatan'),
                    'mode' => 'a',
                    'asal' => 'biaya',
                ]);
                $tabel = ($tujuan == 'proyek' ? 'm_biaya' : 'm_akun');
                $item = ($tujuan == 'proyek' ? $this->request->getVar('iditem') : $this->request->getVar('idakun'));
                $db2 = $this->deklarModel->satuID($tabel, $item, '', 'id');
                $msg = ['sukses' => "{$nodokumen} => {$db2[0]->nama}" . lang('app.judultambah'), 'nodoc' => $nodokumen, 'stat' => lang('app.baru')];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function modaldata()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getvar('id');
            $db = $this->deklarModel->satuID('kas_anak', $id, '', 't');
            $data = [
                'po' => $this->deklarModel->satuID('po_anak', $id, 't', 't'),
                'akun1' => $this->deklarModel->satuID('m_akun', $db['0']->barang_id, 't', 't'),
                'barang1' => $this->deklarModel->satuID('m_barang', $db['0']->barang_id, 't', 't'),
            ];
            $msg = ['data' => view('x-modal/koreksi_mintakas', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function savedokumen()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();

            $rule_akses = 'permit_empty';
            $status = '2';

            if ($this->session->username != $this->request->getVar('user')) {
                $peminta = $this->deklarModel->getUser($this->request->getVar('user'));
                $cab = $this->request->getVar('cabang');
                $status = '1';
                $error = "0";

                switch ($this->request->getVar('pilihan')) {
                    case 'proyek':
                        if (($peminta['0']->akses_proyek == "0") && (!preg_match("/,$cab,/i", $peminta['0']->proyek))) $error = "1";
                        break;
                    case 'camp':
                        if (($peminta['0']->akses_camp == "0") && (!preg_match("/,$cab,/i", $peminta['0']->camp))) $error = "1";
                        break;
                    case 'alat':
                        if (($peminta['0']->akses_alat == "0") && (!preg_match("/,$cab,/i", $peminta['0']->alat))) $error = "1";
                        break;
                    case 'tanah':
                        if (($peminta['0']->akses_aset == "0") && (!preg_match("/,$cab,/i", $peminta['0']->aset))) $error = "1";
                        break;
                }
                err1:
                if ($error == "1") $rule_akses = 'required';
            }

            $rule_lampiran = ($this->request->getFile('lampiran')) ? 'uploaded[lampiran]|max_size[lampiran,2048]|ext_in[lampiran,pdf]' : 'permit_empty';
            if (!$this->validate([
                'akses' => [
                    'rules' => $rule_akses,
                    'errors' => [
                        'required' => lang("app.errnoakses"),
                    ]
                ],
                'cabang' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang("app.errblank"),
                    ]
                ],
                'penerima' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang("app.errblank"),
                    ]
                ],
                'dokumen' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang("app.errblank"),
                    ]
                ],
                'lampiran' => [
                    'rules' => $rule_lampiran,
                    'errors' => [
                        'uploaded' => lang("app.errblank"),
                        'max_size' => lang("app.errfilebesar2"),
                        'ext_in' => lang("app.errextin"),
                    ],
                ],
            ])) {
                $msg = [
                    'error' => [
                        'akses' => $validation->getError('akses'),
                        'beban' => $validation->getError('cabang'),
                        'penerima' => $validation->getError('penerima'),
                        'dokumen' => $validation->getError('dokumen'),
                        'lampiran' => $validation->getError('lampiran'),
                    ]
                ];
            } else {
                $param = $this->deklarModel->satuID('m_konfigurasi', '4', 't', 't');
                $berkaslampiran = $this->request->getFile('lampiran');
                $nama_berkas = ($this->request->getFile('lampiran')) ? $berkaslampiran->getName() : '';
                if ($this->request->getFile('lampiran')) $berkaslampiran->move('assets/lampiran-kas/' . $param['0']->nilai . '/' . $this->request->getVar('lampiran'));
                $db1 = $this->deklarModel->satuID('kas_induk', $this->request->getVar('idunik'));

                if (empty(!$db1)) {
                    $this->kasindukModel->save([
                        'id' => $db1['0']->id,
                        'cabang_id' => $this->request->getVar('cabang'),
                        'level_pos' => $this->request->getVar('level'),
                        'penerima_id' => $this->request->getVar('penerima'),
                        'alias' => $this->request->getVar('alias'),
                        'lampiran' => $nama_berkas,
                        'status' => $status,
                    ]);
                }
                $this->logModel->saveLog('/kaslangsung', $db1['0']->id, 'Save', $db1['0']->nodoc);
                $msg = ['sukses' => $db1['0']->nodoc . ' ' . lang("app.judulsimpan"), 'perus' => $db1['0']->perusahaan_id, 'div' => $db1['0']->divisi_id];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
    public function canceldokumen($idunik)
    {
        $db = $this->tranModel->getKasinduk($idunik);
        if (empty(!$db)) {
            $this->kasindukModel->save([
                'id' => $db['0']->id,
                'status' => '5',
            ]);

            $this->logModel->saveLog('/kaSslangsung', $db['0']->id, 'Cancel', $db['0']->nodoc);
            $this->session->setflashdata(['judul' => $db['0']->nodoc . ' ' . lang("app.judulbatal"), 'perus' => $db['0']->perusahaan_id, 'div' => $db['0']->divisi_id]);
        }
        return redirect()->to('/kaslangsung');
    }

    // ____________________________________________________________________________________________________________________________
    public function deletedata()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();

            $id = $this->request->getVar('id');
            $this->kasanakModel->delete($id);
            $msg = ['sukses' => $this->request->getVar('akun') . ' ' . lang("app.judulhapus")];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
