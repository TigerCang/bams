<?php

namespace App\Controllers\main\person;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\ToolModel;

class PartnerVehicle extends BaseController
{
    protected $toolModel;
    public function __construct()
    {
        $this->toolModel = new ToolModel();
    }

    public function index()
    {
        checkPage('140');
        $data = [
            't_title' => lang('app.partner vehicle'),
            't_span' => lang('app.span partner vehicle'),
            'link' => base_url('partnervehicle'),
            'person1' => $this->mainModel->getData('m_person', session()->getFlashdata('flash-person') ?? '', '', 'id'),
        ];
        $this->render('main/person/partnerVehicle_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_tool', $this->request->getVar('search'), 'u');
            checkPage('140', $db1, 'y', 'n');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, $db1[0]->name);

            $data = [
                't_modal' => lang('app.partner vehicle'),
                'link' => base_url('partnervehicle'),
                'selectTool' => $this->mainModel->distSelect('tool shape'),
                'selectCategory' => $this->mainModel->distItem('m_tool', 'category', 'param', 'partner'),
                'person1' => $this->mainModel->getData('m_person', $db1[0]->partner_id ?? '', '', 'id'),
                'tool' => $db1,
                'button' => ['save' => $buttons['save'], 'confirm' => $buttons['confirm'], 'delete' => $buttons['delete'], 'active' => $buttons['active']],
                'btn_active' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.btn active') : lang('app.btn inactive')),
                'active_by' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.inactive by') : lang('app.active by')),
            ];
            $msg = ['data' => view('main/person/partnerVehicle_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_tool', $this->request->getVar('unique'));
            $cekData = $this->mainModel->cekData('m_tool', 'code2', $this->request->getVar('code2'), '', '', $this->request->getVar('unique'));
            $ruleCode = ($cekData ? 'required|is_unique[m_tool.code2]' : 'required');
            $unique = $this->request->getVar('unique');

            $ruleLink = 'permit_empty';
            if ($this->request->getVar('postAction') == 'delete') {
                // $cekLink = $this->mainModel->cekLink('m_branch', 'company_id', $db1[0]->id);
            }

            $validationRules = [
                'askDelete' => ['rules' => $ruleLink, 'errors' => ['required' => lang("app.err delete")]],
                'person' => ['rules' => 'required', 'errors' => ['required' => lang("app.err select")]],
                'code2' => ['rules' => $ruleCode, 'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unique")]],
                'description' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'askDelete' => $this->validation->getError('askDelete'),
                        'person' => $this->validation->getError('person'),
                        'code2' => $this->validation->getError('code2'),
                        'description' => $this->validation->getError('description'),
                    ]
                ];
            } else {
                // Save
                if ($this->request->getVar('postAction') == 'save') {
                    $adaptation = (empty($db1) ? '001' : $db1[0]->adaptation[0] . '0' . $db1[0]->adaptation[2]);
                    $title = (empty($db1) ? lang('app.title create') : lang('app.title edit'));
                    if ($unique == '') $unique = create_Unique();

                    $this->toolModel->save([
                        'id' => $db1[0]->id ?? '',
                        'unique' => $unique,
                        'param' => 'partner',
                        'partner_id' => $this->request->getVar('person'),
                        'code2' => strtoupper($this->request->getVar('code2')),
                        'model' => $this->request->getVar('model'),
                        'category' => $this->request->getVar('category'),
                        'name' => $this->request->getVar('description'),
                        'notes' => $this->request->getVar('notes'),
                        'adaptation' => $adaptation,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $unique, $this->request->getVar('description'));
                    $this->session->setFlashdata(['message' => $this->request->getVar('description') . $title, 'flash-person' => $this->request->getVar('person')]);
                }


                // Confirm
                if ($this->request->getVar('postAction') == 'confirm') {
                    $adaptation = '11' . $db1[0]->adaptation[2];
                    $this->toolModel->save(['id' => $db1[0]->id, 'adaptation' => $adaptation, 'confirm_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $unique, "{$db1[0]->name}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->name}" . lang("app.title confirm"), 'flash-person' => $db1[0]->partner_id]);
                }

                // Delete
                if ($this->request->getVar('postAction') == 'delete') {
                    $this->toolModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $unique, "{$db1[0]->name}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->name}" . lang("app.title delete"), 'flash-person' => $db1[0]->partner_id]);
                }

                // Active
                if ($this->request->getVar('postAction') == 'active') {
                    $result = $db1[0]->adaptation[2] == '1' ? ['0', 'inactive', lang("app.title inactive")] : ['1', 'active', lang("app.title active")];
                    $this->toolModel->save(['id' => $db1[0]->id, 'adaptation' => substr($db1[0]->adaptation, 0, 2) . $result[0], 'active_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $unique, "{$db1[0]->name} {$result[1]}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->name} {$result[2]}", 'flash-person' => $db1[0]->partner_id]);
                }
                $msg = ['redirect' => '/partnervehicle'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
