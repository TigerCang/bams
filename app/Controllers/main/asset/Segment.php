<?php

namespace App\Controllers\main\asset;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\SegmentModel;

class Segment extends BaseController
{
    protected $segmentModel;
    public function __construct()
    {
        $this->segmentModel = new SegmentModel();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        checkPage('129');
        $data = [
            't_title' => lang('app.segment'),
            't_span' => lang('app.span segment'),
            'link' => '/segment',
            'filter' => '',
            'bcd' => '010',
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
            checkPage('129', $db2, 'y', 'n');
            $buttons = setButton($db1);
            // if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, "{$db1[0]->code} ; {$db1[0]->name}");

            $data = [
                't_modal' => lang('app.segment'),
                'link' => "/segment",
                'branch1' => [],
                'project1' => $this->mainModel->getData('m_project', $db1[0]->project_id ?? '', '', 'id'),
                'distance' => $db1,
                'bcsod' => '01000', //branch company segment code2 distance
                'length' => '4',
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

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_segment', $this->request->getVar('unique'));
            $project = (isset($db1[0]->adaptation[0]) && $db1[0]->adaptation[0] == '1' ? $db1[0]->project_id : $this->request->getVar('project'));
            $ruleProject = (isset($db1[0]->adaptation[0]) && $db1[0]->adaptation[0] == '1' ? 'permit_empty' : 'required');
            $cekData = $this->mainModel->cekData('m_segment', 'code', $this->request->getVar('code'), 'project_id', $project, $this->request->getVar('unique'));
            $ruleCode = ($cekData ? 'required|is_unique[m_segment.code]|min_length[4]' : 'required|min_length[4]');
            $project1 = $this->mainModel->getData('m_project', $project, '', 'id');
            $ruleAccess = checkAccess($project1[0]->company_id, $project1[0]->region_id, $project1[0]->division_id, 'save');
            $unique = $this->request->getVar('unique');

            $ruleLink = 'permit_empty';
            if ($this->request->getVar('postAction') == 'delete') {
                // if ($ruleLink !== 'required') cekLink('m_budget', 'branch_id', $db1[0]->id, $ruleLink);
                // $cekLink = $this->mainModel->cekLink('m_branch', 'company_id', $db1[0]->id);
            }

            $validationRules = [
                'code' => [
                    'rules' => $ruleCode,
                    'errors' => ['required' => lang("app.err blank"), 'min_length' => lang("app.err length", [4]), 'is_unique' => lang("app.err unique")]
                ],
                'askDelete' => ['rules' => $ruleLink, 'errors' => ['required' => lang("app.err delete")]],
                'access' => ['rules' => $ruleAccess, 'errors' => ['required' => lang("app.err access")]],
                'description' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'project' => ['rules' => $ruleProject, 'errors' => ['required' => lang("app.err select")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'askDelete' => $this->validation->getError('askDelete'),
                        'access' => $this->validation->getError('access'),
                        'code' => $this->validation->getError('code'),
                        'description' => $this->validation->getError('description'),
                        'project' => $this->validation->getError('project'),
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
                        'param' => 'segment',
                        'project_id' => $project,
                        'code' => strtoupper($this->request->getVar('code')),
                        'name' => $this->request->getVar('description'),
                        'notes' => $this->request->getVar('notes'),
                        'adaptation' => $adaptation,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $unique, strtoupper($this->request->getVar('code')) . ' ; ' . $this->request->getVar('description'));
                    $this->session->setFlashdata(['message' => strtoupper($this->request->getVar('code')) . ' ; ' . $this->request->getVar('description') . $title, 'flash-project' => $project]);
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
                $msg = ['redirect' => '/segment'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function outFocusProject()
    {
        if ($this->request->isAJAX()) {
            $project = $this->request->getVar('project') != '' ? $this->request->getVar('project') : 'XYZ';
            $project1 = $this->mainModel->getData('m_project', $project, '', 'id');
            $company1 = $this->mainModel->getData('m_company', $project1[0]->company_id ?? '', '', 'id');
            $region1 = $this->mainModel->getData('m_file', $project1[0]->region_id ?? '', '', 'id');
            $segment = $this->mainModel->getSegment('', 'segment', 't', $project);

            $sSegment = $this->request->getVar('segment');
            $segmentData = "";
            foreach ($segment as $db) :
                $choose = "";
                if ($db->id == $sSegment) $choose = 'selected';
                $segmentData .= '<option value="' . $db->id . '" data-code="' . $db->code . '" data-subtext="' . $db->name . '" ' . $choose . '>' . $db->code . '</option>';
            endforeach;
            $msg = ['company' => $company1[0]->code ?? '', 'region' => $region1[0]->name ?? '', 'segment' => $segmentData];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
