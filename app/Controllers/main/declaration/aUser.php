<?php

namespace App\Controllers\main\declaration;

use Config\App;
use App\Controllers\BaseController;

class aUser extends BaseController
{
    public function index()
    {
        checkPage('110');
        $data = [
            't_title' => lang('app.child user'),
            't_span' => lang('app.span child user'),
            'link' => base_url('auser'),
            'user' => $this->mainModel->getUser($this->urls[1], $this->user['id']),
        ];
        $this->render('admin/user_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        $db1 = $this->mainModel->getData('m_user', $this->request->getVar('search'), 'u');
        checkPage('110', $db1, 'y', 'n');
        $buttons = setButton($db1);
        if ($this->request->getVar('search')) $this->logModel->saveLog('Read', $db1[0]->unique, $db1[0]->code);

        $data = [
            't_title' => lang('app.user anak'),
            't_span' => lang('app.span user'),
            'link' => base_url('auser'),
            'company' => $this->mainModel->getCompany('', 't'),
            'region' => $this->mainModel->getFile('', 'region', 't'),
            'division' => $this->mainModel->getFile('', 'division', 't'),
            'salary' => $this->mainModel->getFile('', 'salary group', 't'),
            'project' => $this->mainModel->getProject('', 't'),
            'branch' => $this->mainModel->getBranch('', 't'),
            'tool' => $this->mainModel->getTool('', 't', 'multi'),
            'land' => $this->mainModel->getLand('', 't'),
            'cash' => $this->mainModel->getGroupAccount('', 'cash', 't'),
            'role' => $this->mainModel->getRole('', 't'),
            'token' => $this->mainModel->getData('user_token', $db1[0]->token_id ?? '', '', 'id'),
            'supervisor' => $this->mainModel->getData('m_user', $db1[0]->supervisor_id ?? '', '', 'id', 't'),
            'user' => $db1,
            'button' => ['save' => $buttons['save'], 'confirm' => $buttons['confirm'], 'delete' => $buttons['delete'], 'active' => $buttons['active']],
            'btn_active' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.btn active') : lang('app.btn inactive')),
            'active_by' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.inactive by') : lang('app.active by')),
        ];
        $this->render('admin/user_input', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_user', $this->request->getVar('unique'));
            $db2 = $this->mainModel->getData('m_user', $db1[0]->supervisor_id, '', 'id');
            $limit = $db2[0]->act_limit;
            $ruleLimit = (changeSeparator($this->request->getVar('limit')) > $limit ? 'valid_email' : 'permit_empty');

            $validationRules = [
                'limit' => ['rules' => $ruleLimit, 'errors' => ['valid_email' => lang("app.err invalid")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = ['error' => ['limit' => $this->validation->getError('limit')]];
            } else {
                // Save
                if ($this->request->getVar('postAction') == 'save') {
                    $companyMulti = (empty($this->request->getPost('accessCompany')) || $this->request->getPost('accessCompany') == ',') ? ',' : ',' . $this->request->getPost('accessCompany') . ',';
                    $regionMulti = (empty($this->request->getPost('accessRegion')) || $this->request->getPost('accessRegion') == ',') ? ',' : ',' . $this->request->getPost('accessRegion') . ',';
                    $divisionMulti = (empty($this->request->getPost('accessDivision')) || $this->request->getPost('accessDivision') == ',') ? ',' : ',' . $this->request->getPost('accessDivision') . ',';
                    $salaryMulti = (!empty($_POST['listSalary']) ? ',' . implode(",", $_POST['listSalary']) . ',' : '' . ',');
                    $projectMulti = (!empty($_POST['listProject']) ? ',' . implode(",", $_POST['listProject']) . ',' : '' . ',');
                    $branchMulti = (!empty($_POST['listBranch']) ? ',' . implode(",", $_POST['listBranch']) . ',' : '' . ',');
                    $toolMulti = (!empty($_POST['listTool']) ? ',' . implode(",", $_POST['listTool']) . ',' : '' . ',');
                    $landMulti = (!empty($_POST['listLand']) ? ',' . implode(",", $_POST['listLand']) . ',' : '' . ',');
                    $cashMulti = (!empty($_POST['listCash']) ? ',' . implode(",", $_POST['listCash']) . ',' : '' . ',');
                    $adaptation = $db1[0]->adaptation[0] . '0' . $db1[0]->adaptation[2];
                    $fieldAction = ['create', 'read', 'edit', 'delete', 'confirm', 'active'];
                    $button = implode('', array_map(fn($field) => $this->request->getVar($field) == 'on' ? '1' : '0', $fieldAction));
                    $fieldAccess = ['company', 'region', 'division', 'salary', 'project', 'branch', 'tool', 'land', 'super', 'saring'];
                    $access = implode('', array_map(fn($field) => $this->request->getVar($field) == 'on' ? '1' : '0', $fieldAccess));

                    $this->userModel->save([
                        'id' => $db1[0]->id,
                        'role_id' => $this->request->getVar('role'),
                        'act_approve' => $this->request->getVar('approve'),
                        'act_limit' => changeSeparator($this->request->getVar('limit')),
                        'act_button' => $button,
                        'act_access' => $access,
                        'company' => $companyMulti,
                        'region' => $regionMulti,
                        'division' => $divisionMulti,
                        'salary' => $salaryMulti,
                        'project' => $projectMulti,
                        'branch' => $branchMulti,
                        'tool' => $toolMulti,
                        'land' => $landMulti,
                        'cash' => $cashMulti,
                        'adaptation' => $adaptation,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $db1[0]->unique, $db1[0]->code);
                    $this->session->setFlashdata(['message' => $db1[0]->code . lang("app.title edit")]);
                }

                // Confirm
                if ($this->request->getVar('postAction') == 'confirm') {
                    $adaptation = '11' . $db1[0]->adaptation[2];
                    $this->userModel->save(['id' => $db1[0]->id, 'adaptation' => $adaptation, 'conf_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $db1[0]->unique, $db1[0]->code);
                    $this->session->setFlashdata(['message' => $db1[0]->code . lang("app.title confirm")]);
                }

                // Delete
                if ($this->request->getVar('postAction') == 'delete') {
                    $this->userModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $db1[0]->unique, $db1[0]->code);
                    $this->session->setFlashdata(['message' => $db1[0]->code . lang("app.title delete")]);
                }

                // Activation
                if ($this->request->getVar('postAction') == 'active') {
                    $result = $db1[0]->adaptation[2] == '1' ? ['0', 'inactive', lang("app.title inactive")] : ['1', 'active', lang("app.title active")];
                    $this->userModel->save(['id' => $db1[0]->id, 'adaptation' => substr($db1[0]->adaptation, 0, 2) . $result[0], 'active_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $db1[0]->unique, "{$db1[0]->code} {$result[1]}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} {$result[2]}"]);
                }
                $msg = ['redirect' => '/auser'];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
