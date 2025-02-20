<?php

namespace App\Controllers\main\asset;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\ToolModel;

class Tool extends BaseController
{
    protected $toolModel;
    public function __construct()
    {
        $this->toolModel = new ToolModel();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        checkPage('132');
        $data = [
            't_title' => lang('app.tool'),
            't_span' => lang('app.span tool'),
            'link' => base_url('tool'),
            'company' => $this->mainModel->getCompany('', 't'),
            'selectCategory' => $this->mainModel->distItem('m_tool', 'category', 'param', 'tool'),
        ];
        $this->render('main/asset/tool_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        $db1 = $this->mainModel->getData('m_tool', $this->request->getVar('search'), 'u');
        checkPage('132', $db1, 'y');
        $buttons = setButton($db1);
        if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, "{$db1[0]->code} ; {$db1[0]->name}");

        $data = [
            't_title' => lang('app.tool'),
            't_span' => lang('app.span tool'),
            'link' => base_url('tool'),
            'company' => $this->mainModel->getCompany('', 't'),
            'region' => $this->mainModel->getFile('', 'region', 't'),
            'division' => $this->mainModel->getFile('', 'division', 't'),
            'selectTool' => $this->mainModel->distSelect('tool shape'),
            'selectDepreciation' => $this->mainModel->distSelect('depreciation'),
            'selectGroup' => $this->mainModel->loadGroupAccount('asset', 'equipment tool'),
            'standard1' => $this->mainModel->getData('m_standard', $db1[0]->standard_id ?? '', '', 'id'),
            'selectCategory' => $this->mainModel->distItem('m_tool', 'category', 'param', 'tool'),
            'selectType' => $this->mainModel->distItem('m_tool', 'type', 'param', 'tool'),
            'cost1' => $this->mainModel->getData('m_cost', $db1[0]->resource_id ?? '', '', 'id'),
            'tool' => $db1,
            'buttonHidden' => $btnAccess = $db1 ? checkAccess($db1[0]->company_id, $db1[0]->region_id, $db1[0]->division_id) : '',
            'button' => ['save' => $buttons['save'], 'confirm' => $buttons['confirm'], 'delete' => $buttons['delete'], 'active' => $buttons['active']],
            'btn_active' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.btn active') : lang('app.btn inactive')),
            'active_by' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.inactive by') : lang('app.active by')),
        ];
        $this->render('main/asset/tool_input', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_tool', $this->request->getVar('unique'));
            $cekData = $this->mainModel->cekData('m_tool', 'code', $this->request->getVar('code'), '', '', $this->request->getVar('unique'));
            $ruleCode = ($cekData ? 'required|is_unique[m_tool.code]|min_length[10]' : 'required|min_length[10]');
            $company = (isset($db1[0]->adaptation[0]) && $db1[0]->adaptation[0] == '1' ? $db1[0]->company_id : $this->request->getVar('company'));
            $region = (isset($db1[0]->adaptation[0]) && $db1[0]->adaptation[0] == '1' ? $db1[0]->region_id : $this->request->getVar('region'));
            $division = (isset($db1[0]->adaptation[0]) && $db1[0]->adaptation[0] == '1' ? $db1[0]->division_id : $this->request->getVar('division'));
            $ruleAccess = checkAccess($company, $region, $division, 'save');
            $unique = $this->request->getVar('unique');

            $ruleLink = 'permit_empty';
            if ($this->request->getVar('postAction') == 'delete') {
                // $cekLink = $this->mainModel->cekLink('m_branch', 'company_id', $db1[0]->id);
                // if ($cekLink) $ruleLink = 'required';
            }

            $validationRules = [
                'code' => [
                    'rules' => $ruleCode,
                    'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unique"), 'min_length' => lang("app.err length", [10])]
                ],
                'askDelete' => ['rules' => $ruleLink, 'errors' => ['required' => lang("app.err delete")]],
                'company' => ['rules' => $ruleAccess[0], 'errors' => ['valid_email' => lang("app.err access")]],
                'region' => ['rules' => $ruleAccess[1], 'errors' => ['valid_email' => lang("app.err access")]],
                'division' => ['rules' => $ruleAccess[2], 'errors' => ['valid_email' => lang("app.err access")]],
                'description' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'category' => ['rules' => 'required', 'errors' => ['required' => lang("app.err select")]],
                'cost' => ['rules' => 'required', 'errors' => ['required' => lang("app.err select")]],
                'picture' => [
                    'rules' => 'max_size[picture,1024]|is_image[picture]|mime_in[picture,image/jpg,image/jpeg,image/bmp,image/png]',
                    'errors' => ['max_size' => lang("app.err file1"), 'is_image' => lang("app.err notImage"), 'mime_in' => lang("app.err fileMime")]
                ],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'askDelete' => $this->validation->getError('askDelete'),
                        'company' => $this->validation->getError('company'),
                        'region' => $this->validation->getError('region'),
                        'division' => $this->validation->getError('division'),
                        'code' => $this->validation->getError('code'),
                        'description' => $this->validation->getError('description'),
                        'category' => $this->validation->getError('category'),
                        'cost' => $this->validation->getError('cost'),
                        'picture' => $this->validation->getError('picture'),
                    ]
                ];
            } else {
                // Save
                if ($this->request->getVar('postAction') == 'save') {
                    $adaptation = (empty($db1) ? '001' : $db1[0]->adaptation[0] . '0' . $db1[0]->adaptation[2]);
                    $title = (empty($db1) ? lang('app.title create') : lang('app.title edit'));
                    $file_picture = $this->request->getFile('picture');
                    $picture_name = ($file_picture->getError() == 4) ? $this->request->getVar('pictureName') : $file_picture->getName();
                    if ($file_picture->getError() != 4) $file_picture->move('assets/picture/tool/', $picture_name);
                    if ($this->request->getVar('pictureName') != 'default.png' && $file_picture->getError() != 4) unlink('assets/picture/tool/' . $this->request->getVar('pictureName'));
                    if ($unique == '') $unique = create_Unique();

                    $this->toolModel->save([
                        'id' => $db1[0]->id ?? '',
                        'unique' => $unique,
                        'param' => 'tool',
                        'code' => strtoupper($this->request->getVar('code')),
                        'name' => $this->request->getVar('description'),
                        'brand' => $this->request->getVar('brand'),
                        'category' => $this->request->getVar('category'),
                        'type' => $this->request->getVar('type'),
                        // 'pegawai_id' => $this->request->getVar('pegawai'),
                        'resource_id' => $this->request->getVar('cost'),
                        'standard_id' => $this->request->getVar('standard'),
                        'invoice' => $this->request->getVar('invoice'),
                        'purchase_date' => $this->request->getVar('purchaseDate'),
                        'purchase_value' => changeSeparator($this->request->getVar('purchaseValue')),
                        'rental_value' => changeSeparator($this->request->getVar('rentalValue')),
                        'company_id' => $company,
                        'region_id' => $region,
                        'division_id' => $division,
                        'picture' => $picture_name,
                        'notes' => $this->request->getVar('notes'),
                        'adaptation' => $adaptation,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $unique, strtoupper($this->request->getVar('code')) . ' ; ' . $this->request->getVar('description'));
                    $this->session->setFlashdata(['message' => strtoupper($this->request->getVar('code')) . ' ; ' . $this->request->getVar('description') . $title, 'flash-company' => $company, 'flash-category' => $this->request->getVar('category')]);
                }

                // Confirm
                if ($this->request->getVar('postAction') == 'confirm') {
                    $adaptation = '11' . $db1[0]->adaptation[2];
                    $this->toolModel->save(['id' => $db1[0]->id, 'adaptation' => $adaptation, 'confirm_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $unique, "{$db1[0]->code} ; {$db1[0]->name}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name}" . lang("app.title confirm"), 'flash-company' => $db1[0]->company_id, 'flash-category' => $db1[0]->category]);
                }

                // Delete
                if ($this->request->getVar('postAction') == 'delete') {
                    $this->toolModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $unique, "{$db1[0]->code} ; {$db1[0]->name}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name}" . lang("app.title delete"), 'flash-company' => $db1[0]->company_id, 'flash-category' => $db1[0]->category]);
                }

                // Active
                if ($this->request->getVar('postAction') == 'active') {
                    $result = $db1[0]->adaptation[2] == '1' ? ['0', 'inactive', lang("app.title inactive")] : ['1', 'active', lang("app.title active")];
                    $this->toolModel->save(['id' => $db1[0]->id, 'adaptation' => substr($db1[0]->adaptation, 0, 2) . $result[0], 'active_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $unique, "{$db1[0]->code} ; {$db1[0]->name} {$result[1]}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name} {$result[2]}", 'flash-company' => $db1[0]->company_id, 'flash-category' => $db1[0]->category]);
                }
                $msg = ['redirect' => '/tool'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
