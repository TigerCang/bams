<?php

namespace App\Controllers\main\accounting;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\GroupAccountModel;

class CashAccount extends BaseController
{
    protected $GroupAccountModel;
    public function __construct()
    {
        $this->groupAccountModel = new GroupAccountModel();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        checkPage('124');
        $data = [
            't_title' => lang('app.cash bank'),
            't_span' => lang('app.span cash bank'),
            'link' => '/cashaccount',
            'kHid' => 'hidden',
            'pHid' => '',
            'nHid' => 'hidden',
            'groupAccount' => $this->mainModel->getGroupAccount($this->urls[1], 'cash'),
        ];
        $this->render('main/accounting/groupaccount_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('group_account', $this->request->getVar('search'), 'u');
            checkPage('124', $db1, 'y', 'n');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, $db1[0]->name);

            $data = [
                't_modal' => lang('app.cash bank'),
                'link' => "/cashaccount",
                'selectGroup' => $this->mainModel->distSelect('cash account', 't'),
                'selectName' => $this->mainModel->distSelect('cash account'),
                'company' => $this->mainModel->getCompany('', 't'),
                'account1' => $this->mainModel->getData('m_account', $db1[0]->account1_id ?? '', '', 'id'),
                'account2' => [],
                'account3' => [],
                'account4' => [],
                'groupAccount' => $db1,
                'button' => ['save' => $buttons['save'], 'confirm' => $buttons['confirm'], 'delete' => $buttons['delete'], 'active' => $buttons['active']],
                'btn_active' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.btn active') : lang('app.btn inactive')),
                'active_by' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.inactive by') : lang('app.active by')),
            ];
            $msg = ['data' => view('main/accounting/groupAccount_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('group_account', $this->request->getVar('unique'));
            $cekData = $this->mainModel->cekData('group_account', 'name', $this->request->getVar('description'), 'sub_param', $this->request->getVar('xSubParam'), $this->request->getVar('unique'));
            $ruleName = ($cekData ? 'required|is_unique[group_account.name]' : 'required');
            $unique = $this->request->getVar('unique');

            $ruleLink = 'permit_empty';
            if ($this->request->getVar('postAction') == 'delete') {
                // if ($ruleLink !== 'required') cekLink('m_user', 'account_id', $db1[0]->id, $ruleLink);
            }

            $validationRules = [
                'askDelete' => ['rules' => $ruleLink, 'errors' => ['required' => lang("app.err delete")]],
                'description' => ['rules' => $ruleName, 'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unique")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'askDelete' => $this->validation->getError('askDelete'),
                        'description' => $this->validation->getError('description'),
                    ]
                ];
            } else {
                // Save
                if ($this->request->getVar('postAction') == 'save') {
                    $adaptation = (empty($db1) ? '001' : $db1[0]->adaptation[0] . '0' . $db1[0]->adaptation[2]);
                    $title = (empty($db1) ? lang('app.title create') : lang('app.title edit'));
                    if ($unique == '') $unique = create_Unique();

                    $this->groupAccountModel->save([
                        'id' => $db1[0]->id ?? '',
                        'unique' => $unique,
                        'source' => 'cash',
                        'param' => $this->request->getVar('xParam'),
                        'sub_param' => $this->request->getVar('xSubParam'),
                        'company_id' => $this->request->getVar('company'),
                        'name' => $this->request->getVar('description'),
                        'account1_id' => $this->request->getVar('account1') ?? 0,
                        'notes' => $this->request->getVar('notes'),
                        'adaptation' => $adaptation,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $unique, $this->request->getVar('description'));
                    $this->session->setFlashdata(['message' => "{$this->request->getVar('description')} {$title}"]);
                }

                // Confirm
                if ($this->request->getVar('postAction') == 'confirm') {
                    $adaptation = '11' . $db1[0]->adaptation[2];
                    $this->groupAccountModel->save(['id' => $db1[0]->id, 'adaptation' => $adaptation, 'confirm_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $unique, $db1[0]->name);
                    $this->session->setFlashdata(['message' => $db1[0]->name . lang("app.title confirm")]);
                }

                // Delete
                if ($this->request->getVar('postAction') == 'delete') {
                    $this->groupAccountModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $unique, $db1[0]->name);
                    $this->session->setFlashdata(['message' => $db1[0]->name . lang("app.title delete")]);
                }

                // Active
                if ($this->request->getVar('postAction') == 'active') {
                    $result = $db1[0]->adaptation[2] == '1' ? ['0', 'inactive', lang("app.title inactive")] : ['1', 'active', lang("app.title active")];
                    $this->groupAccountModel->save(['id' => $db1[0]->id, 'adaptation' => substr($db1[0]->adaptation, 0, 2) . $result[0], 'active_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $unique, "{$db1[0]->name} {$result[1]}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->name} {$result[2]}"]);
                }
                $msg = ['redirect' => '/cashaccount'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
