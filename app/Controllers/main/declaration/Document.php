<!-- <php

namespace App\Controllers\main\asset;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\DocumentModel;

class Document extends BaseController
{
    protected $documentModel;
    public function __construct()
    {
        $this->documentModel = new DocumentModel();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        checkPage('119');
        $data = [
            't_title' => lang('app.document'),
            't_span' => lang('app.span document'),
            'link' => '/document',
            'company' => $this->mainModel->getCompany('', 't'),
            'region' => $this->mainModel->getFile('', 'region', 't'),
            'division' => $this->mainModel->getFile('', 'division', 't'),
            'selectObject' => $this->mainModel->distSelect('object'),
        ];
        $this->render('main/asset/document_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_document', $this->request->getVar('search'), 'u');
            checkPage('119', $db1, 'y', 'n');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $this->request->getVar('search'), $db1[0]->name);

            $data = [
                't_modal' => lang('app.document'),
                'link' => "/document",
                'company' => $this->mainModel->getCompany('', 't'),
                'region' => $this->mainModel->getFile('', 'region', 't'),
                'division' => $this->mainModel->getFile('', 'division', 't'),
                'selectObject' => $this->mainModel->distSelect('object'),
                'document' => $db1,
                'button' => ['save' => $buttons['save'], 'confirm' => $buttons['confirm'], 'delete' => $buttons['delete'], 'active' => $buttons['active']],
                'btn_active' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.btn active') : lang('app.btn inactive')),
                'active_by' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.inactive by') : lang('app.active by')),
            ];
            $msg = ['data' => view('main/asset/document_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_document', $this->request->getVar('unique'));
            $cekData = $this->mainModel->cekData('m_document', 'name', $this->request->getVar('description'), '', '', $this->request->getVar('unique'));
            $ruleName = ($cekData ? 'required|is_unique[m_document.name]' : 'required');
            $company = (isset($db1[0]->adaptation[0]) && $db1[0]->adaptation[0] == '1' ? $db1[0]->company_id : $this->request->getVar('company'));
            $region = (isset($db1[0]->adaptation[0]) && $db1[0]->adaptation[0] == '1' ? $db1[0]->region_id : $this->request->getVar('region'));
            $division = (isset($db1[0]->adaptation[0]) && $db1[0]->adaptation[0] == '1' ? $db1[0]->division_id : $this->request->getVar('division'));
            $ruleDate = ($this->request->getVar('startDate') == '' ? 'valid_email' : 'permit_empty');
            $ruleAccess = checkAccess($company, $region, $division, 'save');
            $unique = $this->request->getVar('unique');

            $validationRules = [
                'access' => ['rules' => $ruleAccess, 'errors' => ['required' => lang("app.err access")]],
                'title' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'description' => ['rules' => $ruleName, 'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unique")]],
                'startDate' => ['rules' => $ruleDate, 'errors' => ['valid_email' => lang("app.err invalid")]],
                'attachment' => [
                    'rules' => 'uploaded[attachment]|max_size[attachment,20480]|ext_in[attachment,pdf]',
                    'errors' => ['uploaded' => lang("app.err blank"), 'max_size' => lang("app.err file20"), 'ext_in' => lang("app.err fileExt")]
                ]
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'access' => $this->validation->getError('access'),
                        'title' => $this->validation->getError('title'),
                        'description' => $this->validation->getError('description'),
                        'attachment' => $this->validation->getError('attachment'),
                    ]
                ];
            } else {
                // Save
                if ($this->request->getVar('postAction') == 'save') {
                    $adaptation = (empty($db1) ? '001' : $db1[0]->adaptation[0] . '0' . $db1[0]->adaptation[2]);
                    $title = (empty($db1) ? lang('app.title create') : lang('app.title edit'));
                    $attachment = $this->request->getFile('attachment');
                    $attachment->move('assets/attachment/' . $this->request->getVar('object'));
                    $attachment_name = $attachment->getName();
                    $object = $this->request->getVar('object');
                    if ($unique == '') $unique = create_Unique();

                    $this->documentModel->save([
                        'id' => $db1[0]->id ?? '',
                        'unique' => $unique,
                        'company_id' => $company,
                        'region_id' => $region,
                        'division_id' => $division,
                        'object' => $this->request->getVar('object'),
                        'object_id' => $this->request->getVar('objectID'),
                        'title' => $this->request->getVar('title'),
                        'name' => $this->request->getVar('description'),
                        'start_date' => $this->request->getVar('startDate'),
                        'end_date' => $this->request->getVar('endDate'),
                        'attachment' => $attachment_name,
                        'adaptation' => $adaptation,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $unique, $this->request->getVar('description'));
                    $this->session->setFlashdata(['message' => $this->request->getVar('description') . $title, 'flash-object' => $object]);
                }

                // Confirm
                if ($this->request->getVar('postAction') == 'confirm') {
                    $adaptation = '11' . $db1[0]->adaptation[2];
                    $this->documentModel->save(['id' => $db1[0]->id, 'adaptation' => $adaptation, 'confirm_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $unique, $db1[0]->name);
                    $this->session->setFlashdata(['message' => $db1[0]->name . lang("app.title confirm"), 'flash-object' => $db1[0]->object]);
                }

                // Delete
                if ($this->request->getVar('postAction') == 'delete') {
                    $this->documentModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $unique, $db1[0]->name);
                    $this->session->setFlashdata(['message' => $db1[0]->name . lang("app.title delete"), 'flash-object' => $db1[0]->object]);
                }

                // Active
                if ($this->request->getVar('postAction') == 'active') {
                    $result = $db1[0]->adaptation[2] == '1' ? ['0', 'inactive', lang("app.title inactive")] : ['1', 'active', lang("app.title active")];
                    $this->documentModel->save(['id' => $db1[0]->id, 'adaptation' => substr($db1[0]->adaptation, 0, 2) . $result[0], 'active_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $unique, "{$db1[0]->name} {$result[1]}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->name} {$result[2]}", 'flash-object' => $db1[0]->object]);
                }
                $msg = ['redirect' => '/document'];
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
            $object = ($this->request->getVar('object') != '' ? $this->request->getVar('object') : 'XYZ');
            $data = ['document' => $this->mainModel->getDocument($this->urls[1], $object, $this->request->getVar('isi'))];
            $msg = ['data' => view('x-main/document_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function outFocusObject()
    {
        if ($this->request->isAJAX()) {
            $object = $this->request->getVar('object');
            $objectID = $this->request->getVar('objectID');
            $map = [
                'project' => 'm_project',
                'branch' => 'm_branch',
                'equipment tool' => 'm_tool',
                'land building' => 'm_land',
                'employee' => 'm_person',
            ];
            $table = $map[$object] ?? null;
            $db1 = $this->mainModel->getData($table, $objectID ?? '', '', 'id');
            $msg = ['company' => $db1[0]->company_id ?? '', 'region' => $db1[0]->region_id ?? '', 'division' => $db1[0]->division_id ?? ''];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
} -->