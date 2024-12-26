<?php

namespace App\Controllers\main\item;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\itemModel;

class Material extends BaseController
{
    protected $itemModel;
    public function __construct()
    {
        $this->itemModel = new ItemModel();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        checkPage('136');
        $data = [
            't_title' => lang('app.material'),
            't_span' => lang('app.span material'),
            'link' => '/material',
            'pHid' => '',
            'sHid' => 'hidden',
            'category' => $this->mainModel->distItem('m_item', 'category', 'param', 'material'),
        ];
        $this->render('main/item/item_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_item', $this->request->getVar('search'), 'u');
            checkPage('136', $db1, 'y', 'n');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, "{$db1[0]->code} ; {$db1[0]->name}");

            $data = [
                't_modal' => lang('app.material'),
                'link' => "/material",
                'selectGroup' => $this->mainModel->loadGroupAccount('stock', 'material'),
                'category' => $this->mainModel->distItem('m_item', 'category', 'param', 'material'),
                'cost1' => $this->mainModel->getData('m_cost', $db1[0]->resource_id ?? '', '', 'id'),
                'item' => $db1,
                'button' => ['save' => $buttons['save'], 'confirm' => $buttons['confirm'], 'delete' => $buttons['delete'], 'active' => $buttons['active']],
                'btn_active' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.btn active') : lang('app.btn inactive')),
                'active_by' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.inactive by') : lang('app.active by')),
            ];
            $msg = ['data' => view('main/item/material_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_item', $this->request->getVar('unique'));
            $dbCost = $this->mainModel->getData('m_cost', $this->request->getVar('cost'), '', 'id');
            $cekData = $this->mainModel->cekData('m_item', 'code', $dbCost[0]->code ?? '', '', '', $this->request->getVar('unique'));
            $ruleCode = ($cekData ? 'required|is_unique[m_item.code]' : 'required');
            $unique = $this->request->getVar('unique');

            $ruleLink = 'permit_empty';
            if ($this->request->getVar('postAction') == 'delete') {
                // $cekLink = $this->mainModel->cekLink('m_branch', 'company_id', $db1[0]->id);
            }

            $validationRules = [
                'askDelete' => ['rules' => $ruleLink, 'errors' => ['required' => lang("app.err delete")]],
                'cost' => ['rules' => $ruleCode, 'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unique")]],
                'category' => ['rules' => 'required', 'errors' => ['required' => lang("app.err select")]],
                'picture' => [
                    'rules' => 'max_size[picture,1024]|is_image[picture]|mime_in[picture,image/jpg,image/jpeg,image/bmp,image/png]',
                    'errors' => ['max_size' => lang("app.err file1"), 'is_image' => lang("app.err notImage"), 'mime_in' => lang("app.err fileMime")]
                ],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'askDelete' => $this->validation->getError('askDelete'),
                        'cost' => $this->validation->getError('cost'),
                        'category' => $this->validation->getError('category'),
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
                    if ($file_picture->getError() != 4) $file_picture->move('assets/picture/item/', $picture_name);
                    if ($this->request->getVar('pictureName') != 'default.png' && $file_picture->getError() != 4) unlink('assets/picture/item/' . $this->request->getVar('pictureName'));
                    if ($unique == '') $unique = create_Unique();

                    $this->itemModel->save([
                        'id' => $db1[0]->id ?? '',
                        'unique' => $unique,
                        'param' => 'material',
                        'code' => $dbCost[0]->code,
                        'resource_id' => $this->request->getVar('cost'),
                        'name' => $dbCost[0]->name,
                        'category' => $this->request->getVar('category'),
                        'unit' => $this->request->getVar('unit'),
                        'group_account' => $this->request->getVar('groupAccount'),
                        'price' => changeSeparator($this->request->getVar('price')),
                        'picture' => $picture_name,
                        'notes' => $this->request->getVar('notes'),
                        'adaptation' => $adaptation,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $unique, "{$dbCost[0]->code} ; {$dbCost[0]->name}");
                    $this->session->setFlashdata(['message' => "{$dbCost[0]->code} ; {$dbCost[0]->name}" . $title, 'flash-category' => $this->request->getVar('category')]);
                }

                // Confirm
                if ($this->request->getVar('postAction') == 'confirm') {
                    $adaptation = '11' . $db1[0]->adaptation[2];
                    $this->itemModel->save(['id' => $db1[0]->id, 'adaptation' => $adaptation, 'confirm_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $unique, "{$db1[0]->code} ; {$db1[0]->name}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name}" . lang("app.title confirm"), 'flash-category' => $db1[0]->category]);
                }

                // Delete
                if ($this->request->getVar('postAction') == 'delete') {
                    $this->itemModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $unique, "{$db1[0]->code} ; {$db1[0]->name}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name}" . lang("app.title delete"), 'flash-category' => $db1[0]->category]);
                }

                // Active
                if ($this->request->getVar('postAction') == 'active') {
                    $result = $db1[0]->adaptation[2] == '1' ? ['0', 'inactive', lang("app.title inactive")] : ['1', 'active', lang("app.title active")];
                    $this->itemModel->save(['id' => $db1[0]->id, 'adaptation' => substr($db1[0]->adaptation, 0, 2) . $result[0], 'active_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $unique, "{$db1[0]->code} ; {$db1[0]->name} {$result[1]}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name} {$result[2]}",  'flash-category' => $db1[0]->category]);
                }
                $msg = ['redirect' => '/material'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
