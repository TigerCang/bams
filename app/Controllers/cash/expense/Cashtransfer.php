<?php

namespace App\Controllers\cash\expense;

use Config\App;
use App\Controllers\BaseController;
use App\Models\cash\CashParentModel;
use App\Models\cash\CashChild1Model;

class Cashtransfer extends BaseController
{
    protected $CashParentModel;
    protected $CashChild1Model;

    public function __construct()
    {
        $this->cashParentModel = new CashParentModel();
        $this->cashChild1Model = new CashChild1Model();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        // checkPage('102');
        $data = [
            't_title' => lang('app.cash transfer'),
            't_span' => lang('app.span cash transfer'),
            'link' => base_url('cashtransfer'),
            'selectObject' => $this->mainModel->distSelect('object'),
            // 'cash' => $this->transModel->getCash($this->urls[1]),
        ];
        $this->render('cash/expense/request_list', $data);
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
            'link' => base_url('cashtransfer'),

            'company' => $this->mainModel->getCompany('', 't'),
            'region' => $this->mainModel->getFile('', 'region', 't'),
            'division' => $this->mainModel->getFile('', 'division', 't'),
            'selectObject' => $this->mainModel->distSelect('object'),
            'selectAction' => $this->mainModel->distSelect('action'),
            'object1' => $this->mainModel->getData($table, $db1[0]->object_id ?? '', '', 'id'),
            'requester1' => $requester1,
            'person1' => $this->mainModel->getData('m_person', $requester1[0]->id ?? '', '', 'user_id'),
            'selectAccount' => $this->mainModel->getCashAccount($user1[0]->cash ?? ''),
            'cash' => $db1,
            'button' => ['on' => $buttons['on'], 'off' => $buttons['off']],
            'card' => ['input' => '', 'acc' => 'hidden'],
        ];
        $this->render('cash/expense/cashTransfer_input', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('cash_parent', $this->request->getVar('unique'));
            $company = (isset($db1[0]->status) && $db1[0]->status != '0' ? $db1[0]->company_id : $this->request->getVar('company'));
            $region = (isset($db1[0]->status) && $db1[0]->status != '0' ? $db1[0]->region_id : $this->request->getVar('region'));
            $division = (isset($db1[0]->status) && $db1[0]->status != '0' ? $db1[0]->division_id : $this->request->getVar('division'));
            $branch = (isset($db1[0]->status) && $db1[0]->status != '0' ? $db1[0]->object_id : $this->request->getVar('branch'));
            $ruleAccess = checkAccess($company, $region, $division, 'save');
            $ruleBranch = ($branch ? 'permit_empty' : 'required');
            if ($ruleBranch == 'permit_empty') $ruleBranch = checkObject($this->request->getVar('xObject'), $branch);
            $unique = $this->request->getVar('unique');
            $ruleBudget = checkBudget($this->request->getVar('xSource'), $this->request->getVar('xObject'), $branch, '', $this->request->getVar('revisionNumber'), $unique);
            $ruleAttachment = $this->request->getFile('attachment')->isValid() ? 'max_size[attachment,1024]|ext_in[attachment,pdf]' : 'permit_empty';
            if ($this->request->getVar('xObject') != 'project') $ruleAccess[1] = $ruleAccess[2] = $ruleBranch  = 'permit_empty';

            $validationRules = [
                // 'askAccess' => ['rules' => $ruleBudget, 'errors' => ['required' => lang("app.err delete")]],
                'company' => ['rules' => $ruleAccess[0], 'errors' => ['valid_email' => lang("app.err access")]],
                'region' => ['rules' => $ruleAccess[1], 'errors' => ['valid_email' => lang("app.err access")]],
                'division' => ['rules' => $ruleAccess[2], 'errors' => ['valid_email' => lang("app.err access")]],
                'branch' => ['rules' => $ruleBranch, 'errors' => ['required' => lang("app.err select"), 'valid_email' => lang("app.err access")]],
                'requester' => ['rules' => 'required', 'errors' => ['required' => lang("app.err select")]],
                'person' => ['rules' => 'required', 'errors' => ['required' => lang("app.err select")]],
                'account' => ['rules' => 'required', 'errors' => ['required' => lang("app.err select")]],
                'total' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'attachment' => [
                    'rules' => $ruleAttachment,
                    'errors' => ['max_size' => lang("app.err file1"), 'ext_in' => lang("app.err fileext")]
                ],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'askAccess' => $this->validation->getError('askAccess'),
                        'company' => $this->validation->getError('company'),
                        'region' => $this->validation->getError('region'),
                        'division' => $this->validation->getError('division'),
                        'branch' => $this->validation->getError('branch'),
                        'requester' => $this->validation->getError('requester'),
                        'person' => $this->validation->getError('person'),
                        'account' => $this->validation->getError('account'),
                        'total' => $this->validation->getError('total'),
                        'attachment' => $this->validation->getError('attachment'),
                    ]
                ];
            } else {
                die;
                // Save
                if ($this->request->getVar('postAction') == 'save') {
                    $docNumber = $this->request->getVar('documentNumber');
                    if ($docNumber == '') {
                        $initial = initialCode('account budget', $company, $region, $division);
                        $db = $this->transModel->getDocumentNumber('budget_parent', $initial ?? '', "-" . substr($this->request->getVar('startDate'), 2, 2));
                        $number = ($db ? substr($db[0]->document_number, -4) + 1 : '1');
                        $docNumber = createDocumentNumber($initial, $this->request->getVar('startDate'), $number);
                    };
                }

                if ($unique == '') $unique = create_Unique('120');
                if (empty($db1)) {
                    $this->budgetParentModel->save([
                        'unique' =>  $unique,
                        'source' => 'cash transfer',
                        'object' =>  $this->request->getVar('xObject'),
                        'company_id' => $company,
                        'region_id' => $region,
                        'division_id' => $division,
                        'object_id' => $branch,
                        'document_number' => $docNumber,
                        'person_id' => $docNumber,
                        'date_request' => $this->request->getVar('startDate'),
                        'revision' => '1',
                        'level' => '',
                        'status' => '',
                        'attachment' => '',
                        'request_by' => $docNumber,
                        'save_by' => $this->request->getVar('endDate'),
                    ]);
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
