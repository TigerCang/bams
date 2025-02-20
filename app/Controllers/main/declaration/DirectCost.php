<?php

namespace App\Controllers\main\declaration;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\CostModel;

class DirectCost extends BaseController
{
    protected $costModel;
    public function __construct()
    {
        $this->costModel = new CostModel();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        checkPage('113');
        $data = [
            't_title' => lang('app.direct cost'),
            't_span' => lang('app.span direct cost'),
            'link' => base_url('directcost'),
            'param' => 'direct cost',
            'category' => $this->mainModel->getFile('', 'project category', 't'),
        ];
        $this->render('main/declaration/cost_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_cost', $this->request->getVar('search'), 'u');
            checkPage('113', $db1, 'y', 'n');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, "{$db1[0]->code} ; {$db1[0]->name}");

            $data = [
                't_modal' => lang('app.direct cost'),
                'link' => base_url('directcost'),
                'mpHid' => '',
                'kHid' => '',
                'jlHid' => 'hidden',
                'aHid' => 'hidden',
                'unit' => $this->mainModel->getFile('', 'unit', 't'),
                'account1' => [],
                'category' => $this->mainModel->getFile('', 'project category'),
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
            $cekData = $this->mainModel->cekData('m_cost', 'code', $this->request->getVar('code'), 'category_id', $this->request->getVar('category'), $this->request->getVar('unique'));
            $ruleCode = ($cekData ? 'required|is_unique[m_cost.code]' : 'required|min_length[8]');
            $code = $this->request->getVar('code');
            $unique = $this->request->getVar('unique');

            $level = (substr($code, 2) == '000000' ? "1" : (substr($code, 4) == '0000' ? "2" : "3"));
            if ($level != "1") {
                $parentLevel = ($level == "2" ? "1" : "2");
                $parentCost = ($level == "2" ? substr($code, 0, 2) . "000000" : substr($code, 0, 4) . "0000");
            }
            $ruleUnit = ($level == "3" ? 'required' : 'permit_empty');
            $unit = ($level == "3" ? $this->request->getVar('unit') : '');
            $parentID = "0";
            if (strlen($this->request->getVar('code')) == "8" && $level != "1") {
                $cekParent = $this->mainModel->cekParentCost('direct cost', strtoupper($parentCost), $parentLevel, $this->request->getVar('category'));
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
                'unit' => ['rules' => $ruleUnit, 'errors' => ['required' => lang("app.err select")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'askDelete' => $this->validation->getError('askDelete'),
                        'code' => $this->validation->getError('code'),
                        'description' => $this->validation->getError('description'),
                        'unit' => $this->validation->getError('unit'),
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
                        'param' => 'direct cost',
                        'parent_id' => $parentID,
                        'category_id' => $this->request->getVar('category'),
                        'code' => strtoupper($this->request->getVar('code')),
                        'pay_code' => $this->request->getVar('payCode'),
                        'name' => $this->request->getVar('description'),
                        'unit' => $unit,
                        'level' => $level,
                        'adaptation' => $adaptation,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $unique, strtoupper($this->request->getVar('code')) . ' ; ' . $this->request->getVar('description'));
                    $this->session->setFlashdata(['message' => strtoupper($this->request->getVar('code')) . ' ; ' . $this->request->getVar('description') . $title, 'flash-category' => $this->request->getVar('category')]);
                }

                // Confirm
                if ($this->request->getVar('postAction') == 'confirm') {
                    $adaptation = '11' . $db1[0]->adaptation[2];
                    $this->costModel->save(['id' => $db1[0]->id, 'adaptation' => $adaptation, 'confirm_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $unique, "{$db1[0]->code} ; {$db1[0]->name}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name}" . lang("app.title confirm"), 'flash-category' => $db1[0]->category_id]);
                }

                // Delete
                if ($this->request->getVar('postAction') == 'delete') {
                    $this->costModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $unique, "{$db1[0]->code} ; {$db1[0]->name}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name}" . lang("app.title delete"), 'flash-category' => $db1[0]->category_id]);
                }

                // Active
                if ($this->request->getVar('postAction') == 'active') {
                    $result = $db1[0]->adaptation[2] == '1' ? ['0', 'inactive', lang("app.title inactive")] : ['1', 'active', lang("app.title active")];
                    $this->costModel->save(['id' => $db1[0]->id, 'adaptation' => substr($db1[0]->adaptation, 0, 2) . $result[0], 'active_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $unique, "{$db1[0]->code} ; {$db1[0]->name} {$result[1]}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name} {$result[2]}", 'flash-category' => $db1[0]->category_id]);
                }
                $msg = ['redirect' => '/directcost'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
