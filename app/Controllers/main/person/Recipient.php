<?php

namespace App\Controllers\main\person;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\PersonModel;

class Recipient extends BaseController
{
    protected $personModel;
    public function __construct()
    {
        $this->personModel = new PersonModel();
    }

    public function index()
    {
        checkPage('139');
        $data = [
            't_title' => lang('app.recipient'),
            't_span' => lang('app.span recipient'),
            'link' => '/recipient',
            'category' => $this->mainModel->distItem('m_person', 'category'),
        ];
        $this->render('main/person/recipient_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_person', $this->request->getVar('search'), 'u');
            checkPage('139', $db1, 'y', 'n');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, "{$db1[0]->code} ; {$db1[0]->name}");

            $data = [
                't_modal' => lang('app.person'),
                'link' => "/recipient",
                'category' => $this->mainModel->distItem('m_person', 'category'),
                'selectGroup1' => $this->mainModel->loadGroupAccount('person', 'customer'),
                'selectGroup2' => $this->mainModel->loadGroupAccount('person', 'supplier'),
                'selectGroup3' => $this->mainModel->loadGroupAccount('person', 'subcontractor'),
                'selectGroup4' => $this->mainModel->loadGroupAccount('person', 'employee'),
                'recipient' => $db1,
                'button' => ['save' => $buttons['save'], 'confirm' => $buttons['confirm'], 'delete' => $buttons['delete'], 'active' => $buttons['active']],
                'btn_active' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.btn active') : lang('app.btn inactive')),
                'active_by' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.inactive by') : lang('app.active by')),
            ];
            $msg = ['data' => view('main/person/recipient_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_person', $this->request->getVar('unique'));
            $cekData = $this->mainModel->cekData('m_person', 'code', $this->request->getVar('code'), '', '', $this->request->getVar('unique'));
            $ruleCode = ($cekData ? 'required|is_unique[m_person.code]|min_length[16]' : 'required|min_length[16]');
            $ruleGroup1 = ($this->request->getVar('customer') == 'on' ? 'required' : 'permit_empty');
            $ruleGroup2 = ($this->request->getVar('supplier') == 'on' ? 'required' : 'permit_empty');
            $ruleGroup3 = ($this->request->getVar('subcontractor') == 'on' ? 'required' : 'permit_empty');
            $unique = $this->request->getVar('unique');

            $ruleLink = 'permit_empty';
            if ($this->request->getVar('postAction') == 'delete') {
                // $cekLink = $this->mainModel->cekLink('m_branch', 'company_id', $db1[0]->id);
            }

            $validationRules = [
                'code' => [
                    'rules' => $ruleCode,
                    'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unique"), 'min_length' => lang("app.err length", [16])]
                ],
                'askDelete' => ['rules' => $ruleLink, 'errors' => ['required' => lang("app.err delete")]],
                'description' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'category' => ['rules' => 'required', 'errors' => ['required' => lang("app.err select")]],
                'groupAccount1' => ['rules' => $ruleGroup1, 'errors' => ['required' => lang("app.err select")]],
                'groupAccount2' => ['rules' => $ruleGroup2, 'errors' => ['required' => lang("app.err select")]],
                'groupAccount3' => ['rules' => $ruleGroup3, 'errors' => ['required' => lang("app.err select")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'askDelete' => $this->validation->getError('askDelete'),
                        'code' => $this->validation->getError('code'),
                        'description' => $this->validation->getError('description'),
                        'category' => $this->validation->getError('category'),
                        'groupAccount1' => $this->validation->getError('groupAccount1'),
                        'groupAccount2' => $this->validation->getError('groupAccount2'),
                        'groupAccount3' => $this->validation->getError('groupAccount3'),
                    ]
                ];
            } else {
                // Save
                if ($this->request->getVar('postAction') == 'save') {
                    $adaptation = (empty($db1) ? '001' : $db1[0]->adaptation[0] . '0' . $db1[0]->adaptation[2]);
                    $title = (empty($db1) ? lang('app.title create') : lang('app.title edit'));
                    $customer = ($this->request->getVar('customer') == 'on' ? '1' : '0');
                    $supplier = ($this->request->getVar('supplier') == 'on' ? '1' : '0');
                    $subcontractor = ($this->request->getVar('subcontractor') == 'on' ? '1' : '0');
                    $employee = (empty($db1) ? '00' : substr($db1[0]->is_alias, -2));
                    $alias = $customer . $supplier . $subcontractor . $employee;
                    if ($unique == '') $unique = create_Unique();

                    $this->personModel->save([
                        'id' => $db1[0]->id ?? '',
                        'unique' => $unique,
                        'code' => strtoupper($this->request->getVar('code')),
                        'name' => $this->request->getVar('description'),
                        'email' => $this->request->getVar('email'),
                        'category' => $this->request->getVar('category'),
                        'address' => $this->request->getVar('address'),
                        'contact' => $this->request->getVar('contact'),
                        'is_alias' => $alias,
                        'group_account_customer' => ($this->request->getVar('customer') == 'on' ? $this->request->getVar('groupAccount1') : ''),
                        'group_account_supplier' => ($this->request->getVar('supplier') == 'on' ? $this->request->getVar('groupAccount2') : ''),
                        'group_account_partner' => ($this->request->getVar('subcontractor') == 'on' ? $this->request->getVar('groupAccount3') : ''),
                        'notes' => $this->request->getVar('notes'),
                        'adaptation' => $adaptation,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $unique, strtoupper($this->request->getVar('code')) . ' ; ' . $this->request->getVar('description'));
                    $this->session->setFlashdata(['message' => strtoupper($this->request->getVar('code')) . ' ; ' . $this->request->getVar('description') . $title, 'flash-category' => $this->request->getVar('category')]);
                }

                // Confirm
                if ($this->request->getVar('postAction') == 'confirm') {
                    $adaptation = '11' . $db1[0]->adaptation[2];
                    $this->personModel->save(['id' => $db1[0]->id, 'adaptation' => $adaptation, 'confirm_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $unique, "{$db1[0]->code} ; {$db1[0]->name}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name}" . lang("app.title confirm"), 'flash-category' => $db1[0]->category]);
                }

                // Delete
                if ($this->request->getVar('postAction') == 'delete') {
                    $this->personModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $unique, "{$db1[0]->code} ; {$db1[0]->name}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name}" . lang("app.title delete"), 'flash-category' => $db1[0]->category]);
                }

                // Active
                if ($this->request->getVar('postAction') == 'active') {
                    $result = $db1[0]->adaptation[2] == '1' ? ['0', 'inactive', lang("app.title inactive")] : ['1', 'active', lang("app.title active")];
                    $this->personModel->save(['id' => $db1[0]->id, 'adaptation' => substr($db1[0]->adaptation, 0, 2) . $result[0], 'active_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $unique, "{$db1[0]->code} ; {$db1[0]->name} {$result[1]}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name} {$result[2]}", 'flash-category' => $db1[0]->category]);
                }
                $msg = ['redirect' => '/recipient'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function SearchData()
    {
        if ($this->request->isAJAX()) {
            $data = ['employee' => $this->mainModel->getPerson($this->urls[1], '', '', '', '', $this->request->getVar('category')), 'cp' => '10'];
            $msg = ['data' => view('x-main/employee_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
