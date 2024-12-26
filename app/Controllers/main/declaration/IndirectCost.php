<?php

namespace App\Controllers\main\declaration;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\CostModel;

class IndirectCost extends BaseController
{
    protected $costModel;
    public function __construct()
    {
        $this->costModel = new CostModel();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        checkPage('114');
        $data = [
            't_title' => lang('app.indirect cost'),
            't_span' => lang('app.span indirect cost'),
            'link' => '/indirectcost',
            'param' => 'indirect cost',
            'category' => $this->mainModel->distinctCost('indirect cost'),
        ];
        $this->render('main/declaration/cost_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_cost', $this->request->getVar('search'), 'u');
            checkPage('114', $db1, 'y', 'n');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, "{$db1[0]->code} ; {$db1[0]->name}");

            $data = [
                't_modal' => lang('app.indirect cost'),
                'link' => "/indirectcost",
                'mpHid' => 'hidden',
                'kHid' => 'hidden',
                'jlHid' => 'hidden',
                'aHid' => '',
                'unit' => $this->mainModel->getFile('', 'unit', 't'),
                'account1' => $this->mainModel->getData('m_account', $db1[0]->account_id ?? '', '', 'id'),
                'category' => [],
                'cost' => $db1,
                'button' => ['save' => $buttons['save'], 'confirm' => $buttons['confirm'], 'delete' => $buttons['delete'], 'active' => $buttons['active']],
                'btn_active' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.btn active') : lang('app.btn inactive')),
                'active_by' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.inactive by') : lang('app.active by')),
            ];
            $msg = ['data' => view('main/declaration/cost_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_cost', $this->request->getVar('unique'));
            $cekData = $this->mainModel->cekData('m_cost', 'code', $this->request->getVar('code'), '', '', $this->request->getVar('unique'));
            $ruleCode = ($cekData ? 'required|is_unique[m_cost.code]' : 'required|min_length[8]');
            $code = $this->request->getVar('code');
            $unique = $this->request->getVar('unique');
            $ruleLink = 'permit_empty';

            if (substr($code, 2) == '000000') {
                $level = "1";
            } elseif (substr($code, 4) == '0000') {
                $level = "2";
                $parentLevel = "1";
                $parentCost = substr($code, 0, 2) . "000000";
            } elseif (substr($code, 6) == '00') {
                $level = "3";
                $parentLevel = "2";
                $parentCost = substr($code, 0, 4) . "0000";
            } else {
                $level = "4";
                $parentLevel = "3";
                $parentCost = substr($code, 0, 6) . "00";
            }
            $ruleLevel4 = (isset($db1[0]) && $db1[0]->adaptation[0] == '1' ? 'permit_empty' : ($level == "4" ? 'required' : 'permit_empty'));
            $unit = ($level == "4" ? $this->request->getVar('unit') : '');
            $account = ($level == "4" ? (isset($db1[0]) && $db1[0]->adaptation[0] == '1' ? $db1[0]->account_id : $this->request->getVar('account')) : '');
            $parentID = "0";
            if (strlen($code) == "8" && $level != "1") {
                $cekParent = $this->mainModel->cekParentCost('indirect cost', strtoupper($parentCost), $parentLevel, '');
                ($cekParent ? $parentID = $cekParent[0]->id : $ruleCode = 'valid_email');
            }

            $ruleLink = 'permit_empty';
            if ($this->request->getVar('postAction') == 'delete') {
                if ($ruleLink !== 'required') cekLink('m_budget', 'cost_id', $db1[0]->id, $ruleLink);
                if ($ruleLink !== 'required') cekLink('m_cost', 'parent_id', $db1[0]->id, $ruleLink);
            }

            $validationRules = [
                'code' => [
                    'rules' => $ruleCode,
                    'errors' => ['required' => lang("app.err blank"), 'min_length' => lang("app.err length", [8]), 'is_unique' => lang("app.err unique"), 'valid_email' => lang("app.err invalid")]
                ],
                'askDelete' => ['rules' => $ruleLink, 'errors' => ['required' => lang("app.err delete")]],
                'description' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'unit' => ['rules' => $ruleLevel4, 'errors' => ['required' => lang("app.err select")]],
                'account' => ['rules' => $ruleLevel4, 'errors' => ['required' => lang("app.err select")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'askDelete' => $this->validation->getError('askDelete'),
                        'code' => $this->validation->getError('code'),
                        'description' => $this->validation->getError('description'),
                        'unit' => $this->validation->getError('unit'),
                        'account' => $this->validation->getError('account'),
                    ]
                ];
            } else {
                // Save
                if ($this->request->getVar('postAction') == 'save') {
                    $adaptation = (empty($db1) ? '001' : $db1[0]->adaptation[0] . '0' . $db1[0]->adaptation[2]);
                    $title = (empty($db1) ? lang('app.title create') : lang('app.title edit'));
                    if ($unique == '') $unique = create_Unique();

                    $this->costModel->save([
                        'id' => $db1[0]->id ?? '',
                        'unique' => $unique,
                        'param' => 'indirect cost',
                        'parent_id' => $parentID,
                        'code' => strtoupper($this->request->getVar('code')),
                        'name' => $this->request->getVar('description'),
                        'unit' => $unit,
                        'level' => $level,
                        'account_id' => $account,
                        'adaptation' => $adaptation,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $unique, strtoupper($this->request->getVar('code')) . ' ; ' . $this->request->getVar('description'));
                    $this->session->setFlashdata(['message' => strtoupper($this->request->getVar('code')) . ' ; ' . $this->request->getVar('description') . $title, 'flash-category' => substr(strtoupper($this->request->getVar('code')), 0, 2)]);
                }

                // Confirm
                if ($this->request->getVar('postAction') == 'confirm') {
                    $adaptation = '11' . $db1[0]->adaptation[2];
                    $this->costModel->save(['id' => $db1[0]->id, 'adaptation' => $adaptation, 'confirm_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $unique, "{$db1[0]->code} ; {$db1[0]->name}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name}" . lang("app.title confirm"), 'flash-category' => substr($db1[0]->code, 0, 2)]);
                }

                // Delete
                if ($this->request->getVar('postAction') == 'delete') {
                    $this->costModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $unique, "{$db1[0]->code} ; {$db1[0]->name}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name}" . lang("app.title delete"), 'flash-category' => substr($db1[0]->code, 0, 2)]);
                }

                // Active
                if ($this->request->getVar('postAction') == 'active') {
                    $result = $db1[0]->adaptation[2] == '1' ? ['0', 'inactive', lang("app.title inactive")] : ['1', 'active', lang("app.title active")];
                    $this->costModel->save(['id' => $db1[0]->id, 'adaptation' => substr($db1[0]->adaptation, 0, 2) . $result[0], 'active_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $unique, "{$db1[0]->code} ; {$db1[0]->name} {$result[1]}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name} {$result[2]}", 'flash-category' => substr($db1[0]->code, 0, 2)]);
                }
                $msg = ['redirect' => '/indirectcost'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
