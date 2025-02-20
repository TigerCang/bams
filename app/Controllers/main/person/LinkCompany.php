<?php

namespace App\Controllers\main\person;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\Company1Model;

class LinkCompany extends BaseController
{
    protected $company1Model;
    public function __construct()
    {
        $this->company1Model = new Company1Model();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        checkPage('141');
        $data = [
            't_title' => lang('app.link company'),
            't_span' => lang('app.span link company'),
            'link' => base_url('linkcompany'),
            'pHid' => '',
            'cNew' => 'hidden',
            'company' => $this->mainModel->getCompany($this->urls[1]),
        ];
        $this->render('main/declaration/company_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_company', $this->request->getVar('search'), 'u');
            checkPage('141', $db1, 'y', 'n');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, $db1[0]->code . ' ; ' . $db1[0]->name);

            $data = [
                't_modal' => lang('app.link company'),
                'link' => base_url('linkcompany'),
                'person1' => $this->mainModel->getData('m_person', $db1[0]->person_id ?? '', '', 'id'),
                'company' => $db1,
                'button' => ['save' => $buttons['save'], 'confirm' => $buttons['confirm'], 'delete' => $buttons['delete'], 'active' => $buttons['active']],
                'btn_active' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.btn active') : lang('app.btn inactive')),
                'active_by' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.inactive by') : lang('app.active by')),
            ];
            $msg = ['data' => view('main/person/linkCompany_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_company', $this->request->getVar('unique'));
            $unique = $this->request->getVar('unique');
            $validationRules = ['person' => ['rules' => 'required', 'errors' => ['required' => lang("app.err select")]]];

            if (!$this->validate($validationRules)) {
                $msg = ['error' => ['person' => $this->validation->getError('person')]];
            } else {
                // Save
                $db2 = $this->mainModel->getData('m_person', $this->request->getVar('person'), '', 'id');
                $this->company1Model->save(['id' => $db1[0]->id, 'person_id' => $this->request->getVar('person')]);
                $this->logModel->saveLog('Save', $unique, $db2[0]->code);
                $this->session->setFlashdata(['message' => "{$db2[0]->code}" . lang('app.title edit')]);
                $msg = ['redirect' => '/linkcompany'];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
