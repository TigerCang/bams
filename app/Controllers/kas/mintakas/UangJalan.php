<?php

namespace App\Controllers\kas\mintakas;

use Config\App;
use App\Controllers\BaseController;
use App\Models\kas\KasindukModel;
use App\Models\kas\KasanakModel;
use App\Models\kas\KasdetilModel;

class UangJalan extends BaseController
{
    protected $kasindukModel;
    protected $kasanakModel;
    protected $kasdetilModel;

    public function __construct()
    {
        $this->kasindukModel = new KasindukModel();
        $this->kasanakModel = new KasanakModel();
        $this->kasdetilModel = new KasdetilModel();
    }

    public function index()
    {
        checkPage('102');
        $data = [
            't_judul' => lang('app.uang jalan'),
            't_span' => lang('app.span uang jalan'),
            'link' => '/uangjalan',
            'perusahaan' => $this->mainModel->getPerusahaan('', 't'),
            'divisi' => $this->mainModel->getBerkas('', 'divisi', 't'),
            'param' => 'uang jalan',
            'cari1' => '',
            'cari2' => 'hidden',
            'idunik' => buatID(120),
        ];
        $this->iduModel->saveUnik($data['idunik']);
        $this->render('kas/mintakas/mintakas_list', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function inputData()
    {
        $db1 = $this->mainModel->satuID('kas_induk', $this->request->getVar('datakey'));
        if ($db1) {
            checkPage('101', $db1, 'y', 'n');
        } else {
            $dbid = $this->mainModel->satuID('id_unik', $this->request->getVar('datakey'), '', 'idunik', '', 't');
            checkPage('101', $dbid, 'y', 'n');
        }
        // $buttons = setButton($db1);
        // if ($db1) $this->logModel->saveLog('Read', $this->request->getVar('datakey'), "{$db1[0]->kode} ; {$db1[0]->nama}");
        $data = [
            't_judul' => lang('app.uang jalan'),
            't_span' => lang('app.span uang jalan'),
            'link' => '/uangjalan',
            'perusahaan' => $this->mainModel->getPerusahaan('', 't'),
            'wilayah' => $this->mainModel->getBerkas('', 'wilayah', 't'),
            'divisi' => $this->mainModel->getBerkas('', 'divisi', 't'),
            'selbeban' => $this->mainModel->distSelect('beban'),
            'dokumen' => $this->mainModel->cekForm('dokumen', 'uang  jalan', '', 't'),
            'user1' => $this->mainModel->get1User($db1[0]->user_id ?? $this->user['id']),
            'penerima1' => $this->mainModel->satuID('m_penerima', $db1[0]->penerima_id ?? '', '', 'id'),
            'idunik' => $this->request->getVar('datakey'),
            'kas' => $db1,
            'kasanak' => $this->mainModel->satuID('kas_anak', $db1[0]->id ?? '', '', 'kasinduk_id'),
            // 'button' => ['save' => $buttons['bsave'], 'conf' => $buttons['bconf'], 'del' => $buttons['bdel'], 'aktif' => $buttons['baktif']],
        ];
        $this->render('kas/mintakas/uangjalan_input', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {

            // $sama = ($this->request->getVar('iduser') == $this->request->getVar('idpeminta') ? '1' : '0');
            // $rule_akses = ($this->request->getVar('iduser') == '' ? 'valid_email' : 'permit_empty');
            // // $cek = $this->tranModel->cekAnggaraninduk($this->request->getVar('idunik'), $this->request->getVar('xpilih'), $this->request->getVar('xtujuan'), $this->request->getVar('xjenis'), $this->request->getVar('idbeban'), '', $this->request->getVar('noadd'), $this->request->getVar('norev'));
            // // $rule_akses = ($cek) ? ($cek[0]->idunik == $this->request->getVar('idunik') ? 'permit_empty' : 'required') : 'permit_empty';
            // $tujuan = ($this->request->getVar('xtujuan') == '' ? 'proyek' : $this->request->getVar('xtujuan'));
            // if ($tujuan == 'tool') $cekbeban = $this->deklarModel->satuID('m_alat', $this->request->getVar('idbeban'), '', 'id', 't');
            // if ($tujuan != 'tool') if (in_array($tujuan, ['proyek', 'camp', 'alat', 'tanah'])) $cekbeban = $this->deklarModel->satuID("m_$tujuan", $this->request->getVar('idbeban'), '', 'id', 't');
            // $rule_perusahaan = (($cekbeban && $this->request->getVar('idperusahaan') == $cekbeban[0]->perusahaan_id) ? 'permit_empty' : 'valid_email');
            // $rule_wilayah = (($cekbeban && $this->request->getVar('idwilayah') == $cekbeban[0]->wilayah_id) ? 'permit_empty' : 'valid_email');
            // $rule_divisi = (($cekbeban && $this->request->getVar('iddivisi') == $cekbeban[0]->divisi_id) ? 'permit_empty' : 'valid_email');
            // $rule_biaya = ($tujuan == 'proyek' ? 'required' : 'permit_empty');
            // $rule_akun = ($tujuan == 'proyek' ? 'permit_empty' : 'required');
            // $rule_sd = (($tujuan == 'proyek' && $this->request->getVar('ruas') != '') ? 'required' : 'permit_empty');
            var_dump($this->request->getVar('idunik'));
            die;
            // $rule_lampiran = ($this->request->getFile('lampiran')) ? 'uploaded[lampiran]|max_size[lampiran,2048]|ext_in[lampiran,pdf]' : 'permit_empty';
            $rule_lampiran = $this->request->getFile('lampiran')->isValid() ? 'uploaded[lampiran]|max_size[lampiran,2048]|ext_in[lampiran,pdf]' : 'permit_empty';
            $validationRules = [
                'peminta' => ['rules' => 'required', 'errors' => ['required' => lang("app.err pilih")]],
                // 'kodebeban' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'penerima' => ['rules' => 'required', 'errors' => ['required' => lang("app.err pilih")]],
                'akun' => ['rules' => 'required', 'errors' => ['required' => lang("app.err pilih")]],
                'lampiran' => [
                    'rules' => $rule_lampiran,
                    'errors' => ['uploaded' => lang("app.err blank"), 'max_size' => lang("app.err file20"), 'ext_in' => lang("app.err fileext")]
                ],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'peminta' => $this->validation->getError('peminta'),
                        // 'kodebeban' => $this->validation->getError('kodebeban'),
                        'penerima' => $this->validation->getError('penerima'),
                        'akun' => $this->validation->getError('akun'),
                        'lampiran' => $this->validation->getError('lampiran'),
                    ]
                ];
            } else {
                $induk1 = $this->mainModel->satuID('kas_induk', $this->request->getVar('idunik'));
                $nomordokumen = $this->request->getVar('dokumen');
                if ($this->request->getVar('dokumen') == "") {
                    $db = $this->transaksiModel->getnoDokumen('kas_induk', $this->request->getVar('xkui'), "-" . substr($this->request->getVar('tglminta'), 2, 2));
                    $nomor = (empty($db['0']->nodokumen) ? "1" : substr($db['0']->nodokumen, -4) + 1);
                    $nomordokumen = nomorDokumen($this->request->getVar('xkui'), $this->request->getVar('tglminta'), $nomor);
                }

                $sama = (session()->username != $this->request->getVar('peminta') ? '0' : '1');
                $peminta = $this->mainModel->satuID('m_user', $this->request->getVar('peminta'), '', 'kode');
                list($slLevel, $slStatus) = statLev($sama, $peminta[0]->act_setuju, $this->level[0]['nilai']);
                if (empty($induk1)) {
                    $this->kasindukModel->save([
                        'idunik' =>  $this->request->getVar('idunik'),
                        'param' => 'uang jalan',
                        'beban' => $this->request->getVar('beban'),
                        'nodokumen' => $nomordokumen,
                        'tgl_minta' => $this->request->getVar('tglminta'),
                        'beban_id' => $this->request->getVar('xbeban'),
                        'penerima_id' => $this->request->getVar('penerima'),
                        'revisi' => '0',
                        'level' => $slLevel,
                        'is_masuk' => 0,
                        'status' => $slStatus,
                        'perusahaan_id' => $this->request->getVar('perusahaan'),
                        'wilayah_id' => $this->request->getVar('wilayah'),
                        'divisi_id' => $this->request->getVar('divisi'),
                        'usernama' => session()->usernama,
                        'peminta' => $this->request->getVar('peminta'),
                    ]);
                    $induk1 = $this->mainModel->satuID('kas_induk', $this->request->getVar('idunik'));
                    $this->kasanakModel->save([
                        'kasinduk_id' => $induk1['0']->id,
                        'akun_id' => $this->request->getVar('akun'),
                        'jumlah' => ubahSeparator($this->request->getVar('jumlah')),
                        'harga' => ubahSeparator($this->request->getVar('harga')),
                        'debit' => ubahSeparator($this->request->getVar('total')),
                        'catatan' => $this->request->getVar('catatan'),
                    ]);
                    $this->logModel->saveLog('Save', $this->request->getVar('idunik'), $nomordokumen);
                    $this->session->setFlashdata(['pesan' => $nomordokumen . lang('app.judul simpan'), 'flash-perus' => 'as']);
                } else {
                    // $this->kasindukModel->save([
                    //     'id' => $kasinduk1['0']->id,
                    //     'cabang_id' => $this->request->getVar('idbeban'),
                    //     'level_pos' => $this->request->getVar('level'),
                    //     'penerima_id' => $this->request->getVar('penerima'),
                    // ]);
                    // $kasan1 = $this->tranModel->getKasanak($kasinduk1['0']->id);
                    // $this->kasanakModel->save([
                    //     'id' =>  $kasan1['0']->id,
                    //     'akun_id' => $this->request->getVar('noakun'),
                    //     'jumlah' => ubahkoma($this->request->getVar('jumlah')),
                    //     'harga' => ubahkoma($this->request->getVar('harga')),
                    //     'debit' => ubahkoma($this->request->getVar('total')),
                    //     'catatan' => $this->request->getVar('catatan'),
                    //     'status' => '1',
                    // ]);
                }
                $msg = ['redirect' => '/uangjalan'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function outfocusPenerima()
    {
        if ($this->request->isAJAX()) {
            $penerima = $this->mainModel->satuID('m_penerima', $this->request->getvar('penerima'), '', 'id');
            $kelakun1 = $this->mainModel->satuID('m_kelakun', $penerima[0]->kakun_pegawai ?? '', '', 'id');
            $kelakun2 = $this->mainModel->satuID('m_kelakun', $penerima[0]->kakun_lain ?? '', '', 'id');
            $akun1 = $this->mainModel->satuID('m_akun', $kelakun1[0]->akun3_id ?? '', '', 'id');
            $akun2 = $this->mainModel->satuID('m_akun', $kelakun2[0]->akun3_id ?? '', '', 'id');
            $isiakun = "";
            if ($akun1) $isiakun .= "<option value='{$akun1[0]->id}' data-subtext='{$akun1[0]->nama}'>{$akun1[0]->kode}</option>";
            if ($akun2) $isiakun .= "<option value='{$akun2[0]->id}' data-subtext='{$akun2[0]->nama}'>{$akun2[0]->kode}</option>";

            $data = ['akun' => $isiakun, 'penerima' => $penerima];
            echo json_encode($data);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function outfocusSupir()
    {
        if ($this->request->isAJAX()) {
            $supir = $this->mainModel->satuID('m_penerima', $this->request->getvar('supir'), '', 'id');
            $perusahaan = $this->mainModel->satuID('m_perusahaan', $supir[0]->perusahaan_id ?? '', '', 'id');
            $penerima1 = $this->mainModel->satuID('m_penerima', $perusahaan[0]->penerima_id ?? '', '', 'id');
            $isipenerima = "";
            $isipenerima .= "<option value='{$penerima1[0]->id}' selected data-subtext='{$penerima1[0]->nama}'>{$penerima1[0]->kode}</option>";

            $data = ['penerima' => $isipenerima];
            echo json_encode($data);
        } else {
            exit('out');
        }
    }
}