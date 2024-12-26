<?php

namespace App\Controllers\trcash\expense;

use Config\App;
use App\Controllers\BaseController;
use App\Models\trcash\CashParentModel;
use App\Models\trcash\CashChild1Model;

class Directcash extends BaseController
{
    protected $CashParentModel;
    protected $CashChild1Model;

    public function __construct()
    {
        $this->cashparentModel = new CashParentModel();
        $this->cashchild1Model = new CashChild1Model();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        // checkPage('119');
        $data = [
            't_title' => lang('app.direct cash'),
            't_span' => lang('app.span direct cash'),
            'link' => '/directcash',
            // 'cash' => $this->transModel->getCash($this->urls[1]),
        ];
        $this->render('trcash/expense/request_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        $db1 = $this->mainModel->getData('cash_parent', $this->request->getVar('search'));
        $table = (isset($db1[0]) ? ($db1[0]->object == 'project' ? 'm_project' : ($db1[0]->object == 'equipment tool' ? 'm_tool' : ($db1[0]->object == 'land building' ? 'm_land' : 'm_branch'))) : 'm_branch');
        // checkPage('119', $db1);
        $buttons = transButton($db1, '1', $db1[0]->status ?? '0');
        // if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, "{$db1[0]->title}");

        $data = [
            't_title' => lang('app.direct cash'),
            't_span' => lang('app.span direct cash'),
            'link' => "/directcash",
            'company' => $this->mainModel->getCompany('', 't'),
            'region' => $this->mainModel->getFile('', 'region', 't'),
            'division' => $this->mainModel->getFile('', 'division', 't'),
            'selectSource' => $this->mainModel->distSelect('set budget'),
            'selectObject' => $this->mainModel->distSelect('object'),
            'type' => $this->mainModel->distinctCost('indirect cost'),
            'choice' => 'object',
            'object1' => $this->mainModel->getData($table, $db1[0]->object_id ?? '', '', 'id'),
            'requester1' => $this->mainModel->loadUser(decrypt(session()->username), $db1[0]->request_by ?? '', '1'),
            'cash' => $db1,
            'button' => ['hidden' => $buttons['hidden'], 'disabled' => $buttons['disabled']],
        ];
        $this->render('trcash/expense/directCash_input', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('cash_parent', $this->request->getVar('unique'));
            $object = (isset($db1[0]->status) && $db1[0]->status != '0' ? $db1[0]->object_id : $this->request->getVar('branch'));
            $ruleBranch = $object ? 'permit_empty' : 'required';
            $company = (isset($db1[0]->status) && $db1[0]->status != '0' ? $db1[0]->company_id : $this->request->getVar('company'));
            $region = (isset($db1[0]->status) && $db1[0]->status != '0' ? $db1[0]->region_id : $this->request->getVar('region'));
            $division = (isset($db1[0]->status) && $db1[0]->status != '0' ? $db1[0]->division_id : $this->request->getVar('division'));
            $ruleAccess = checkAccess($company, $region, $division, 'save');
            if ($ruleBranch == 'permit_empty') $ruleBranch = checkObject($this->request->getVar('xObject'), $object);
            $ruleDoc = checkDocumentCode('document', 'advance payment');
            $unique = $this->request->getVar('unique');

            $validationRules = [
                'askDoc' => ['rules' => $ruleDoc, 'errors' => ['required' => lang("app.err document")]],
                'company' => ['rules' => $ruleAccess[0], 'errors' => ['valid_email' => lang("app.err access")]],
                'region' => ['rules' => $ruleAccess[1], 'errors' => ['valid_email' => lang("app.err access")]],
                'division' => ['rules' => $ruleAccess[2], 'errors' => ['valid_email' => lang("app.err access")]],
                'branch' => ['rules' => $ruleBranch, 'errors' => ['required' => lang("app.err select"), 'valid_email' => lang("app.err access")]],
                'requester' => ['rules' => 'required', 'errors' => ['required' => lang("app.err select")]],
                'person' => ['rules' => 'required', 'errors' => ['required' => lang("app.err select")]],
                'account' => ['rules' => 'required', 'errors' => ['required' => lang("app.err select")]],
                'total' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'attachment' => [
                    'rules' => 'max_size[attachment,20480]|ext_in[attachment,pdf]',
                    'errors' => ['max_size' => lang("app.err file20"), 'ext_in' => lang("app.err fileExt")]
                ]
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'askDoc' => $this->validation->getError('askDoc'),
                        'company' => $this->validation->getError('company'),
                        'region' => $this->validation->getError('region'),
                        'division' => $this->validation->getError('division'),
                        'branch' => $this->validation->getError('branch'),
                        'requester' => $this->validation->getError('requester'),
                        'person' => $this->validation->getError('person'),
                        'account' => $this->validation->getError('account'),
                        'total' => $this->validation->getError('total'),
                        'attachment' => $this->validation->getError('attachment'),
                    ]
                ];
            } else {
                // Save
                if ($unique == '') $unique = create_Unique('120');
                if ($this->request->getVar('postAction') == 'save') {
                    $docNumber = $this->request->getVar('documentNumber');
                    if ($docNumber == '') {
                        $initial = initialCode('advance payment', $company, $region, $division);
                        $db = $this->transModel->getDocumentNumber('cash_parent', $initial ?? '', "-" . substr($this->request->getVar('dateDay'), 2, 2));
                        $number = ($db ? substr($db[0]->document_number, -4) + 1 : '1');
                        $docNumber = createDocumentNumber($initial, $this->request->getVar('dateDay'), $number);
                    };
                    $revision = '1';
                    $attachment = $this->request->getFile('attachment');
                    //     $picture_name = ($file_picture->getError() == 4) ? $this->request->getVar('pictureName') : $file_picture->getName();
                    //    if ($attachment->getError() != 4) $attachment->move('assets/attachment/tool/', $picture_name);
                    $attachment_name = $attachment->getName();

                    //     $file_picture = $this->request->getFile('picture');
                    //     $picture_name = ($file_picture->getError() == 4) ? $this->request->getVar('pictureName') : $file_picture->getName();
                    //     if ($this->request->getVar('pictureName') != 'default.png' && $file_picture->getError() != 4) unlink('assets/picture/tool/' . $this->request->getVar('pictureName'));


                    $this->cashparentModel->save([
                        'id' =>  $db1[0]->id,
                        'unique' =>  $unique,
                        'source' =>  'advance payment',
                        'object' =>  $this->request->getVar('xObject'),
                        'company_id' => $this->request->getVar('company'),
                        'region_id' => $this->request->getVar('region'),
                        'division_id' => $this->request->getVar('division'),
                        'object_id' => $this->request->getVar('branch'),
                        'document_number' => $docNumber,
                        'person_id' => $this->request->getVar('person'),
                        'date_request' =>  $this->request->getVar('DateDay'),
                        'revision' => $revision,
                        'level' => $this->user['act_approve'] . ',' . $this->user['act_approve'],
                        'status' => '1', // save
                        'is_ok' => '000',
                        'is_tax' => '0',
                        'attachment' => $attachment_name,
                        'request_by' =>  $this->request->getVar('requester'),
                        'save_by' => $this->user['id'],
                    ]);

                    $this->cashchild1Model->save([
                        'id' =>  $db1[0]->id,
                        'unique' =>  $unique,
                        'source' =>  'advance payment',
                        'object' =>  $this->request->getVar('xObject'),
                        'company_id' => $this->request->getVar('company'),
                        'region_id' => $this->request->getVar('region'),
                        'division_id' => $this->request->getVar('division'),
                        'object_id' => $this->request->getVar('branch'),
                        'document_number' => $docNumber,
                        'person_id' => $this->request->getVar('person'),
                        'date_request' =>  $this->request->getVar('DateDay'),
                        'revision' => $revision,
                        'level' => $this->user['act_approve'] . ',' . $this->user['act_approve'],
                        'status' => '1', // save
                        'is_ok' => '000',
                        'is_tax' => '0',
                        'attachment' => $attachment_name,
                        'request_by' =>  $this->request->getVar('requester'),
                        'save_by' => $this->user['id'],
                    ]);
                }

                // Cancel
                if ($this->request->getVar('postAction') == 'cancel') {
                    $this->cashparentModel->save(['id' => $db1[0]->id, 'status' => '6']);
                    $this->logModel->saveLog('Cancel', $unique, $docNumber);
                    $this->session->setFlashdata(['message' => $docNumber . lang("app.title cancel"), 'flash-company' => $db1[0]->company_id, 'flash-category' => $db1[0]->category]);
                }
                $msg = ['redirect' => '/advancepayment'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function tableAP()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'budget' => $this->transModel->getBudgetChild($this->request->getVar('unique'), $this->request->getVar('object')),
                'object' => $this->request->getVar('object'),
            ];
            $msg = ['data' => view('x-cash/accountBudget_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    public function tableCash()
    {
        if ($this->request->isAJAX()) {
            $data = [
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
