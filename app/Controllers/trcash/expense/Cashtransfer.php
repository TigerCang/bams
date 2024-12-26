<?php

namespace App\Controllers\trcash\expense;

use Config\App;
use App\Controllers\BaseController;
use App\Models\trcash\CashParentModel;
use App\Models\trcash\CashChild1Model;

class Cashtransfer extends BaseController
{
    protected $CashParentModel;
    protected $CashChild1Model;

    public function __construct()
    {
        $this->cashparentModel = new CashParentModel();
        $this->cashchild1Model = new CashChild1Model();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        // checkPage('102');
        $data = [
            't_title' => lang('app.cash transfer'),
            't_span' => lang('app.span cash transfer'),
            'link' => '/cashtransfer',
            // 'cash' => $this->transModel->getCash($this->urls[1]),
        ];
        $this->render('trcash/expense/request_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        $db1 = $this->mainModel->getData('cash_parent', $this->request->getVar('search'));
        $requester1 = $this->mainModel->loadUser(decrypt(session()->username), '', '1');
        $user1 = $this->mainModel->getData('m_user', $requester1[0]->id ?? '', '', 'id'); // get id cash on group account
        $table = (isset($db1[0]) ? ($db1[0]->object == 'project' ? 'm_project' : ($db1[0]->object == 'equipment tool' ? 'm_tool' : ($db1[0]->object == 'land building' ? 'm_land' : 'm_branch'))) : 'm_branch');
        // checkPage('119', $db1);
        $buttons = transButton($db1, '1', $db1[0]->status ?? '0');
        // if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, "{$db1[0]->title}");

        $data = [
            't_title' => lang('app.cash transfer'),
            't_span' => lang('app.span cash transfer'),
            'link' => "/cashtransfer",
            'company' => $this->mainModel->getCompany('', 't'),
            'region' => $this->mainModel->getFile('', 'region', 't'),
            'division' => $this->mainModel->getFile('', 'division', 't'),
            'selectSource' => $this->mainModel->distSelect('set budget'),
            'selectObject' => $this->mainModel->distSelect('object'),
            'type' => $this->mainModel->distinctCost('indirect cost'),
            'choice' => 'object',
            'object1' => $this->mainModel->getData($table, $db1[0]->object_id ?? '', '', 'id'),
            'requester1' => $requester1,
            'person1' => $this->mainModel->getData('m_person', $requester1[0]->id ?? '', '', 'user_id'),
            'selectAccount' => $this->mainModel->getCashAccount($user1[0]->cash ?? ''),
            'cash' => $db1,
            'button' => ['hidden' => $buttons['hidden'], 'disabled' => $buttons['disabled']],
        ];

        $this->render('trcash/expense/cashTransfer_input', $data);
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
                        'param' => 'kas pindah',
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
                $msg = ['redirect' => '/kaspindah'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
