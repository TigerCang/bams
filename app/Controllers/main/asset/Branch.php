<?php

namespace App\Controllers\main\asset;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\BranchModel;

class Branch extends BaseController
{
    protected $branchModel;
    public function __construct()
    {
        $this->branchModel = new BranchModel();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        checkPage('127');
        $data = [
            't_title' => lang('app.branch'),
            't_span' => lang('app.span branch'),
            'link' => base_url('branch'),
            'branch' => $this->mainModel->getBranch($this->urls[1]),
        ];
        $this->render('main/asset/branch_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        $db1 = $this->mainModel->getData('m_branch', $this->request->getVar('search'), 'u');
        checkPage('127', $db1, 'y');
        $buttons = setButton($db1);
        if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, "{$db1[0]->code} ; {$db1[0]->name}");

        $data = [
            't_title' => lang('app.branch'),
            't_span' => lang('app.span branch'),
            'link' => base_url('branch'),
            'company' => $this->mainModel->getCompany('', 't'),
            'region' => $this->mainModel->getFile('', 'region', 't'),
            'division' => $this->mainModel->getFile('', 'division', 't'),
            'branch' => $db1,
            'buttonHidden' => $btnAccess = $db1 ? checkAccess($db1[0]->company_id, $db1[0]->region_id, $db1[0]->division_id) : '',
            'button' => ['save' => $buttons['save'], 'confirm' => $buttons['confirm'], 'delete' => $buttons['delete'], 'active' => $buttons['active']],
            'btn_active' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.btn active') : lang('app.btn inactive')),
            'active_by' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.inactive by') : lang('app.active by')),
        ];
        $this->render('main/asset/branch_input', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_branch', $this->request->getVar('unique'));
            $cekData = $this->mainModel->cekData('m_branch', 'code', strtoupper($this->request->getVar('code')), '', '', $this->request->getVar('unique'));
            $ruleCode = ($cekData ? 'required|is_unique[m_branch.code]|min_length[10]' : 'required|min_length[10]');
            $company = (isset($db1[0]->adaptation[0]) && $db1[0]->adaptation[0] == '1' ? $db1[0]->company_id : $this->request->getVar('company'));
            $region = (isset($db1[0]->adaptation[0]) && $db1[0]->adaptation[0] == '1' ? $db1[0]->region_id : $this->request->getVar('region'));
            $division = (isset($db1[0]->adaptation[0]) && $db1[0]->adaptation[0] == '1' ? $db1[0]->division_id : $this->request->getVar('division'));
            $ruleAccess = checkAccess($company, $region, $division, 'save');
            $unique = $this->request->getVar('unique');

            $ruleLink = 'permit_empty';
            if ($this->request->getVar('postAction') == 'delete') {
                if ($ruleLink !== 'required') cekLink('m_person', 'branch_id', $db1[0]->id, $ruleLink);
                // if ($ruleLink !== 'required') cekLink('m_account', 'parent_id', $db1[0]->id, $ruleLink);
                // if ($ruleLink !== 'required') cekLink('m_budget', 'branch_id', $db1[0]->id, $ruleLink);
            }

            $validationRules = [
                'askDelete' => ['rules' => $ruleLink, 'errors' => ['required' => lang("app.err delete")]],
                'company' => ['rules' => $ruleAccess[0], 'errors' => ['valid_email' => lang("app.err access")]],
                'region' => ['rules' => $ruleAccess[1], 'errors' => ['valid_email' => lang("app.err access")]],
                'division' => ['rules' => $ruleAccess[2], 'errors' => ['valid_email' => lang("app.err access")]],
                'code' => ['rules' => $ruleCode, 'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unique"), 'min_length' => lang("app.err length", [10])]],
                'description' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'askDelete' => $this->validation->getError('askDelete'),
                        'company' => $this->validation->getError('company'),
                        'region' => $this->validation->getError('region'),
                        'division' => $this->validation->getError('division'),
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

                    $this->branchModel->save([
                        'id' => $db1[0]->id ?? '',
                        'unique' => $unique,
                        'code' => strtoupper($this->request->getVar('code')),
                        'name' => $this->request->getVar('description'),
                        'address' => $this->request->getVar('address'),
                        'company_id' => $company,
                        'region_id' => $region,
                        'division_id' => $division,
                        'notes' => $this->request->getVar('notes'),
                        'adaptation' => $adaptation,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $unique, strtoupper($this->request->getVar('code')) . ' ; ' . $this->request->getVar('description'));
                    $this->session->setFlashdata(['message' => strtoupper($this->request->getVar('code')) . ' ; ' . $this->request->getVar('description') . $title]);
                }

                // Confirm
                if ($this->request->getVar('postAction') == 'confirm') {
                    $adaptation = '11' . $db1[0]->adaptation[2];
                    $this->branchModel->save(['id' => $db1[0]->id, 'adaptation' => $adaptation, 'confirm_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $unique, "{$db1[0]->code} ; {$db1[0]->name}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name}" . lang("app.title confirm")]);
                }

                // Delete
                if ($this->request->getVar('postAction') == 'delete') {
                    $this->branchModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $unique, "{$db1[0]->code} ; {$db1[0]->name}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name}" . lang("app.title delete")]);
                }

                // Active
                if ($this->request->getVar('postAction') == 'active') {
                    $result = $db1[0]->adaptation[2] == '1' ? ['0', 'inactive', lang("app.title inactive")] : ['1', 'active', lang("app.title active")];
                    $this->branchModel->save(['id' => $db1[0]->id, 'adaptation' => substr($db1[0]->adaptation, 0, 2) . $result[0], 'active_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $unique, "{$db1[0]->code} ; {$db1[0]->name} {$result[1]}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name} {$result[2]}"]);
                }
                $msg = ['redirect' => '/branch'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
