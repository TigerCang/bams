<?php

namespace App\Controllers\main\item;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\itemModel;

class Item extends BaseController
{
    protected $itemModel;
    public function __construct()
    {
        $this->itemModel = new ItemModel();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        checkPage('135');
        $data = [
            't_title' => lang('app.item'),
            't_span' => lang('app.span item'),
            'link' => '/item',
            'pHid' => 'hidden',
            'sHid' => '',
            'category' => $this->mainModel->distItem('m_item', 'category', 'param', 'item'),
        ];
        $this->render('main/item/item_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_item', $this->request->getVar('search'), 'u');
            checkPage('135', $db1, 'y', 'n');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, "{$db1[0]->code} ; {$db1[0]->name}");

            $data = [
                't_modal' => lang('app.item'),
                'link' => "/item",
                'brand' => $this->mainModel->distItem('m_item', 'brand'),
                'selectGroup' => $this->mainModel->loadGroupAccount('stock', 'item'),
                'unit' => $this->mainModel->getFile('', 'unit', 't'),
                'category' => $this->mainModel->distItem('m_item', 'category', 'param', 'item'),
                'item' => $db1,
                'button' => ['save' => $buttons['save'], 'confirm' => $buttons['confirm'], 'delete' => $buttons['delete'], 'active' => $buttons['active']],
                'btn_active' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.btn active') : lang('app.btn inactive')),
                'active_by' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.inactive by') : lang('app.active by')),
            ];
            $msg = ['data' => view('main/item/item_input', $data)];
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
            $cekData = $this->mainModel->cekData('m_item', 'code', $this->request->getVar('code'), '', '', $this->request->getVar('unique'));
            $ruleCode = ($cekData ? 'required|is_unique[m_item.code]' : 'required');
            $unique = $this->request->getVar('unique');

            $ruleLink = 'permit_empty';
            if ($this->request->getVar('postAction') == 'delete') {
                // $cekLink = $this->mainModel->cekLink('m_branch', 'company_id', $db1[0]->id);
                // if ($cekLink) $ruleLink = 'required';
            }

            $validationRules = [
                'askDelete' => ['rules' => $ruleLink, 'errors' => ['required' => lang("app.err delete")]],
                'code' => ['rules' => $ruleCode, 'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unique")]],
                'description' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
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
                        'code' => $this->validation->getError('code'),
                        'description' => $this->validation->getError('description'),
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
                    $groupAccount = $this->request->getVar('stock') == 'on' ? $this->request->getVar('groupAccount') : '';
                    $mode = implode('', [$this->request->getVar('serial') == 'on' ? '1' : '0', $this->request->getVar('second') == 'on' ? '1' : '0', $this->request->getVar('stock') == 'on' ? '1' : '0']);
                    if ($unique == '') $unique = create_Unique();

                    $this->itemModel->save([
                        'id' => $db1[0]->id ?? '',
                        'unique' => $unique,
                        'param' => 'item',
                        'code' => strtoupper($this->request->getVar('code')),
                        'part_number' => $this->request->getVar('partNumber'),
                        'name' => $this->request->getVar('description'),
                        'category' => $this->request->getVar('category'),
                        'brand' => $this->request->getVar('brand'),
                        'unit' => $this->request->getVar('unit'),
                        'group_account' => $groupAccount,
                        'min_stock' => $this->request->getVar('stockMin'),
                        'mode' => $mode,
                        'picture' => $picture_name,
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
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name} {$result[2]}", 'flash-category' => $db1[0]->category]);
                }
                $msg = ['redirect' => '/item'];
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
            $data = [
                'item' => $this->mainModel->getItem($this->urls[1], 'item', $this->request->getVar('category')),
                'pHid' => 'hidden',
                'sHid' => '',
            ];
            $msg = ['data' => view('x-main/item_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
