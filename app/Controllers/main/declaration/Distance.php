<?php

namespace App\Controllers\main\declaration;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\SegmentModel;

class Distance extends BaseController
{
    protected $segmentModel;
    public function __construct()
    {
        $this->segmentModel = new SegmentModel();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        checkPage('116');
        $data = [
            't_title' => lang('app.distance'),
            't_span' => lang('app.span distance'),
            'link' => base_url('distance'),
            'filter' => 'hidden',
            'bcd' => '001',
            'project1' => [],
        ];
        $this->render('main/asset/segment_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_segment', $this->request->getVar('search'), 'u');
            checkPage('116', $db1, 'y', 'n');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, "{$db1[0]->code} ; {$db1[0]->name}");

            $data = [
                't_modal' => lang('app.distance'),
                'link' => base_url('distance'),
                'branch1' => [],
                'project1' => [],
                'distance' => $db1,
                'bcsod' => '00001',
                'length' => '6',
                'buttonHidden' => '',
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

    // _________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_segment', $this->request->getVar('unique'));
            $cekData = $this->mainModel->cekData('m_segment', 'code', $this->request->getVar('code'), 'param', 'distance', $this->request->getVar('unique'));
            $ruleCode = ($cekData ? 'required|is_unique[m_segment.code]|min_length[6]' : 'required|min_length[6]');
            $unique = $this->request->getVar('unique');

            $ruleLink = 'permit_empty';
            if ($this->request->getVar('postAction') == 'delete') {
                // if ($ruleLink !== 'required') cekLink('m_budget', 'branch_id', $db1[0]->id, $ruleLink);
            }

            $validationRules = [
                'code' => [
                    'rules' => $ruleCode,
                    'errors' => ['required' => lang("app.err blank"), 'min_length' => lang("app.err length", [6]), 'is_unique' => lang("app.err unique")]
                ],
                'askDelete' => ['rules' => $ruleLink, 'errors' => ['required' => lang("app.err delete")]],
                'description' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'distance' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'askDelete' => $this->validation->getError('askDelete'),
                        'code' => $this->validation->getError('code'),
                        'description' => $this->validation->getError('description'),
                        'distance' => $this->validation->getError('distance'),
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
                        'param' => 'distance',
                        'code' => strtoupper($this->request->getVar('code')),
                        'name' => $this->request->getVar('description'),
                        'distance' => changeSeparator($this->request->getVar('distance')),
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
                    $this->segmentModel->save(['id' => $db1[0]->id, 'adaptation' => $adaptation, 'confirm_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $unique, "{$db1[0]->code} ; {$db1[0]->name}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name}" . lang("app.title confirm")]);
                }

                // Delete
                if ($this->request->getVar('postAction') == 'delete') {
                    $this->segmentModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $unique, "{$db1[0]->code} ; {$db1[0]->name}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name}" . lang("app.title delete")]);
                }

                // Active
                if ($this->request->getVar('postAction') == 'active') {
                    $result = $db1[0]->adaptation[2] == '1' ? ['0', 'inactive', lang("app.title inactive")] : ['1', 'active', lang("app.title active")];
                    $this->segmentModel->save(['id' => $db1[0]->id, 'adaptation' => substr($db1[0]->adaptation, 0, 2) . $result[0], 'active_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $unique, "{$db1[0]->code} ; {$db1[0]->name} {$result[1]}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name} {$result[2]}"]);
                }
                $msg = ['redirect' => '/distance'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
