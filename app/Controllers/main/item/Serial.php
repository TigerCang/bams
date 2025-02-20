<?php

namespace App\Controllers\main\item;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\SerialModel;

class Serial extends BaseController
{
    protected $serialModel;
    public function __construct()
    {
        $this->serialModel = new SerialModel();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        checkPage('137');
        $data = [
            't_title' => lang('app.serial'),
            't_span' => lang('app.span serial'),
            'link' => base_url('serial'),
            'category' => $this->mainModel->distItem('m_item', 'category', 'param', 'material'),
            'serial' => $this->mainModel->getSerial($this->urls[1]),
        ];
        $this->render('main/item/serial_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_serial', $this->request->getVar('search'), 'u');
            checkPage('137', $db1, 'y', 'n');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, "{$db1[0]->serial}");

            $data = [
                't_modal' => lang('app.serial'),
                't_span' => lang('app.span serial'),
                'link' => base_url('serial'),
                'item1' => $this->mainModel->getData('m_tool', $db1[0]->item_id ?? '', '', 'id'),
                'tool1' => $this->mainModel->getData('m_tool', $db1[0]->tool_id ?? '', '', 'id'),
                'serial' => $db1,
                'button' => ['save' => $buttons['save'], 'confirm' => $buttons['confirm'], 'delete' => $buttons['delete'], 'active' => $buttons['active']],
                'btn_active' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.btn active') : lang('app.btn inactive')),
                'active_by' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.inactive by') : lang('app.active by')),
            ];
            $msg = ['data' => view('main/item/serial_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_serial', $this->request->getVar('unique'));
            $cekData = $this->mainModel->cekData('m_serial', 'serial', $this->request->getVar('serial'), '', '', $this->request->getVar('unique'));
            $ruleCode = ($cekData ? 'required|is_unique[m_serial.serial]' : 'required');
            $unique = $this->request->getVar('unique');

            $ruleLink = 'permit_empty';
            if ($this->request->getVar('postAction') == 'delete') {
                // $cekLink = $this->mainModel->cekLink('m_branch', 'company_id', $db1[0]->id);
            }

            $validationRules = [
                'askDelete' => ['rules' => $ruleLink, 'errors' => ['required' => lang("app.err delete")]],
                'serial' => ['rules' => $ruleCode, 'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unique")]],
                'item' => ['rules' => 'required', 'errors' => ['required' => lang("app.err select")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'askDelete' => $this->validation->getError('askDelete'),
                        'serial' => $this->validation->getError('serial'),
                        'item' => $this->validation->getError('item'),
                    ]
                ];
            } else {
                // Save
                if ($this->request->getVar('postAction') == 'save') {
                    $adaptation = (empty($db1) ? '001' : $db1[0]->adaptation[0] . '0' . $db1[0]->adaptation[2]);
                    $title = (empty($db1) ? lang('app.title create') : lang('app.title edit'));
                    if ($unique == '') $unique = create_Unique();

                    $this->serialModel->save([
                        'id' => $db1[0]->id ?? '',
                        'unique' => $unique,
                        'item_id' => $this->request->getVar('item'),
                        'serial' => strtoupper($this->request->getVar('serial')),
                        'price' => changeSeparator($this->request->getVar('price')),
                        'tool_id' => $this->request->getVar('tool'),
                        'repair' => $this->request->getVar('repair'),
                        'adaptation' => $adaptation,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $unique, strtoupper($this->request->getVar('serial')));
                    $this->session->setFlashdata(['message' => strtoupper($this->request->getVar('serial')) . $title, 'flash-item' => $this->request->getVar('part')]);
                }

                // Confirm
                if ($this->request->getVar('postAction') == 'confirm') {
                    $adaptation = '11' . $db1[0]->adaptation[2];
                    $this->serialModel->save(['id' => $db1[0]->id, 'adaptation' => $adaptation, 'confirm_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $unique, $db1[0]->serial);
                    $this->session->setFlashdata(['message' => $db1[0]->serial . lang("app.title confirm"), 'flash-item' => $db1[0]->item_id]);
                }

                // Delete
                if ($this->request->getVar('postAction') == 'delete') {
                    $this->serialModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $unique, $db1[0]->serial);
                    $this->session->setFlashdata(['message' => $db1[0]->serial . lang("app.title delete"), 'flash-item' => $db1[0]->item_id]);
                }

                // Active
                if ($this->request->getVar('postAction') == 'active') {
                    $result = $db1[0]->adaptation[2] == '1' ? ['0', 'inactive', lang("app.title inactive")] : ['1', 'active', lang("app.title active")];
                    $this->serialModel->save(['id' => $db1[0]->id, 'adaptation' => substr($db1[0]->adaptation, 0, 2) . $result[0], 'active_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $unique, "{$db1[0]->serial} {$result[1]}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->serial} {$result[2]}", 'flash-item' => $db1[0]->item_id]);
                }
                $msg = ['redirect' => '/serial'];
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
            $data = ['serial' => $this->mainModel->getSerial($this->urls[1], $this->request->getVar('item'))];
            $msg = ['data' => view('x-main/serial_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
