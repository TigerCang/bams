<?php

namespace App\Controllers\admin;

use Config\App;
use App\Controllers\BaseController;
use App\Models\admin\RoleModel;

class Role extends BaseController
{
    protected $roleModel;
    public function __construct()
    {
        $this->roleModel = new RoleModel();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        checkPage('103');
        $data = [
            't_title' => lang('app.role'),
            't_span' => lang('app.span role'),
            'link' => '/role',
            'role' => $this->mainModel->getRole($this->urls[1]),
            'totUser' => $this->mainModel->searchID('m_user', 'count'),
        ];
        $this->render('admin/role_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        $db1 = $this->mainModel->getData('m_role', $this->request->getVar('search'), 'u');
        checkPage('103', $db1, 'y', 'n');
        $buttons = setButton($db1);
        if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, $db1[0]->name);

        $data = [
            't_title' => lang('app.role'),
            't_span' => lang('app.span role'),
            'link' => "/role",
            'role' => $db1,
            'button' => ['save' => $buttons['save'], 'confirm' => $buttons['confirm'], 'delete' => $buttons['delete'], 'active' => $buttons['active']],
            'btn_active' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.btn active') : lang('app.btn inactive')),
            'active_by' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.inactive by') : lang('app.active by')),
        ];
        $this->render('admin/role_input', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_role', $this->request->getVar('unique'));
            $cekData = $this->mainModel->cekData('m_role', 'name', $this->request->getVar('description'), '', '', $this->request->getVar('unique'));
            $ruleName = ($cekData ? 'required|is_unique[m_role.name]' : 'required');
            $unique = $this->request->getVar('unique');

            $ruleLink = 'permit_empty';
            if ($this->request->getVar('postAction') == 'delete') cekLink('m_user', 'role_id', $db1[0]->id, $ruleLink);
            $validationRules = [
                'askDelete' => ['rules' => $ruleLink, 'errors' => ['required' => lang("app.err delete")]],
                'description' => ['rules' => $ruleName, 'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unique")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = ['error' => [
                    'askDelete' => $this->validation->getError('askDelete'),
                    'description' => $this->validation->getError('description'),
                ]];
            } else {
                // Save
                if ($this->request->getVar('postAction') == 'save') {
                    $adaptation = (empty($db1) ? '001' : $db1[0]->adaptation[0] . '0' . $db1[0]->adaptation[2]);
                    $title = (empty($db1) ? lang('app.title create') : lang('app.title edit'));
                    if ($unique == '') $unique = create_Unique();

                    $this->roleModel->save([
                        'id' => $db1[0]->id ?? '',
                        'unique' => $unique,
                        'name' => $this->request->getVar('description'),
                        'menu_1' => $this->request->getVar('menu1'),
                        'adaptation' => $adaptation,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $unique, "{$this->request->getVar('description')}");
                    $this->session->setFlashdata(['message' => "{$this->request->getVar('description')} {$title}"]);
                }

                // Confirm
                if ($this->request->getVar('postAction') == 'confirm') {
                    $adaptation = '11' . $db1[0]->adaptation[2];
                    $this->roleModel->save(['id' => $db1[0]->id, 'adaptation' => $adaptation, 'confirm_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $unique, $db1[0]->name);
                    $this->session->setFlashdata(['message' => $db1[0]->name . lang("app.title confirm")]);
                }

                // Delete
                if ($this->request->getVar('postAction') == 'delete') {
                    $this->roleModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $unique, $db1[0]->name);
                    $this->session->setFlashdata(['message' => $db1[0]->name . lang("app.title delete")]);
                }

                // Active
                if ($this->request->getVar('postAction') == 'active') {
                    $result = $db1[0]->adaptation[2] == '1' ? ['0', 'inactive', lang("app.title inactive")] : ['1', 'active', lang("app.title active")];
                    $this->roleModel->save(['id' => $db1[0]->id, 'adaptation' => substr($db1[0]->adaptation, 0, 2) . $result[0], 'active_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $unique, $db1[0]->name . $result[1]);
                    $this->session->setFlashdata(['message' => $db1[0]->name . $result[2]]);
                }
                $msg = ['redirect' => '/role'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
