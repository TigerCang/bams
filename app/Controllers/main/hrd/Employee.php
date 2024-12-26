<?php

namespace App\Controllers\main\hrd;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\PersonModel;

class Employee extends BaseController
{
    protected $personModel;
    public function __construct()
    {
        $this->personModel = new PersonModel();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        checkPage('146');
        $data = [
            't_title' => lang('app.employee'),
            't_span' => lang('app.span employee'),
            'link' => '/employee',
            'company' => $this->mainModel->getCompany('', 't'),
            'selectPosition' => $this->mainModel->getFile('', 'position', 't'),
        ];
        $this->render('main/hrd/employee_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        $db1 = $this->mainModel->getData('m_person', $this->request->getVar('search'), 'u');
        checkPage('146', $db1, 'y', 'n');
        $buttons = setButton($db1);
        if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, "{$db1[0]->code} ; {$db1[0]->eid} ; {$db1[0]->name}");

        $data = [
            't_title' => lang('app.employee'),
            't_span' => lang('app.span employee'),
            'link' => "/employee",
            'company' => $this->mainModel->getCompany('', 't'),
            'region' => $this->mainModel->getFile('', 'region', 't'),
            'division' => $this->mainModel->getFile('', 'division', 't'),
            'selectGroup' => $this->mainModel->loadGroupAccount('person', 'employee'),
            'position' => $this->mainModel->getFile('', 'position', 't'),
            'class' => $this->mainModel->getFile('', 'class', 't'),
            'salary' => $this->mainModel->getFile('', 'salary group', 't'),
            'selectBlood' => $this->mainModel->distSelect('blood'),
            'selectGroupPTKP' => $this->mainModel->distSelect('ptkp', 't'),
            'selectPTKP' => $this->mainModel->distSelect('ptkp'),
            'selectGroupSIM' => $this->mainModel->distSelect('sim', 't'),
            'selectSIM' => $this->mainModel->distSelect('sim'),
            'selectDiploma' => $this->mainModel->distSelect('diploma'),
            'selectMajor' => $this->mainModel->distItem('m_person', 'major'),
            'selectDiplomaStatus' => $this->mainModel->distSelect('diploma st'),
            'selectEmployeeStatus' => $this->mainModel->distSelect('employee st'),
            'selectOut' => $this->mainModel->distSelect('out mode'),
            'branch1' => $this->mainModel->getData('m_branch', $db1[0]->branch_id ?? '', '', 'id'),
            'user1' => $this->mainModel->getData('m_user', $db1[0]->user_id ?? '', '', 'id'),
            'supervisor1' => $this->mainModel->getData('m_person', $db1[0]->supervisor_id ?? '', '', 'id'),
            'employee' => $db1,
            'button' => ['save' => $buttons['save'], 'confirm' => $buttons['confirm'], 'delete' => $buttons['delete'], 'active' => $buttons['active']],
            'btn_active' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.btn active') : lang('app.btn inactive')),
            'active_by' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.inactive by') : lang('app.active by')),
        ];
        $this->render('main/hrd/employee_input', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_person', $this->request->getVar('unique'));
            $cekData = $this->mainModel->cekData('m_person', 'code', $this->request->getVar('code'), '', '', $this->request->getVar('unique'));
            $ruleCode = ($cekData ? 'required|is_unique[m_person.code]|min_length[16]' : 'required|min_length[16]');
            $ruleSupervisor = (isset($db1[0]) && ($db1[0]->id == $this->request->getVar('supervisor')) ? 'valid_email' : 'permit_empty');
            $company = (isset($db1[0]->adaptation[0]) && $db1[0]->adaptation[0] == '1' ? $db1[0]->company_id : $this->request->getVar('company'));
            $region = (isset($db1[0]->adaptation[0]) && $db1[0]->adaptation[0] == '1' ? $db1[0]->region_id : $this->request->getVar('region'));
            $division = (isset($db1[0]->adaptation[0]) && $db1[0]->adaptation[0] == '1' ? $db1[0]->division_id : $this->request->getVar('division'));
            $salary = ((isset($db1[0]->adaptation[0]) && $db1[0]->adaptation[0] == '1') ? (thisUser()['act_access'][8] == '1' ? $this->request->getVar('salary') : $db1[0]->salary_id) : $this->request->getVar('salary'));
            $alias = '0001' . ($this->request->getVar('osm') == 'on' ? '1' : '0');
            $cekUser = $this->mainModel->cekData('m_person', 'user_id', $this->request->getVar('username'), '', '', $this->request->getVar('unique'));
            $ruleUsername = ($cekUser ? 'valid_email' : 'permit_empty');
            $unique = $this->request->getVar('unique');

            $ruleLink = 'permit_empty';
            if ($this->request->getVar('postAction') == 'delete') {
                // $cekLink = $this->mainModel->cekLink('m_item', $field, $db1[0]->id);
            }

            $validationRules = [
                'code' => [
                    'rules' => $ruleCode,
                    'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unique"), 'min_length' => lang("app.err length", [16])]
                ],
                'askDelete' => ['rules' => $ruleLink, 'errors' => ['required' => lang("app.err delete")]],
                'eid' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'description' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'picture' => [
                    'rules' => 'max_size[picture,1024]|is_image[picture]|mime_in[picture,image/jpg,image/jpeg,image/bmp,image/png]',
                    'errors' => ['max_size' => lang("app.err file1"), 'is_image' => lang("app.err notImage"), 'mime_in' => lang("app.err fileMime")]
                ],
                'username' => ['rules' => $ruleUsername, 'errors' => ['valid_email' => lang("app.err invalid")]],
                'supervisor' => ['rules' => $ruleSupervisor, 'errors' => ['valid_email' => lang("app.err invalid")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'askDelete' => $this->validation->getError('askDelete'),
                        'code' => $this->validation->getError('code'),
                        'eid' => $this->validation->getError('eid'),
                        'description' => $this->validation->getError('description'),
                        'picture' => $this->validation->getError('picture'),
                        'username' => $this->validation->getError('username'),
                        'supervisor' => $this->validation->getError('supervisor'),
                    ]
                ];
            } else {
                // Save
                if ($this->request->getVar('postAction') == 'save') {
                    $adaptation = (empty($db1) ? '001' : $db1[0]->adaptation[0] . '0' . $db1[0]->adaptation[2]);
                    $title = (empty($db1) ? lang('app.title create') : lang('app.title edit'));
                    $file_picture = $this->request->getFile('picture');
                    $picture_name = ($file_picture->getError() == 4) ? $this->request->getVar('pictureName') : $file_picture->getName();
                    if ($file_picture->getError() != 4) $file_picture->move('assets/picture/employee/', $picture_name);
                    if ($this->request->getVar('pictureName') != 'default.png' && $file_picture->getError() != 4) unlink('assets/picture/employee/' . $this->request->getVar('pictureName'));
                    if ($unique == '') $unique = create_Unique();

                    $this->personModel->save([
                        'id' => $db1[0]->id ?? '',
                        'unique' => $unique,
                        'code' => strtoupper($this->request->getVar('code')),
                        'eid' => $this->request->getVar('eid'),
                        'name' => $this->request->getVar('description'),
                        'category' => 'Pegawai',
                        'branch_id' => $this->request->getVar('branch') ?? '',
                        'location' => $this->request->getVar('location'),
                        'gender' => $this->request->getVar('gender'),
                        'blood' => $this->request->getVar('blood'),
                        'birth_place' => $this->request->getVar('birthPlace'),
                        'birth_date' => $this->request->getVar('birthDate'),
                        'address' => $this->request->getVar('address'),
                        'contact' => $this->request->getVar('contact'),
                        'email' => $this->request->getVar('email'),
                        'diploma' => $this->request->getVar('diploma'),
                        'major' => $this->request->getVar('major'),
                        'diploma_st' => $this->request->getVar('diplomaStatus'),
                        'diploma_date' => $this->request->getVar('diplomaDate'),
                        'license_type' => $this->request->getVar('licenseType'),
                        'license_number' => $this->request->getVar('licenseNumber'),
                        'license_date' => $this->request->getVar('licenseDate'),
                        'worker' => $this->request->getVar('ptkp'),
                        'join_date' => $this->request->getVar('joinDate'),
                        'employee_st' => $this->request->getVar('employeeStatus'),
                        'contract_date_1' => $this->request->getVar('contractDate1'),
                        'contract_date_2' => $this->request->getVar('contractDate2'),
                        'out_select' => $this->request->getVar('outSelect'),
                        'out_date' => $this->request->getVar('outDate'),
                        'out_reason' => $this->request->getVar('outReason'),
                        'salary_id' => $salary,
                        'position_id' => $this->request->getVar('position'),
                        'class_id' => $this->request->getVar('class'),
                        'user_id' => $this->request->getVar('username') ?? '',
                        'supervisor_id' => $this->request->getVar('supervisor') ?? '',
                        'insurance' => $this->request->getVar('insurance'),
                        'is_alias' => $alias,
                        'group_account_employee' => $this->request->getVar('groupAccount'),
                        'company_id' => $company,
                        'region_id' => $region,
                        'division_id' => $division,
                        'picture' => $picture_name,
                        'notes' => $this->request->getVar('notes'),
                        'adaptation' => $adaptation,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $unique, strtoupper($this->request->getVar('code')) . ' ; ' . $this->request->getVar('eid') . ' ; ' . $this->request->getVar('description'));
                    $this->session->setFlashdata(['message' => strtoupper($this->request->getVar('code')) . ' ; ' . $this->request->getVar('eid') . ' ; ' . $this->request->getVar('description') . $title, 'flash-company' => $company, 'flash-position' => $this->request->getVar('position')]);
                }

                // Confirm
                if ($this->request->getVar('postAction') == 'confirm') {
                    $adaptation = '11' . $db1[0]->adaptation[2];
                    $this->personModel->save(['id' => $db1[0]->id, 'adaptation' => $adaptation, 'confirm_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $unique, "{$db1[0]->code} ; {$db1[0]->eid} ; {$db1[0]->name}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->eid} ; {$db1[0]->name}" . lang("app.title confirm"), 'flash-company' => $db1[0]->company_id, 'flash-position' => $db1[0]->position_id]);
                }

                // Delete
                if ($this->request->getVar('postAction') == 'delete') {
                    $this->personModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $unique, "{$db1[0]->code} ; {$db1[0]->eid} ; {$db1[0]->name}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->eid} ; {$db1[0]->name}" . lang("app.title delete"), 'flash-company' => $db1[0]->company_id, 'flash-position' => $db1[0]->position_id]);
                }

                // Active
                if ($this->request->getVar('postAction') == 'active') {
                    $result = $db1[0]->adaptation[2] == '1' ? ['0', 'inactive', lang("app.title inactive")] : ['1', 'active', lang("app.title active")];
                    $this->personModel->save(['id' => $db1[0]->id, 'adaptation' => substr($db1[0]->adaptation, 0, 2) . $result[0], 'active_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $unique, "{$db1[0]->code} ; {$db1[0]->eid} ; {$db1[0]->name} {$result[1]}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->eid} ; {$db1[0]->name} {$result[2]}", 'flash-company' => $db1[0]->company_id, 'flash-position' => $db1[0]->position_id]);
                }
                $msg = ['redirect' => '/employee'];
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
            $data = ['employee' => $this->mainModel->getPerson($this->urls[1], '1', '', '', $this->request->getVar('company'), '', $this->request->getVar('position')), 'cp' => '01'];
            $msg = ['data' => view('x-main/employee_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
