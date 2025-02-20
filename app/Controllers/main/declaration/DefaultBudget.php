<?php

namespace App\Controllers\main\declaration;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\Budget1Model;
use App\Models\main\Budget2Model;

class DefaultBudget extends BaseController
{
    protected $budget1Model;
    protected $budget2Model;
    public function __construct()
    {
        $this->budget1Model = new Budget1Model();
        $this->budget2Model = new Budget2Model();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        checkPage('120');
        $data = [
            't_title' => lang('app.default budget'),
            't_span' => lang('app.span default budget'),
            'link' => base_url('defaultbudget'),
            'budget' => $this->mainModel->getBudget($this->urls[1]),
        ];
        $this->render('main/declaration/defaultBudget_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        $db1 = $this->mainModel->getData('m_budget1', $this->request->getVar('search'), 'u');
        checkPage('120', $db1, 'y', 'n');
        $buttons = (isset($db1[0]) && $db1[0]->adaptation[1] == 'a' ? setButton($db1, '1') : setButton($db1));
        if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, "{$db1[0]->title}");

        $data = [
            't_title' => lang('app.default budget'),
            't_span' => lang('app.span default budget'),
            'link' => base_url('defaultbudget'),
            'selectSource' => $this->mainModel->distSelect('set budget'),
            'selectObject' => $this->mainModel->distSelect('object'),
            'type' => $this->mainModel->distinctCost('indirect cost'),
            'budget' => $db1,
            'button' => ['save' => $buttons['save'], 'confirm' => $buttons['confirm'], 'delete' => $buttons['delete'], 'active' => $buttons['active']],
            'btn_active' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.btn active') : lang('app.btn inactive')),
            'active_by' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.inactive by') : lang('app.active by')),
        ];
        $this->render('main/declaration/defaultBudget_input', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function addData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_budget1', $this->request->getVar('unique'));
            $cekData = $this->mainModel->cekData('m_budget1', 'title', $this->request->getVar('title'), '', '', $this->request->getVar('unique'));
            $ruleTitle = ($cekData ? 'required|valid_email' : 'required');
            $object = $this->request->getVar('xObject');
            $ruleCost = ($object == 'project' ? 'required' : 'permit_empty');
            $ruleAccount = ($object != 'project' ? 'required' : 'permit_empty');
            $ruleSource = ($object == 'project' && $this->request->getVar('xSource') == 'income' ? 'valid_email' : 'permit_empty');
            $type = ($object == 'project' ? $this->request->getVar('xType') : '');
            $unique = $this->request->getVar('unique');

            $validationRules = [
                'source' => ['rules' => $ruleSource, 'errors' => ['valid_email' => lang("app.err invalid")]],
                'title' => ['rules' => $ruleTitle, 'errors' => ['required' => lang("app.err blank"), 'valid_email' => lang("app.err unique")]],
                'cost' => ['rules' => $ruleCost, 'errors' => ['required' => lang("app.err select")]],
                'account' => ['rules' => $ruleAccount, 'errors' => ['required' => lang("app.err select")]],
                'total' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'source' => $this->validation->getError('source'),
                        'title' => $this->validation->getError('title'),
                        'cost' => $this->validation->getError('cost'),
                        'account' => $this->validation->getError('account'),
                        'total' => $this->validation->getError('total'),
                    ]
                ];
            } else {
                if ($unique == '') $unique = create_Unique();
                $adaptation = (empty($db1) ? '021' : $db1[0]->adaptation[0] . '2' . $db1[0]->adaptation[2]);
                $this->budget1Model->save([
                    'id' => (!empty($db1) ? $db1[0]->id : null),
                    'unique' => $unique,
                    'title' => $this->request->getVar('title'),
                    'source' => $this->request->getVar('xSource'),
                    'object' => $object,
                    'type' => $type,
                    'adaptation' => $adaptation,
                ]);

                $dbParent = $this->mainModel->getData('m_budget1', $unique);
                $this->budget2Model->save([
                    'unique' => create_Unique(),
                    'parent_id' => $dbParent[0]->id,
                    'cost_id' => $this->request->getVar('cost') ?? '',
                    'account_id' => $this->request->getVar('account') ?? '',
                    'month' => changeSeparator($this->request->getVar('month')),
                    'quantity' => changeSeparator($this->request->getVar('quantity')),
                    'price' =>  changeSeparator($this->request->getVar('price')),
                    'total' => changeSeparator($this->request->getVar('total')),
                    'notes' => $this->request->getVar('notes'),
                ]);

                $nField = ($object == 'project' ? 'cost' : 'account');
                $nID = ($object == 'project' ? 'cost_id' : 'account_id');
                $db4 = $this->mainModel->getParentCost($nField, $this->request->getVar($nField));
                $cekLevel3 = $this->mainModel->cekBudget($dbParent[0]->id, $nID, $db4[0]->idLevel3);
                if ($cekLevel3) {
                    $total3 = $this->mainModel->budgetTotal($nField, $dbParent[0]->id, $db4[0]->idLevel3);
                    $this->budget2Model->save(['id' => $cekLevel3[0]->id, 'total' => $total3[0]->subtotal]);
                    $this->mainModel->updateDeletedAt('m_budget2', $cekLevel3[0]->id);
                } else {
                    $this->budget2Model->save([
                        'parent_id' => $dbParent[0]->id,
                        $nID => $db4[0]->idLevel3,
                        'total' => changeSeparator($this->request->getVar('total')),
                    ]);
                }

                $cekLevel2 = $this->mainModel->cekBudget($dbParent[0]->id, $nID, $db4[0]->idLevel2);
                if ($cekLevel2) {
                    $total2 = $this->mainModel->budgetTotal($nField, $dbParent[0]->id, $db4[0]->idLevel2);
                    $this->budget2Model->save(['id' => $cekLevel2[0]->id, 'total' => $total2[0]->subtotal]);
                    $this->mainModel->updateDeletedAt('m_budget2', $cekLevel2[0]->id);
                } else {
                    $this->budget2Model->save([
                        'parent_id' => $dbParent[0]->id,
                        $nID => $db4[0]->idLevel2,
                        'total' => changeSeparator($this->request->getVar('total')),
                    ]);
                }

                $cekLevel1 = $this->mainModel->cekBudget($dbParent[0]->id, $nID, $db4[0]->idLevel1);
                if ($cekLevel1) {
                    $total1 = $this->mainModel->budgetTotal($nField, $dbParent[0]->id, $db4[0]->idLevel1);
                    $this->budget2Model->save(['id' => $cekLevel1[0]->id, 'total' => $total1[0]->subtotal]);
                    $this->mainModel->updateDeletedAt('m_budget2', $cekLevel1[0]->id);
                } else {
                    $this->budget2Model->save([
                        'parent_id' => $dbParent[0]->id,
                        $nID => $db4[0]->idLevel1,
                        'total' => changeSeparator($this->request->getVar('total')),
                        'level' => '1',
                    ]);
                }

                if ($this->request->getVar('unique') == '') {
                    $msg = [
                        'redirect' => '/defaultbudget/input?search=' . $unique,
                        'message' => "{$db4[0]->name}" . lang('app.title add'),
                    ];
                } else {
                    $msg = ['message' => "{$db4[0]->name}" . lang('app.title add')];
                }
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_budget1', $this->request->getVar('unique'));
            $cekData = $this->mainModel->cekData('m_budget1', 'title', $this->request->getVar('title'), '', '', $this->request->getVar('unique'));
            $ruleTitle = ($cekData ? 'required|valid_email' : 'required');
            $ruleSave = ($db1 ? 'permit_empty' : 'required');

            $validationRules = [
                'askSave' => ['rules' => $ruleSave, 'errors' => ['required' => lang("app.err save")]],
                'title' => ['rules' => $ruleTitle, 'errors' => ['required' => lang("app.err blank"), 'valid_email' => lang("app.err unique")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'askSave' => $this->validation->getError('askSave'),
                        'title' => $this->validation->getError('title'),
                    ]
                ];
            } else {
                // Save
                if ($this->request->getVar('postAction') == 'save') {
                    $adaptation = $db1[0]->adaptation[0] . '0' . $db1[0]->adaptation[2];
                    $this->budget1Model->save([
                        'id' => $db1[0]->id,
                        'title' => $this->request->getVar('title'),
                        'adaptation' => $adaptation,
                        'save_by' => $this->user['id']
                    ]);
                    $this->logModel->saveLog('Save', $db1[0]->unique, "{$this->request->getVar('title')}");
                    $this->session->setFlashdata(['message' => "{$this->request->getVar('title')}" . lang("app.title save")]);
                }

                // Confirm
                if ($this->request->getVar('postAction') == 'confirm') {
                    $adaptation = '11' . $db1[0]->adaptation[2];
                    $this->budget1Model->save(['id' => $db1[0]->id, 'adaptation' => $adaptation, 'confirm_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $db1[0]->unique, "{$db1[0]->title}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->title}" . lang("app.title confirm")]);
                }

                // Delete
                if ($this->request->getVar('postAction') == 'delete') {
                    $this->budget1Model->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $db1[0]->unique, "{$db1[0]->title}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->title}" . lang("app.title delete")]);
                }

                // Active
                if ($this->request->getVar('postAction') == 'active') {
                    $result = $db1[0]->adaptation[2] == '1' ? ['0', 'inactive', lang("app.title inactive")] : ['1', 'active', lang("app.title active")];
                    $this->budget1Model->save(['id' => $db1[0]->id, 'adaptation' => substr($db1[0]->adaptation, 0, 2) . $result[0], 'active_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $db1[0]->unique, "{$db1[0]->title} {$result[1]}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->title} {$result[2]}"]);
                }
                $msg = ['redirect' => '/defaultbudget'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function modalData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_budget2', $this->request->getVar('uniq'));
            $data = [
                't_modal' => lang('app.default budget'),
                'budget' => $db1,
                'parent1' => $this->mainModel->getData('m_budget1', $db1[0]->parent_id ?? '', '', 'id'),
                'cost1' => $this->mainModel->getData('m_cost', $db1[0]->cost_id ?? '', '', 'id'),
                'account1' => $this->mainModel->getData('m_account', $db1[0]->account_id ?? '', '', 'id'),
                'from' => 'default',
                'link' => base_url('defaultbudget'),
            ];
            $msg = ['data' => view('x-modal/defaultBudget_edit', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function updateData()
    {
        if ($this->request->isAJAX()) {
            $db2 = $this->mainModel->getData('m_budget2', $this->request->getVar('mUnique'));
            $dbParent = $this->mainModel->getData('m_budget1', $db2[0]->parent_id, '', 'id');
            $this->budget2Model->save([
                'id' => $db2[0]->id,
                'month' => changeSeparator($this->request->getVar('mMonth')),
                'quantity' => changeSeparator($this->request->getVar('mQuantity')),
                'price' =>  changeSeparator($this->request->getVar('mPrice')),
                'total' => changeSeparator($this->request->getVar('mTotal')),
                'notes' => $this->request->getVar('mNotes'),
            ]);

            $nField = ($dbParent[0]->object == 'project' ? 'cost' : 'account');
            $nID = ($dbParent[0]->object == 'project' ? 'cost_id' : 'account_id');
            $number = ($dbParent[0]->object == 'project' ? $db2[0]->cost_id : $db2[0]->account_id);
            $db4 = $this->mainModel->getParentCost($nField, $number);

            $cekLevel3 = $this->mainModel->cekBudget($dbParent[0]->id, $nID, $db4[0]->idLevel3);
            $total3 = $this->mainModel->budgetTotal($nField, $dbParent[0]->id, $db4[0]->idLevel3);
            $this->budget2Model->save(['id' => $cekLevel3[0]->id, 'total' => $total3[0]->subtotal]);
            $this->mainModel->updateDeletedAt('m_budget2', $cekLevel3[0]->id);

            $cekLevel2 = $this->mainModel->cekBudget($dbParent[0]->id, $nID, $db4[0]->idLevel2);
            $total2 = $this->mainModel->budgetTotal($nField, $dbParent[0]->id, $db4[0]->idLevel2);
            $this->budget2Model->save(['id' => $cekLevel2[0]->id, 'total' => $total2[0]->subtotal]);
            $this->mainModel->updateDeletedAt('m_budget2', $cekLevel2[0]->id);

            $cekLevel1 = $this->mainModel->cekBudget($dbParent[0]->id, $nID, $db4[0]->idLevel1);
            $total1 = $this->mainModel->budgetTotal($nField, $dbParent[0]->id, $db4[0]->idLevel1);
            $this->budget2Model->save(['id' => $cekLevel1[0]->id, 'total' => $total1[0]->subtotal]);
            $this->mainModel->updateDeletedAt('m_budget2', $cekLevel1[0]->id);

            $msg = ['message' => "{$db4[0]->name}" . lang('app.title edit')];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function deleteData()
    {
        if ($this->request->isAJAX()) {
            $db2 = $this->mainModel->getData('m_budget2', $this->request->getVar('unique'));
            $dbParent = $this->mainModel->getData('m_budget1', $db2[0]->parent_id, '', 'id');
            $this->budget2Model->delete($db2[0]->id);
            $nField = ($dbParent[0]->object == 'project' ? 'cost' : 'account');
            $nID = ($dbParent[0]->object == 'project' ? 'cost_id' : 'account_id');
            $number = ($dbParent[0]->object == 'project' ? $db2[0]->cost_id : $db2[0]->account_id);
            $db4 = $this->mainModel->getParentCost($nField, $number);

            $cekLevel3 = $this->mainModel->cekBudget($dbParent[0]->id, $nID, $db4[0]->idLevel3);
            $total3 = $this->mainModel->budgetTotal($nField, $dbParent[0]->id, $db4[0]->idLevel3);
            $nTotal3 = (!empty($total3) ? $total3[0]->subtotal : '0');
            $this->budget2Model->save(['id' => $cekLevel3[0]->id, 'total' => $nTotal3]);
            if ($nTotal3 == '0') $this->budget2Model->delete($cekLevel3[0]->id);

            $cekLevel2 = $this->mainModel->cekBudget($dbParent[0]->id, $nID, $db4[0]->idLevel2);
            $total2 = $this->mainModel->budgetTotal($nField, $dbParent[0]->id, $db4[0]->idLevel2);
            $nTotal2 = (!empty($total2) ? $total2[0]->subtotal : '0');
            $this->budget2Model->save(['id' => $cekLevel2[0]->id, 'total' => $nTotal2]);
            if ($nTotal2 == '0') $this->budget2Model->delete($cekLevel2[0]->id);

            $cekLevel1 = $this->mainModel->cekBudget($dbParent[0]->id, $nID, $db4[0]->idLevel1);
            $total1 = $this->mainModel->budgetTotal($nField, $dbParent[0]->id, $db4[0]->idLevel1);
            $nTotal1 = (!empty($total1) ? $total1[0]->subtotal : '0');
            $this->budget2Model->save(['id' => $cekLevel1[0]->id, 'total' => $nTotal1]);
            if ($nTotal1 == '0') $this->budget2Model->delete($cekLevel1[0]->id);

            $msg = ['message' => "{$db4[0]->name}" . lang('app.title delete')];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function tableData()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'link' => base_url('defaultbudget'),
                'budget' => $this->mainModel->getBudget('', '0', $this->request->getVar('unique'), $this->request->getVar('object')),
                'object' => $this->request->getVar('object'),
            ];
            $msg = ['data' => view('x-main/defaultBudget_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
