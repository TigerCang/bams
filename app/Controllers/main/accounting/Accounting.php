<?php

namespace App\Controllers\main\accounting;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\AccountModel;

class Accounting extends BaseController
{
    protected $accountModel;
    public function __construct()
    {
        $this->accountModel = new AccountModel();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        checkPage('121');
        $data = [
            't_title' => lang('app.coa'),
            't_span' => lang('app.span coa'),
            'link' => '/accounting',
            'selectCategory' => $this->mainModel->distSelect('category account'),
        ];
        $this->render('main/accounting/account_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_account', $this->request->getVar('search'), 'u');
            checkPage('121', $db1, 'y', 'n');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, "{$db1[0]->code} ; {$db1[0]->name}");

            $data = [
                't_modal' => lang('app.coa'),
                'link' => "/accounting",
                'selectCategory' => $this->mainModel->distSelect('category account'),
                'account' => $db1,
                'button' => ['save' => $buttons['save'], 'confirm' => $buttons['confirm'], 'delete' => $buttons['delete'], 'active' => $buttons['active']],
                'btn_active' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.btn active') : lang('app.btn inactive')),
                'active_by' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.inactive by') : lang('app.active by')),
            ];
            $msg = ['data' => view('main/accounting/account_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_account', $this->request->getVar('unique'));
            $cekData = $this->mainModel->cekData('m_account', 'code', $this->request->getVar('accountNumber'), '', '', $this->request->getVar('unique'));
            $ruleCode = ($cekData ? 'required|is_unique[m_account.code]' : 'required');
            $unique = $this->request->getVar('unique');

            if (substr($this->request->getVar('code'), 1) == '00.000') {
                $level = "1";
                $accountParent = '';
            } elseif (substr($this->request->getVar('code'), 2) == '0.000') {
                $level = "2";
                $levelParent = "1";
                $accountParent = substr($this->request->getVar('accountNumber'), 0, 2) . "00.000";
            } elseif (substr($this->request->getVar('code'), 3) == '.000') {
                $level = "3";
                $levelParent = "2";
                $accountParent = substr($this->request->getVar('accountNumber'), 0, 3) . "0.000";
            } else {
                $level = "4";
                $levelParent = "3";
                $accountParent = substr($this->request->getVar('accountNumber'), 0, 4) . ".000";
            }

            if (strlen($this->request->getVar('code')) == "7") {
                if ($level != "1") {
                    $cekParent = $this->mainModel->cekAccount($accountParent, $levelParent);
                    ($cekParent ? $parentID = $cekParent[0]->id : $ruleCode = 'valid_email');
                } else {
                    $parentID = "0";
                }
            }

            $ruleLink = 'permit_empty';
            if ($this->request->getVar('postAction') == 'delete') {
                if ($ruleLink !== 'required') cekLink('group_account', 'parent_id', $db1[0]->id, $ruleLink);
                if ($ruleLink !== 'required') cekLink('m_account', 'parent_id', $db1[0]->id, $ruleLink);
                if ($ruleLink !== 'required') cekLink('m_budget', 'account_id', $db1[0]->id, $ruleLink);
            }

            $validationRules = [
                'askDelete' => ['rules' => $ruleLink, 'errors' => ['required' => lang("app.err delete")]],
                'code' => ['rules' => $ruleCode, 'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unique"), 'valid_email' => lang("app.err invalid")]],
                'description' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'askDelete' => $this->validation->getError('askDelete'),
                        'code' => $this->validation->getError('code'),
                        'description' => $this->validation->getError('description'),
                    ]
                ];
            } else {
                // Save
                if ($this->request->getVar('postAction') == 'save') {
                    $adaptation = (empty($db1) ? '001' : $db1[0]->adaptation[0] . '0' . $db1[0]->adaptation[2]);
                    $title = (empty($db1) ? lang('app.title create') : lang('app.title edit'));
                    if ($unique == '') $unique = create_Unique();

                    $this->accountModel->save([
                        'id' => $db1[0]->id ?? '',
                        'unique' => $unique,
                        'code' => $this->request->getVar('accountNumber'),
                        'name' => $this->request->getVar('description'),
                        'level' => $level,
                        'category' => $this->request->getVar('xCategory'),
                        'parent_id' => $parentID,
                        'position' => ($this->request->getVar('position') == 'on' ? '1' : '0'),
                        'adaptation' => $adaptation,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $unique, "{$this->request->getVar('accountNumber')} ; {$this->request->getVar('description')}");
                    $this->session->setFlashdata(['message' => "{$this->request->getVar('accountNumber')} ; {$this->request->getVar('description')} {$title}", 'flash-category' => $this->request->getVar('xCategory')]);
                }

                // Confirm
                if ($this->request->getVar('postAction') == 'confirm') {
                    $adaptation = '11' . $db1[0]->adaptation[2];
                    $this->accountModel->save(['id' => $db1[0]->id, 'adaptation' => $adaptation, 'confirm_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $unique, "{$db1[0]->code} ; {$db1[0]->name}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name}" . lang("app.title confirm"), 'flash-category' => $db1[0]->category]);
                }

                // Delete
                if ($this->request->getVar('postAction') == 'delete') {
                    $this->accountModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $unique, "{$db1[0]->code} ; {$db1[0]->name}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name}" . lang("app.title delete"), 'flash-category' => $db1[0]->category]);
                }

                // Active
                if ($this->request->getVar('postAction') == 'active') {
                    $result = $db1[0]->adaptation[2] == '1' ? ['0', 'inactive', lang("app.title inactive")] : ['1', 'active', lang("app.title active")];
                    $this->accountModel->save(['id' => $db1[0]->id, 'adaptation' => substr($db1[0]->adaptation, 0, 2) . $result[0], 'active_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $unique, "{$db1[0]->code} ; {$db1[0]->name} {$result[1]}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name} {$result[2]}", 'flash-category' => $db1[0]->category]);
                }
                $msg = ['redirect' => '/accounting'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function searchData()
    {
        if ($this->request->isAJAX()) {
            $data = ['account' => $this->mainModel->getAccount($this->urls[1], $this->request->getVar('category'))];
            $msg = ['data' => view('x-main/account_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
