<?php

namespace App\Controllers\main\asset;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\ProjectModel;

class Project extends BaseController
{
    protected $projectModel;
    public function __construct()
    {
        $this->projectModel = new ProjectModel();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        checkPage('128');
        $data = [
            't_title' => lang('app.project'),
            't_span' => lang('app.span project'),
            'link' => base_url('project'),
            'company' => $this->mainModel->getCompany('', 't'),
        ];
        $this->render('main/asset/project_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        $db1 = $this->mainModel->getData('m_project', $this->request->getVar('search'), 'u');
        checkPage('128', $db1, 'y');
        $buttons = setButton($db1);
        if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, "{$db1[0]->code} ; {$db1[0]->package_name}");

        $data = [
            't_title' => lang('app.project'),
            't_span' => lang('app.span project'),
            'link' => base_url('project'),
            'company' => $this->mainModel->getCompany('', 't'),
            'region' => $this->mainModel->getFile('', 'region', 't'),
            'division' => $this->mainModel->getFile('', 'division', 't', '1'),
            'standard1' => $this->mainModel->getData('m_standard', $db1[0]->standard_id ?? '', '', 'id'),
            'category' => $this->mainModel->getFile('', 'project category', 't'),
            'province' => $this->mainModel->distItem('m_project', 'province'),
            'project' => $db1,
            'buttonHidden' => $btnAccess = $db1 ? checkAccess($db1[0]->company_id, $db1[0]->region_id, $db1[0]->division_id) : '',
            'button' => ['save' => $buttons['save'], 'confirm' => $buttons['confirm'], 'delete' => $buttons['delete'], 'active' => $buttons['active']],
            'btn_active' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.btn active') : lang('app.btn inactive')),
            'active_by' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.inactive by') : lang('app.active by')),
        ];
        $this->render('main/asset/project_input', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_project', $this->request->getVar('unique'));
            $cekData = $this->mainModel->cekData('m_project', 'code', $this->request->getVar('code'), '', '', $this->request->getVar('unique'));
            $ruleCode = ($cekData ? 'required|is_unique[m_project.code]|min_length[10]' : 'required|min_length[10]');
            $company = (isset($db1[0]->adaptation[0]) && $db1[0]->adaptation[0] == '1' ? $db1[0]->company_id : $this->request->getVar('company'));
            $region = (isset($db1[0]->adaptation[0]) && $db1[0]->adaptation[0] == '1' ? $db1[0]->region_id : $this->request->getVar('region'));
            $division = (isset($db1[0]->adaptation[0]) && $db1[0]->adaptation[0] == '1' ? $db1[0]->division_id : $this->request->getVar('division'));
            $ruleAccess = checkAccess($company, $region, $division, 'save');
            $unique = $this->request->getVar('unique');

            $ruleLink = 'permit_empty';
            if ($this->request->getVar('postAction') == 'delete') {
                if ($ruleLink !== 'required') cekLink('m_segment', 'project_id', $db1[0]->id, $ruleLink);
            }

            $validationRules = [
                'code' => [
                    'rules' => $ruleCode,
                    'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unique"), 'min_length' => lang("app.err length", [10])]
                ],
                'askDelete' => ['rules' => $ruleLink, 'errors' => ['required' => lang("app.err delete")]],
                'company' => ['rules' => $ruleAccess[0], 'errors' => ['valid_email' => lang("app.err access")]],
                'region' => ['rules' => $ruleAccess[1], 'errors' => ['valid_email' => lang("app.err access")]],
                'division' => ['rules' => $ruleAccess[2], 'errors' => ['valid_email' => lang("app.err access")]],
                'projectName' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'packageName' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'contractValue' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'askDelete' => $this->validation->getError('askDelete'),
                        'company' => $this->validation->getError('company'),
                        'region' => $this->validation->getError('region'),
                        'division' => $this->validation->getError('division'),
                        'code' => $this->validation->getError('code'),
                        'projectName' => $this->validation->getError('projectName'),
                        'packageName' => $this->validation->getError('packageName'),
                        'contractValue' => $this->validation->getError('contractValue'),
                    ]
                ];
            } else {
                // Save
                if ($this->request->getVar('postAction') == 'save') {
                    $adaptation = (empty($db1) ? '001' : $db1[0]->adaptation[0] . '0' . $db1[0]->adaptation[2]);
                    $title = (empty($db1) ? lang('app.title create') : lang('app.title edit'));
                    if ($unique == '') $unique = create_Unique();

                    $this->projectModel->save([
                        'id' => $db1[0]->id ?? '',
                        'unique' => $unique,
                        'code' => strtoupper($this->request->getVar('code')),
                        'project_name' => $this->request->getVar('projectName'),
                        'package_name' => $this->request->getVar('packageName'),
                        'on_name' => $this->request->getVar('onName'),
                        'location' => $this->request->getVar('location'),
                        'province' => $this->request->getVar('province'),
                        'district' => $this->request->getVar('district'),
                        'owner' => $this->request->getVar('owner'),
                        'scope' => $this->request->getVar('scope'),
                        'pay_method' => $this->request->getVar('payMethod'),
                        'category_id' => $this->request->getVar('category'),
                        'standard_id' => $this->request->getVar('standard') ?? '',
                        'contract_date' => $this->request->getVar('contractDate'),
                        'pho_date' => $this->request->getVar('phoDate'),
                        'fho_date' => $this->request->getVar('fhoDate'),
                        'vat' => $this->request->getVar('vat'),
                        'income_tax' => $this->request->getVar('incomeTax'),
                        'contract_value' => changeSeparator($this->request->getVar('contractValue')),
                        'additional_value' => changeSeparator($this->request->getVar('additionalValue')),
                        'extra_value' => changeSeparator($this->request->getVar('extraValue')),
                        'gross_value' => changeSeparator($this->request->getVar('grossValue')),
                        'vat_value' => changeSeparator($this->request->getVar('vatValue')),
                        'income_tax_value' => changeSeparator($this->request->getVar('incomeTaxValue')),
                        'net_value' => changeSeparator($this->request->getVar('netValue')),
                        'period_1' => $this->request->getVar('period1'),
                        'period_2' => $this->request->getVar('period2'),
                        'mode_year' => ($this->request->getVar('period1') == $this->request->getVar('period2') ? 'Single Year' : 'Multi Year'),
                        'company_id' => $company,
                        'region_id' => $region,
                        'division_id' => $division,
                        'consultant' => $this->request->getVar('consultant'),
                        'insurance' => $this->request->getVar('insurance'),
                        'finance' => $this->request->getVar('finance'),
                        'implementation' => $this->request->getVar('implementation'),
                        'notes' => $this->request->getVar('notes'),
                        'adaptation' => $adaptation,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $unique, strtoupper($this->request->getVar('code')) . ' ; ' . $this->request->getVar('packageName'));
                    $this->session->setFlashdata(['message' => strtoupper($this->request->getVar('code')) . ' ; ' . $this->request->getVar('packageName') . $title, 'flash-company' => $company]);
                }

                // Confirm
                if ($this->request->getVar('postAction') == 'confirm') {
                    $adaptation = '11' . $db1[0]->adaptation[2];
                    $this->projectModel->save(['id' => $db1[0]->id, 'adaptation' => $adaptation, 'confirm_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $unique, "{$db1[0]->code} ; {$db1[0]->package_name}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->package_name}" . lang("app.title confirm"), 'flash-company' => $db1[0]->company_id]);
                }

                // Delete
                if ($this->request->getVar('postAction') == 'delete') {
                    $this->projectModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $unique, "{$db1[0]->code} ; {$db1[0]->package_name}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->package_name}" . lang("app.title delete"), 'flash-company' => $db1[0]->company_id]);
                }

                // Active
                if ($this->request->getVar('postAction') == 'active') {
                    $result = $db1[0]->adaptation[2] == '1' ? ['0', 'inactive', lang("app.title inactive")] : ['1', 'active', lang("app.title active")];
                    $this->projectModel->save(['id' => $db1[0]->id, 'adaptation' => substr($db1[0]->adaptation, 0, 2) . $result[0], 'active_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $unique, "{$db1[0]->code} ; {$db1[0]->package_name} {$result[1]}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->package_name} {$result[2]}", 'flash-company' => $db1[0]->company_id]);
                }
                $msg = ['redirect' => '/project'];
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
            $data = ['project' => $this->mainModel->getProject($this->urls[1], '', $this->request->getVar('company'), $this->request->getVar('year'))];
            $msg = ['data' => view('x-main/project_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function loadDistrict()
    {
        if ($this->request->isAJAX()) {
            $sDistrict = $this->request->getVar('district');
            $district = $this->mainModel->distItem('m_project', 'district', 'province', $this->request->getVar('province'));
            $isiDistrict = "";
            foreach ($district as $db) :
                $select = "";
                if ($db->district == $sDistrict) $select = 'selected';
                $isiDistrict .= "<option value='{$db->district}'" . $select . ">{$db->district}</option>";
            endforeach;
            $data = ['district' => $isiDistrict];
            echo json_encode($data);
        } else {
            exit('out');
        }
    }

    public function offFocusProject()
    {
        if ($this->request->isAJAX()) {
            $project1 = $this->mainModel->getData('m_project', $this->request->getVar('project') ?? '', '', 'id');
            $company1 = $this->mainModel->getData('m_company', $project1[0]->company_id ?? '', '', 'id');
            $region1 = $this->mainModel->getData('m_file', $project1[0]->region_id ?? '', '', 'id');
            $msg = ['company' => $company1[0]->code ?? '', 'region' => $region1[0]->name ?? ''];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
