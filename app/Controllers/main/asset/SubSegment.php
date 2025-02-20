<?php

namespace App\Controllers\main\asset;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\SegmentModel;

class SubSegment extends BaseController
{
    protected $segmentModel;
    public function __construct()
    {
        $this->segmentModel = new SegmentModel();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        checkPage('130');
        $data = [
            't_title' => lang('app.sub segment'),
            't_span' => lang('app.span sub segment'),
            'link' => base_url('subsegment'),
            'filter' => '',
            'bcd' => '111',
            'project1' => $this->mainModel->getData('m_project', session()->getFlashdata('flash-project') ?? '', '', 'id'),
        ];
        $this->render('main/asset/segment_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_segment', $this->request->getVar('search'), 'u');
            $db2 = $this->mainModel->getData('m_project', $db1[0]->project_id ?? '', '', 'id');
            checkPage('130', $db1, 'y');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, "{$db1[0]->code} ; {$db1[0]->name}");

            $data = [
                't_modal' => lang('app.sub segment'),
                'link' => base_url('subsegment'),
                'branch1' => $this->mainModel->getData('m_branch', $db1[0]->branch_id ?? '', '', 'id'),
                'project1' => $this->mainModel->getData('m_project', $db1[0]->project_id ?? '', '', 'id'),
                'distance' => $db1,
                'bcsod' => '11111',
                'length' => '3',
                'buttonHidden' => $btnAccess = $db1 ? checkAccess($db2[0]->company_id, $db2[0]->region_id, $db2[0]->division_id) : '',
                'button' => ['save' => $buttons['save'], 'confirm' => $buttons['confirm'], 'delete' => $buttons['delete'], 'active' => $buttons['active']],
                'btn_active' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.btn active') : lang('app.btn inactive')),
                'active_by' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.inactive by') : lang('app.active by')),
            ];
            $msg = ['data' => view('main/asset/segment_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_segment', $this->request->getVar('unique'));
            $project = (isset($db1[0]->adaptation[0]) && $db1[0]->adaptation[0] == '1' ? $db1[0]->project_id : $this->request->getVar('project'));
            $branch = (isset($db1[0]->adaptation[0]) && $db1[0]->adaptation[0] == '1' ? $db1[0]->branch_id : $this->request->getVar('branch'));
            $segment = (isset($db1[0]->adaptation[0]) && $db1[0]->adaptation[0] == '1' ? $db1[0]->segment_id : $this->request->getVar('segment'));
            $ruleProject = (isset($db1[0]->adaptation[0]) && $db1[0]->adaptation[0] == '1' ? 'permit_empty' : 'required');
            $cekData = $this->mainModel->cekData('m_segment', 'code', $this->request->getVar('code2'), 'project_id', $project, $this->request->getVar('unique'));
            $ruleCode = ($cekData ? 'required|is_unique[m_segment.code]|min_length[8]' : 'required|min_length[8]');
            $project1 = $this->mainModel->getData('m_project', $project, '', 'id');
            $ruleAccess = checkAccess($project1[0]->company_id, $project1[0]->region_id, $project1[0]->division_id, 'save');
            $unique = $this->request->getVar('unique');

            $ruleLink = 'permit_empty';
            if ($this->request->getVar('postAction') == 'delete') {
                // if ($ruleLink !== 'required') cekLink('m_budget', 'branch_id', $db1[0]->id, $ruleLink);
            }

            $validationRules = [
                'code2' => [
                    'rules' => $ruleCode,
                    'errors' => ['required' => lang("app.err blank"), 'min_length' => lang("app.err length", [8]), 'is_unique' => lang("app.err unique")]
                ],
                'askDelete' => ['rules' => $ruleLink, 'errors' => ['required' => lang("app.err delete")]],
                'access' => ['rules' => $ruleAccess, 'errors' => ['required' => lang("app.err access")]],
                'description' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'branch' => ['rules' => $ruleProject, 'errors' => ['required' => lang("app.err select")]],
                'project' => ['rules' => $ruleProject, 'errors' => ['required' => lang("app.err select")]],
                'segment' => ['rules' => $ruleProject, 'errors' => ['required' => lang("app.err select")]],
                'distance' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'askDelete' => $this->validation->getError('askDelete'),
                        'access' => ['rules' => $ruleAccess, 'errors' => ['required' => lang("app.err access")]],
                        'code2' => $this->validation->getError('code2'),
                        'description' => $this->validation->getError('description'),
                        'distance' => $this->validation->getError('distance'),
                        'branch' => $this->validation->getError('branch'),
                        'project' => $this->validation->getError('project'),
                        'segment' => $this->validation->getError('segment'),
                    ]
                ];
            } else {
                // Save
                if ($this->request->getVar('postAction') == 'save') {
                    $adaptation = (empty($db1) ? '001' : $db1[0]->adaptation[0] . '0' . $db1[0]->adaptation[2]);
                    $title = (empty($db1) ? lang('app.title create') : lang('app.title edit'));
                    if ($unique == '') $unique = create_Unique();

                    $this->segmentModel->save([
                        'id' => $db1[0]->id ?? '',
                        'unique' => $unique,
                        'param' => 'subsegment',
                        'project_id' => $project,
                        'segment_id' => $segment,
                        'branch_id' => $branch,
                        'code' => strtoupper($this->request->getVar('code2')),
                        'name' => $this->request->getVar('description'),
                        'distance' => changeSeparator($this->request->getVar('distance')),
                        'notes' => $this->request->getVar('notes'),
                        'adaptation' => $adaptation,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $unique, strtoupper($this->request->getVar('code2')) . ' ; ' . $this->request->getVar('description'));
                    $this->session->setFlashdata(['message' => strtoupper($this->request->getVar('code2')) . ' ; ' . $this->request->getVar('description') . $title, 'flash-project' => $project]);
                }

                // Confirm
                if ($this->request->getVar('postAction') == 'confirm') {
                    $adaptation = '11' . $db1[0]->adaptation[2];
                    $this->segmentModel->save(['id' => $db1[0]->id, 'adaptation' => $adaptation, 'confirm_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $unique, "{$db1[0]->code} ; {$db1[0]->name}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name}" . lang("app.title confirm"), 'flash-project' => $db1[0]->project_id]);
                }

                // Delete
                if ($this->request->getVar('postAction') == 'delete') {
                    $this->segmentModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $unique, "{$db1[0]->code} ; {$db1[0]->name}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name}" . lang("app.title delete"), 'flash-project' => $db1[0]->project_id]);
                }

                // Active
                if ($this->request->getVar('postAction') == 'active') {
                    $result = $db1[0]->adaptation[2] == '1' ? ['0', 'inactive', lang("app.title inactive")] : ['1', 'active', lang("app.title active")];
                    $this->segmentModel->save(['id' => $db1[0]->id, 'adaptation' => substr($db1[0]->adaptation, 0, 2) . $result[0], 'active_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $unique, "{$db1[0]->code} ; {$db1[0]->name} {$result[1]}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name} {$result[2]}", 'flash-project' => $db1[0]->project_id]);
                }
                $msg = ['redirect' => '/subsegment'];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
