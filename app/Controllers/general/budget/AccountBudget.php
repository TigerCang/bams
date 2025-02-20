<?php

namespace App\Controllers\general\budget;

use Config\App;
use App\Controllers\BaseController;
use App\Models\general\BudgetParentModel;
use App\Models\general\BudgetChild1Model;

class AccountBudget extends BaseController
{
    protected $BudgetParentModel;
    protected $BudgetChild1Model;
    public function __construct()
    {
        $this->budgetParentModel = new BudgetParentModel();
        $this->budgetChild1Model = new BudgetChild1Model();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        // checkPage('119');
        $data = [
            't_title' => lang('app.account budget'),
            't_span' => lang('app.span account budget'),
            'link' => base_url('accountbudget'),
            'selectObject' => $this->mainModel->distSelect('object'),
            'choice' => 'object',
        ];
        $this->render('general/budget/budget_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        $db1 = $this->mainModel->getData('budget_parent', $this->request->getVar('search'));
        $table = (isset($db1[0]) ? ($db1[0]->object == 'equipment tool' ? 'm_tool' : ($db1[0]->object == 'land building' ? 'm_land' : 'm_branch')) : 'm_branch');
        // checkPage('119', $db1);
        $buttons = transButton($db1, $db1[0]->status ?? '0');
        // if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, "{$db1[0]->title}");

        $data = [
            't_title' => lang('app.account budget'),
            't_span' => lang('app.span account budget'),
            'link' => base_url('accountbudget'),
            'company' => $this->mainModel->getCompany('', 't'),
            'region' => $this->mainModel->getFile('', 'region', 't'),
            'division' => $this->mainModel->getFile('', 'division', 't'),
            'selectSource' => $this->mainModel->distSelect('set budget'),
            'selectObject' => $this->mainModel->distSelect('object'),
            'selectAction' => $this->mainModel->distSelect('action'),
            'type' => $this->mainModel->distinctCost('indirect cost'),
            'choice' => 'object',
            'object1' => $this->mainModel->getData($table, $db1[0]->object_id ?? '', '', 'id'),
            'budget' => $db1,
            'button' => ['on' => $buttons['on'], 'off' => $buttons['off']],
            'card' => ['input' => '', 'acc' => 'hidden'],
        ];
        $this->render('general/budget/accountBudget_input', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function addData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('budget_parent', $this->request->getVar('unique'));
            $company = (isset($db1[0]->status) && $db1[0]->status != '0' ? $db1[0]->company_id : $this->request->getVar('company'));
            $region = (isset($db1[0]->status) && $db1[0]->status != '0' ? $db1[0]->region_id : $this->request->getVar('region'));
            $division = (isset($db1[0]->status) && $db1[0]->status != '0' ? $db1[0]->division_id : $this->request->getVar('division'));
            $branch = (isset($db1[0]->status) && $db1[0]->status != '0' ? $db1[0]->object_id : $this->request->getVar('branch'));
            $ruleAccess = checkAccess($company, $region, $division, 'save');
            $ruleBranch = ($branch ? 'permit_empty' : 'required');
            if ($ruleBranch == 'permit_empty') $ruleBranch = checkObject($this->request->getVar('xObject'), $branch);
            $unique = $this->request->getVar('unique');
            $ruleBudget = checkBudget($this->request->getVar('xSource'), $this->request->getVar('xObject'), $branch, '', $this->request->getVar('revisionNumber'), $unique);

            $validationRules = [
                // 'askAccess' => ['rules' => $ruleBudget, 'errors' => ['required' => lang("app.err delete")]],
                'company' => ['rules' => $ruleAccess[0], 'errors' => ['valid_email' => lang("app.err access")]],
                'region' => ['rules' => $ruleAccess[1], 'errors' => ['valid_email' => lang("app.err access")]],
                'division' => ['rules' => $ruleAccess[2], 'errors' => ['valid_email' => lang("app.err access")]],
                'branch' => ['rules' => $ruleBranch, 'errors' => ['required' => lang("app.err select"), 'valid_email' => lang("app.err access")]],
                'account' => ['rules' => 'required', 'errors' => ['required' => lang("app.err select")]],
                'total' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'askAccess' => $this->validation->getError('askAccess'),
                        'company' => $this->validation->getError('company'),
                        'region' => $this->validation->getError('region'),
                        'division' => $this->validation->getError('division'),
                        'branch' => $this->validation->getError('branch'),
                        'account' => $this->validation->getError('account'),
                        'total' => $this->validation->getError('total'),
                    ]
                ];
            } else {
                // Save
                if ($unique == '') $unique = create_Unique('120');
                if (empty($db1)) {
                    $this->budgetParentModel->save([
                        'unique' =>  $unique,
                        'source' =>  $this->request->getVar('xSource'),
                        'object' =>  $this->request->getVar('xObject'),
                        'company_id' => $this->request->getVar('company'),
                        'region_id' => $this->request->getVar('region'),
                        'division_id' => $this->request->getVar('division'),
                        'object_id' => $branch,
                        'date_start' => $this->request->getVar('startDate'),
                        'date_end' => $this->request->getVar('endDate'),
                    ]);
                }

                $dbParent = $this->mainModel->getData('budget_parent', $unique);
                $this->budgetChild1Model->save([
                    'unique' =>  create_Unique('120'),
                    'parent_id' => $dbParent[0]->id,
                    'account_id' => $this->request->getVar('account'),
                    'month' => changeSeparator($this->request->getVar('month')),
                    'quantity' => changeSeparator($this->request->getVar('quantity')),
                    'price_contract' => changeSeparator($this->request->getVar('price')),
                    'total_contract' => changeSeparator($this->request->getVar('total')),
                    'notes' => $this->request->getVar('notes'),
                ]);
                $insertedId = $this->budgetChild1Model->getInsertID();
                $this->budgetChild1Model->update($insertedId, ['budget_id' => $insertedId]);

                $db4 = $this->mainModel->getParentCost('account', $this->request->getVar('account'));
                $cekLevel3 = $this->transModel->cekBudgetChild($dbParent[0]->id, 'account_id', $db4[0]->idLevel3);
                if ($cekLevel3) {
                    $total3 = $this->transModel->budgetTotal('account', $dbParent[0]->id, $db4[0]->idLevel3);
                    $this->budgetChild1Model->save(['id' => $cekLevel3[0]->id, 'total_contract' => $total3[0]->totalcontract]);
                    $this->mainModel->updateDeletedAt('budget_child1', $cekLevel3[0]->id);
                } else {
                    $this->budgetChild1Model->save([
                        'parent_id' => $dbParent[0]->id,
                        'account_id' => $db4[0]->idLevel3,
                        'total_contract' => changeSeparator($this->request->getVar('total')),
                    ]);
                }

                $cekLevel2 = $this->transModel->cekBudgetChild($dbParent[0]->id, 'account_id', $db4[0]->idLevel2);
                if ($cekLevel2) {
                    $total2 = $this->transModel->budgetTotal('account', $dbParent[0]->id, $db4[0]->idLevel2);
                    $this->budgetChild1Model->save(['id' => $cekLevel2[0]->id, 'total_contract' => $total2[0]->totalcontract]);
                    $this->mainModel->updateDeletedAt('budget_child1', $cekLevel2[0]->id);
                } else {
                    $this->budgetChild1Model->save([
                        'parent_id' => $dbParent[0]->id,
                        'account_id' => $db4[0]->idLevel2,
                        'total_contract' => changeSeparator($this->request->getVar('total')),
                    ]);
                }

                $cekLevel1 = $this->transModel->cekBudgetChild($dbParent[0]->id, 'account_id', $db4[0]->idLevel1);
                if ($cekLevel1) {
                    $total1 = $this->transModel->budgetTotal('account', $dbParent[0]->id, $db4[0]->idLevel1);
                    $this->budgetChild1Model->save(['id' => $cekLevel1[0]->id, 'total_contract' => $total1[0]->totalcontract]);
                    $this->mainModel->updateDeletedAt('budget_child1', $cekLevel1[0]->id);
                } else {
                    $this->budgetChild1Model->save([
                        'parent_id' => $dbParent[0]->id,
                        'account_id' => $db4[0]->idLevel1,
                        'total_contract' => changeSeparator($this->request->getVar('total')),
                        'level' => '1',
                    ]);
                }

                if ($this->request->getVar('unique') == '') {
                    $msg = [
                        'redirect' => '/accountbudget/input?search=' . $unique,
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
            $db1 = $this->mainModel->getData('budget_parent', $this->request->getVar('unique'));
            $company = ($db1[0]->status == '0' ? $this->request->getVar('company') : $db1[0]->company_id);
            $region = ($db1[0]->status == '0' ? $this->request->getVar('region') : $db1[0]->region_id);
            $division = ($db1[0]->status == '0' ? $this->request->getVar('division') : $db1[0]->division_id);
            $branch = ($db1[0]->status == '0' ? $this->request->getVar('branch') : $db1[0]->object_id);

            $validationRules = [
                'branch' => ['rules' => 'required', 'errors' => ['required' => lang("app.err select")]],
                'startDate' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'endDate' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'branch' => $this->validation->getError('branch'),
                        'startDate' => $this->validation->getError('startDate'),
                        'endDate' => $this->validation->getError('endDate'),
                    ]
                ];
            } else {
                // Save
                if ($this->request->getVar('postAction') == 'save') {
                    $docNumber = $this->request->getVar('documentNumber');
                    if ($docNumber == '') {
                        $initial = initialCode('account budget', $company, $region, $division);
                        $db = $this->transModel->getDocumentNumber('budget_parent', $initial ?? '', "-" . substr($this->request->getVar('startDate'), 2, 2));
                        $number = ($db ? substr($db[0]->document_number, -4) + 1 : '1');
                        $docNumber = createDocumentNumber($initial, $this->request->getVar('startDate'), $number);
                    };

                    $this->budgetParentModel->save([
                        'id' =>  $db1[0]->id,
                        'object' =>  $this->request->getVar('xObject'),
                        'company_id' => $company,
                        'region_id' => $region,
                        'division_id' => $division,
                        'object_id' => $branch,
                        'document_number' => $docNumber,
                        'date_start' =>  $this->request->getVar('startDate'),
                        'date_end' =>  $this->request->getVar('endDate'),
                        'level' => userLevel(),
                        'status' => '1', // save
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $db1[0]->unique, $docNumber);
                    $this->session->setFlashdata(['message' => $docNumber . lang('app.title save')]);
                }
                $msg = ['redirect' => '/accountbudget'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function importData()
    {
        if ($this->request->isAJAX()) {
            $data = [
                't_modal' => lang('app.import data'),
                'budget' => $this->mainModel->getBudget('', 'mi', $this->request->getVar('source'), $this->request->getVar('object')),
                'link' => $this->request->getVar('link'),
            ];
            $msg = ['data' => view('x-general/importBudget_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function modalData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('budget_child1', $this->request->getVar('uniq'));
            $data = [
                't_modal' => lang('app.account budget'),
                'budget' => $db1,
                'parent1' => $this->mainModel->getData('budget_parent', $db1[0]->parent_id ?? '', '', 'id'),
                'cost1' => $this->mainModel->getData('m_cost', $db1[0]->cost_id ?? '', '', 'id'),
                'account1' => $this->mainModel->getData('m_account', $db1[0]->account_id ?? '', '', 'id'),
                'from' => 'account',
                'link' => $this->request->getVar('link'),
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
            $db2 = $this->mainModel->getData('budget_child1', $this->request->getVar('mUnique'));
            $dbParent = $this->mainModel->getData('budget_parent', $db2[0]->parent_id, '', 'id');
            $this->budgetChild1Model->save([
                'id' => $db2[0]->id,
                'month' => changeSeparator($this->request->getVar('mMonth')),
                'quantity' => changeSeparator($this->request->getVar('mQuantity')),
                'price_contract' =>  changeSeparator($this->request->getVar('mPrice')),
                'total_contract' => changeSeparator($this->request->getVar('mTotal')),
                'notes' => $this->request->getVar('mNotes'),
            ]);

            $db4 = $this->mainModel->getParentCost('account', $db2[0]->account_id);
            $cekLevel3 = $this->transModel->cekBudgetChild($dbParent[0]->id, 'account_id', $db4[0]->idLevel3);
            $total3 = $this->transModel->budgetTotal('account', $dbParent[0]->id, $db4[0]->idLevel3);
            $this->budgetChild1Model->save(['id' => $cekLevel3[0]->id, 'total_contract' => $total3[0]->totalcontract]);
            $this->mainModel->updateDeletedAt('budget_child1', $cekLevel3[0]->id);

            $cekLevel2 = $this->transModel->cekBudgetChild($dbParent[0]->id, 'account_id', $db4[0]->idLevel2);
            $total2 = $this->transModel->budgetTotal('account', $dbParent[0]->id, $db4[0]->idLevel2);
            $this->budgetChild1Model->save(['id' => $cekLevel2[0]->id, 'total_contract' => $total2[0]->totalcontract]);
            $this->mainModel->updateDeletedAt('budget_child1', $cekLevel2[0]->id);

            $cekLevel1 = $this->transModel->cekBudgetChild($dbParent[0]->id, 'account_id', $db4[0]->idLevel1);
            $total1 = $this->transModel->budgetTotal('account', $dbParent[0]->id, $db4[0]->idLevel1);
            $this->budgetChild1Model->save(['id' => $cekLevel1[0]->id, 'total_contract' => $total1[0]->totalcontract]);
            $this->mainModel->updateDeletedAt('budget_child1', $cekLevel1[0]->id);

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
            $db2 = $this->mainModel->getData('budget_child1', $this->request->getVar('unique'));
            $dbParent = $this->mainModel->getData('budget_parent', $db2[0]->parent_id, '', 'id');
            $this->budgetChild1Model->delete($db2[0]->id);
            $db4 = $this->mainModel->getParentCost('account', $db2[0]->account_id);

            $cekLevel3 = $this->transModel->cekBudgetChild($dbParent[0]->id, 'account_id', $db4[0]->idLevel3);
            $total3 = $this->transModel->budgetTotal('account', $dbParent[0]->id, $db4[0]->idLevel3);
            $nTotal3 = (!empty($total3) ? $total3[0]->totalcontract : '0');
            $this->budgetChild1Model->save(['id' => $cekLevel3[0]->id, 'total_contract' => $nTotal3]);
            if ($nTotal3 == '0') $this->budgetChild1Model->delete($cekLevel3[0]->id);

            $cekLevel2 = $this->transModel->cekBudgetChild($dbParent[0]->id, 'account_id', $db4[0]->idLevel2);
            $total2 = $this->transModel->budgetTotal('account', $dbParent[0]->id, $db4[0]->idLevel2);
            $nTotal2 = (!empty($total2) ? $total2[0]->totalcontract : '0');
            $this->budgetChild1Model->save(['id' => $cekLevel2[0]->id, 'total_contract' => $nTotal2]);
            if ($nTotal2 == '0') $this->budgetChild1Model->delete($cekLevel2[0]->id);

            $cekLevel1 = $this->transModel->cekBudgetChild($dbParent[0]->id, 'account_id', $db4[0]->idLevel1);
            $total1 = $this->transModel->budgetTotal('account', $dbParent[0]->id, $db4[0]->idLevel1);
            $nTotal1 = (!empty($total1) ? $total1[0]->totalcontract : '0');
            $this->budgetChild1Model->save(['id' => $cekLevel1[0]->id, 'total_contract' => $nTotal1]);
            if ($nTotal1 == '0') $this->budgetChild1Model->delete($cekLevel1[0]->id);

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
                'link' => $this->request->getVar('link'),
                'budget' => $this->transModel->getBudgetChild($this->request->getVar('unique'), $this->request->getVar('object')),
                'object' => $this->request->getVar('object'),
            ];
            $msg = ['data' => view('x-general/accountBudget_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
