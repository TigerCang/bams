<?php

namespace App\Controllers\main\declaration;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\Company1Model;
use App\Models\main\Company2Model;
use App\Models\main\Company3Model;

class Company extends BaseController
{
    protected $company1Model;
    protected $company2Model;
    protected $company3Model;
    public function __construct()
    {
        $this->company1Model = new Company1Model();
        $this->company2Model = new Company2Model();
        $this->company3Model = new Company3Model();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        checkPage('108');
        $data = [
            't_title' => lang('app.company'),
            't_span' => lang('app.span company'),
            'link' => '/company',
            'pHid' => 'hidden',
            'cNew' => '',
            'company' => $this->mainModel->getCompany($this->urls[1]),
        ];
        // return $this->response->setJSON($data['company']);
        $this->render('main/declaration/company_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        $db1 = $this->mainModel->getData('m_company', $this->request->getVar('search'), 'u');
        $dbPrice = $this->mainModel->getCompanyPerson($db1[0]->id ?? '', 'share');
        checkPage('108', $db1, 'y', 'n');
        $buttons = setButton($db1);
        if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, "{$db1[0]->code} ; {$db1[0]->name}");

        $data = [
            't_title' => lang('app.company'),
            't_span' => lang('app.span company'),
            'link' => "/company",
            'company' => $db1,
            'priceStock' => $dbPrice[0]->price ?? '0',
            'button' => ['save' => $buttons['save'], 'confirm' => $buttons['confirm'], 'delete' => $buttons['delete'], 'active' => $buttons['active']],
            'btn_active' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.btn active') : lang('app.btn inactive')),
            'active_by' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.inactive by') : lang('app.active by')),
        ];
        $this->render('main/declaration/company_input', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_company', $this->request->getVar('unique'));
            $cekData = $this->mainModel->cekData('m_company', 'code', $this->request->getVar('code'), '', '', $this->request->getVar('unique'));
            $ruleCode = ($cekData ? 'required|is_unique[m_company.code]' : 'required');
            $unique = $this->request->getVar('unique');

            $ruleLink = 'permit_empty';
            if ($this->request->getVar('postAction') == 'delete') {
                if ($ruleLink !== 'required') cekLink('m_branch', 'company_id', $db1[0]->id, $ruleLink);
                if ($ruleLink !== 'required') cekLink('m_project', 'company_id', $db1[0]->id, $ruleLink);
                if ($ruleLink !== 'required') cekLink('m_tool', 'company_id', $db1[0]->id, $ruleLink);
                if ($ruleLink !== 'required') cekLink('m_land', 'company_id', $db1[0]->id, $ruleLink);
                if ($ruleLink !== 'required') cekLink('m_person', 'company_id', $db1[0]->id, $ruleLink);
            }

            $validationRules = [
                'askDelete' => ['rules' => $ruleLink, 'errors' => ['required' => lang("app.err delete")]],
                'code' => ['rules' => $ruleCode, 'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unique")]],
                'initial' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'description' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
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
                        'initial' => $this->validation->getError('initial'),
                        'description' => $this->validation->getError('description'),
                        'picture' => $this->validation->getError('picture')
                    ]
                ];
            } else {
                // Save
                if ($this->request->getVar('postAction') == 'save') {
                    $adaptation = (empty($db1) ? '001' : $db1[0]->adaptation[0] . '0' . $db1[0]->adaptation[2]);
                    $title = (empty($db1) ? lang('app.title create') : lang('app.title edit'));
                    $file_picture = $this->request->getFile('picture');
                    $picture_name = ($file_picture->getError() == 4) ? $this->request->getVar('pictureName') : $file_picture->getName();
                    if ($file_picture->getError() != 4) $file_picture->move('assets/picture/company/', $picture_name);
                    if ($this->request->getVar('pictureName') != 'default.png' && $file_picture->getError() != 4) unlink('assets/picture/company/' . $this->request->getVar('pictureName'));
                    if ($unique == '') $unique = create_Unique();

                    $this->company1Model->save([
                        'id' => $db1[0]->id ?? '',
                        'unique' => $unique,
                        'code' => $this->request->getVar('code'),
                        'initial' => strtoupper($this->request->getVar('initial')),
                        'name' => $this->request->getVar('description'),
                        'law1' => $this->request->getVar('law1'),
                        'law2' => $this->request->getVar('law2'),
                        'picture' => $picture_name,
                        'is_tax' => ($this->request->getVar('tax') == 'on' ? '1' : '0'),
                        'adaptation' => $adaptation,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $unique, "{$this->request->getVar('code')} ; {$this->request->getVar('description')}");
                    $this->session->setFlashdata(['message' => "{$this->request->getVar('code')} ; {$this->request->getVar('description')} {$title}"]);
                }

                // Confirm
                if ($this->request->getVar('postAction') == 'confirm') {
                    $adaptation = '11' . $db1[0]->adaptation[2];
                    $this->company1Model->save(['id' => $db1[0]->id, 'adaptation' => $adaptation, 'confirm_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $unique, "{$db1[0]->code} ; {$db1[0]->name}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name}" . lang("app.title confirm")]);
                }

                // Delete
                if ($this->request->getVar('postAction') == 'delete') {
                    $this->company1Model->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $unique, "{$db1[0]->code} ; {$db1[0]->name}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name}" . lang("app.title delete")]);
                }

                // Active
                if ($this->request->getVar('postAction') == 'active') {
                    $result = $db1[0]->adaptation[2] == '1' ? ['0', 'inactive', lang("app.title inactive")] : ['1', 'active', lang("app.title active")];
                    $this->company1Model->save(['id' => $db1[0]->id, 'adaptation' => substr($db1[0]->adaptation, 0, 2) . $result[0], 'active_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $unique, "{$db1[0]->code} ; {$db1[0]->name} {$result[1]}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->code} ; {$db1[0]->name} {$result[2]}"]);
                }
                $msg = ['redirect' => '/company'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputModal($number)
    {
        if ($this->request->isAJAX()) {
            if ($number == '1') {
                $companyInput = 'company_input1';
                $titleModal = lang('app.company') . ' - ' . lang('app.address');
            } else if ($number == '2') {
                $companyInput = 'company_input2';
                $titleModal = lang('app.company') . ' - ' . lang('app.person');
            } else if ($number == '3') {
                $companyInput = 'company_input3';
                $titleModal = lang('app.company') . ' - ' . lang('app.share');
            }
            $data = [
                't_modal' => $titleModal,
                'link' => "/company",
                'unique' => $this->request->getVar('unique'),
                'price' => $this->request->getVar('price'),
            ];
            $msg = ['data' => view('x-modal/' . $companyInput, $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveModal($number)
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_company', $this->request->getVar('unique'));
            $company = $db1[0]->id;
            if ($number == '1') { // Address
                $validationRules = ['address' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]]];
                if (!$this->validate($validationRules)) {
                    $msg = ['error' => ['address' => $this->validation->getError('address')]];
                } else {
                    $this->company2Model->save([
                        'unique' => create_Unique(),
                        'company_id' => $company,
                        'status' => $this->request->getVar('status'),
                        'address' => $this->request->getVar('address'),
                        'city' => $this->request->getVar('city'),
                        'phone' => $this->request->getVar('phone'),
                        'fax' => $this->request->getVar('fax'),
                        'email' => $this->request->getVar('email'),
                        'tax_number' => $this->request->getVar('taxNumber'),
                    ]);
                    $msg = ['message' => "{$this->request->getVar('address')}" . lang('app.title add')];
                }
            } else if ($number == '2') { // Person
                $validationRules = ['name' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]]];
                if (!$this->validate($validationRules)) {
                    $msg = ['error' => ['name' => $this->validation->getError('name')]];
                } else {
                    $this->company3Model->save([
                        'unique' => create_Unique(),
                        'company_id' => $company,
                        'param' => 'person',
                        'name' => $this->request->getVar('name'),
                        'identity' => $this->request->getVar('identity'),
                        'position' => $this->request->getVar('position'),
                    ]);
                    $msg = ['message' => "{$this->request->getVar('name')}" . lang('app.title add')];
                }
            } else if ($number == '3') { // Share
                $validationRules = ['name' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]]];
                if (!$this->validate($validationRules)) {
                    $msg = ['error' => ['name' => $this->validation->getError('name')]];
                } else {
                    $price = changeSeparator($this->request->getVar('price'));
                    $this->company3Model->save([
                        'unique' => create_Unique(),
                        'company_id' => $company,
                        'param' => 'share',
                        'name' => $this->request->getVar('name'),
                        'address' => $this->request->getVar('address'),
                        'identity' => $this->request->getVar('identity'),
                        'quantity' => changeSeparator($this->request->getVar('quantity')),
                        'price' => $price,
                    ]);
                    $this->mainModel->updateData('company_person', 'price', $price, 'company_id', $company, 'param', 'share');
                    $msg = ['message' => "{$this->request->getVar('name')}" . lang('app.title add')];
                }
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function tableModal()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_company', $this->request->getVar('unique'));
            $db2 = $this->mainModel->sumCompany($db1[0]->id ?? '');
            $msg = [
                'table1' => view('x-main/company_table1', ['company' => $this->mainModel->getCompanyAddress($db1[0]->id ?? '')]),
                'table2' => view('x-main/company_table2', ['company' => $this->mainModel->getCompanyPerson($db1[0]->id ?? '', 'person')]),
                'table3' => view('x-main/company_table3', ['company' => $this->mainModel->getCompanyPerson($db1[0]->id ?? '', 'share'), 'total' => $db2[0]->subQuantity ?? ''])
            ];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
