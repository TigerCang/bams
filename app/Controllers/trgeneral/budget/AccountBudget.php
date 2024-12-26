<?php

namespace App\Controllers\trgeneral\budget;

use Config\App;
use App\Controllers\BaseController;
use App\Models\trgeneral\BudgetParentModel;
use App\Models\trgeneral\BudgetChild1Model;

class AccountBudget extends BaseController
{
    protected $BudgetParentModel;
    protected $BudgetChild1Model;
    public function __construct()
    {
        $this->budgetparentModel = new BudgetParentModel();
        $this->budgetchild1Model = new BudgetChild1Model();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        // checkPage('119');
        $data = [
            't_title' => lang('app.account budget'),
            't_span' => lang('app.span account budget'),
            'link' => '/accountbudget',
            'budget' => $this->transModel->getBudget($this->urls[1]),
        ];
        $this->render('trgeneral/budget/budget_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        $db1 = $this->mainModel->getData('budget_parent', $this->request->getVar('search'));
        $table = (isset($db1[0]) ? ($db1[0]->object == 'project' ? 'm_project' : ($db1[0]->object == 'equipment tool' ? 'm_tool' : ($db1[0]->object == 'land building' ? 'm_land' : 'm_branch'))) : 'm_branch');
        // checkPage('119', $db1);
        $buttons = transButton($db1, '1', $db1[0]->status ?? '0');
        // if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, "{$db1[0]->title}");

        $data = [
            't_title' => lang('app.account budget'),
            't_span' => lang('app.span account budget'),
            'link' => "/accountbudget",
            'company' => $this->mainModel->getCompany('', 't'),
            'region' => $this->mainModel->getFile('', 'region', 't'),
            'division' => $this->mainModel->getFile('', 'division', 't'),
            'selectSource' => $this->mainModel->distSelect('set budget'),
            'selectObject' => $this->mainModel->distSelect('object'),
            'type' => $this->mainModel->distinctCost('indirect cost'),
            'choice' => 'object',
            'object1' => $this->mainModel->getData($table, $db1[0]->object_id ?? '', '', 'id'),
            'budget' => $db1,
            'button' => ['hidden' => $buttons['hidden'], 'disabled' => $buttons['disabled']],
        ];
        $this->render('trgeneral/budget/accountBudget_input', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function addData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('budget_parent', $this->request->getVar('unique'));
            $object = (isset($db1[0]->status) && $db1[0]->status != '0' ? $db1[0]->object_id : $this->request->getVar('branch'));
            $ruleBranch = $object ? 'permit_empty' : 'required';
            $company = (isset($db1[0]->status) && $db1[0]->status != '0' ? $db1[0]->company_id : $this->request->getVar('company'));
            $region = (isset($db1[0]->status) && $db1[0]->status != '0' ? $db1[0]->region_id : $this->request->getVar('region'));
            $division = (isset($db1[0]->status) && $db1[0]->status != '0' ? $db1[0]->division_id : $this->request->getVar('division'));
            $ruleAccess = checkAccess($company, $region, $division, 'save');
            if ($ruleBranch == 'permit_empty') $ruleBranch = checkObject($this->request->getVar('xObject'), $object);
            $unique = $this->request->getVar('unique');

            $validationRules = [
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
                if (!$db1) {
                    $this->budgetparentModel->save([
                        'unique' =>  $unique,
                        'source' =>  $this->request->getVar('xSource'),
                        'object' =>  $this->request->getVar('xObject'),
                        'company_id' => $this->request->getVar('company'),
                        'region_id' => $this->request->getVar('region'),
                        'division_id' => $this->request->getVar('division'),
                        'object_id' => $object,
                        'date_start' => $this->request->getVar('startDate'),
                        'date_end' => $this->request->getVar('endDate'),
                        'status' => '0', //new
                    ]);
                }

                $parent = $this->mainModel->getData('budget_parent', $unique);
                $this->budgetchild1Model->save([
                    'unique' =>  create_Unique('120'),
                    'parent_id' => $parent[0]->id,
                    'account_id' => $this->request->getVar('account'),
                    'month' => changeSeparator($this->request->getVar('month')),
                    'quantity' => changeSeparator($this->request->getVar('quantity')),
                    'price_contract' => changeSeparator($this->request->getVar('price')),
                    'total_contract' => changeSeparator($this->request->getVar('total')),
                    'notes' => $this->request->getVar('notes'),
                ]);

                $db4 = $this->mainModel->getParentCost('account', $this->request->getVar('account'));
                $cekLevel3 = $this->transModel->cekBudgetChild($parent[0]->id, 'account_id', $db4[0]->idLevel3);
                if ($cekLevel3) {
                    $total3 = $this->transModel->getBudgetTotal($parent[0]->id, $db4[0]->idLevel3, 'account');
                    $this->budgetchild1Model->save(['id' => $cekLevel3[0]->id, 'total_contract' => $total3[0]->totalcontract]);
                    $this->mainModel->updateDeletedAt('budget_child1', $cekLevel3[0]->id);
                } else {
                    $this->budgetchild1Model->save([
                        'unique' =>  create_Unique('120'),
                        'parent_id' => $parent[0]->id,
                        'account_id' => $db4[0]->idLevel3,
                        'total_contract' => changeSeparator($this->request->getVar('total')),
                    ]);
                }

                $cekLevel2 = $this->transModel->cekBudgetChild($parent[0]->id, 'account_id', $db4[0]->idLevel2);
                if ($cekLevel2) {
                    $total2 = $this->transModel->getBudgetTotal($parent[0]->id, $db4[0]->idLevel2, 'account');
                    $this->budgetchild1Model->save(['id' => $cekLevel2[0]->id, 'total_contract' => $total2[0]->totalcontract]);
                    $this->mainModel->updateDeletedAt('budget_child1', $cekLevel2[0]->id);
                } else {
                    $this->budgetchild1Model->save([
                        'unique' =>  create_Unique('120'),
                        'parent_id' => $parent[0]->id,
                        'account_id' => $db4[0]->idLevel2,
                        'total_contract' => changeSeparator($this->request->getVar('total')),
                    ]);
                }

                $cekLevel1 = $this->transModel->cekBudgetChild($parent[0]->id, 'account_id', $db4[0]->idLevel1);
                if ($cekLevel1) {
                    $total1 = $this->transModel->getBudgetTotal($parent[0]->id, $db4[0]->idLevel1, 'account');
                    $this->budgetchild1Model->save(['id' => $cekLevel1[0]->id, 'total_contract' => $total1[0]->totalcontract]);
                    $this->mainModel->updateDeletedAt('budget_child1', $cekLevel1[0]->id);
                } else {
                    $this->budgetchild1Model->save([
                        'unique' =>  create_Unique('120'),
                        'parent_id' => $parent[0]->id,
                        'account_id' => $db4[0]->idLevel1,
                        'total_contract' => changeSeparator($this->request->getVar('total')),
                        'level_one' => '1',
                    ]);
                }

                if ($this->request->getVar('unique') == '') {
                    $msg = [
                        'redirect' => '/accountbudget/input?search=' . $unique,
                        'message' => "{$db4[0]->name}" . lang('app.title add'),
                    ];
                    session()->setFlashdata('message', $msg['message']);
                } else {
                    session()->remove('message');
                    $msg = ['message' => "{$db4[0]->name}" . lang('app.title add')];
                }
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    // public function deletedata()
    // {
    //     if ($this->request->isAJAX()) {
    //         $id = $this->request->getVar('id');
    //         $anak = $this->deklarModel->satuID('anggaran_anak', $id, 'id');
    //         $this->anggarananakModel->delete($id);

    //         $indukby = $this->deklarModel->getIndukakun($anak[0]->akun_id);
    //         $dblev3 = $this->tranModel->cekAnggarananak('akun_id', $anak[0]->anggaraninduk_id, $indukby[0]->idlev3);
    //         $total3 = $this->tranModel->getAnggarantotal($anak[0]->anggaraninduk_id, $indukby[0]->idlev3, 'akun');
    //         if (empty($total3)) {
    //             $this->anggarananakModel->delete($dblev3[0]->id);
    //         } else {
    //             $this->anggarananakModel->save([
    //                 'id' => $dblev3[0]->id,
    //                 'total_kontrak_cco' => $total3[0]->totkontraktcco,
    //             ]);
    //         }

    //         $dblev2 = $this->tranModel->cekAnggarananak('akun_id', $anak[0]->anggaraninduk_id, $indukby[0]->idlev2);
    //         $total2 = $this->tranModel->getAnggarantotal($anak[0]->anggaraninduk_id, $indukby[0]->idlev2, 'akun');
    //         if (empty($total2)) {
    //             $this->anggarananakModel->delete($dblev2[0]->id);
    //         } else {
    //             $this->anggarananakModel->save([
    //                 'id' => $dblev2[0]->id,
    //                 'total_kontrak_cco' => $total2[0]->totkontrakcco,
    //             ]);
    //         }

    //         $dblev1 = $this->tranModel->cekAnggarananak('akun_id', $anak[0]->anggaraninduk_id, $indukby[0]->idlev1);
    //         $total1 = $this->tranModel->getAnggarantotal($anak[0]->anggaraninduk_id, $indukby[0]->idlev1, 'akun');
    //         $this->anggarananakModel->save([
    //             'id' => $dblev1[0]->id,
    //             'total_kontrak_cco' => $total1[0]->totkontrakcco,
    //         ]);
    //         $msg = ['sukses' => $this->request->getVar('kode') . " " . lang("app.judulhapus")];
    //         echo json_encode($msg);
    //     } else {
    //         exit('out');
    //     }
    // }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('budget_parent', $this->request->getVar('unique'));
            $ruleAccess = 'permit_empty';
            $ruleBranch = 'permit_empty';
            $company = ($db1[0]->status == '0' ? $this->request->getVar('company') : $db1[0]->company_id);
            $region = ($db1[0]->status == '0' ? $this->request->getVar('region') : $db1[0]->region_id);
            $division = ($db1[0]->status == '0' ? $this->request->getVar('division') : $db1[0]->division_id);
            $ruleAccess = checkAccess($company, $region, $division, 'save');

            // $cek = $this->tranModel->cekBudgetinduk($this->request->getVar('pilih'), $this->request->getVar('tujuan'), $this->request->getVar('beban'), '', $this->request->getVar('noadd'), $this->request->getVar('norev'));
            $validationRules = [
                'branch' => ['rules' => $ruleBranch, 'errors' => ['required' => lang("app.err blank")]],
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
                    $revision = $this->request->getVar('addendumNumber') . '.' . $this->request->getVar('revisionNumber');

                    $this->budgetparentModel->save([
                        'id' =>  $db1[0]->id,
                        'object' =>  $this->request->getVar('xObject'),
                        'company_id' => $this->request->getVar('company'),
                        'region_id' => $this->request->getVar('region'),
                        'division_id' => $this->request->getVar('division'),
                        'object_id' => $this->request->getVar('branch'),
                        'document_number' => $docNumber,
                        'date_start' =>  $this->request->getVar('startDate'),
                        'date_end' =>  $this->request->getVar('endDate'),
                        'revision' => $revision,
                        'level' => $this->user['act_approve'] . ',' . $this->user['act_approve'],
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

    // ____________________________________________________________________________________________________________________________
    //     public function loadbudgetbawaan()
    //     {
    //         if ($this->request->isAJAX()) {
    //             $satu = $this->deklarModel->satuID('anggaran_induk', $this->request->getVar('idunik'));
    //             if (empty($satu)) {
    //                 // $cekproyek = $this->deklarModel->satuID('m_proyek', $this->request->getVar('idproyek'), 'id', 't');

    //                 $validationRules = [
    //                     'idperusahaan' => [
    //                         'rules' => 'required',
    //                         'errors' => ['required' => lang("app.errpilih")]
    //                     ],
    //                     'idwilayah' => [
    //                         'rules' => 'required',
    //                         'errors' => ['required' => lang("app.errpilih")]
    //                     ],
    //                     'iddivisi' => [
    //                         'rules' => 'required',
    //                         'errors' => ['required' => lang("app.errpilih")]
    //                     ],
    //                     'pilih' => [
    //                         'rules' => 'required',
    //                         'errors' => ['required' => lang("app.errpilih")]
    //                     ],
    //                     'kodebeban' => [
    //                         'rules' => 'required',
    //                         'errors' => ['required' => lang("app.errblank")]
    //                     ],
    //                 ];

    //                 if (!$this->validate($validationRules)) {
    //                     $msg = [
    //                         'error' => [
    //                             'perusahaan' => $this->validation->getError('idperusahaan'),
    //                             'wilayah' => $this->validation->getError('idwilayah'),
    //                             'divisi' => $this->validation->getError('iddivisi'),
    //                             'pilih' => $this->validation->getError('pilih'),
    //                             'kodebeban' => $this->validation->getError('kodebeban'),
    //                         ]
    //                     ];
    //                 } else {
    //                     $db = $this->deklarModel->getAnggaran('', '0', '', $this->request->getVar('xtujuan'), $this->request->getVar('xpilih'));
    //                     $this->anggaranindukModel->save([
    //                         'idunik' =>  $this->request->getVar('idunik'),
    //                         'pilihan' =>  $this->request->getVar('xpilih'),
    //                         'tujuan' =>  $this->request->getVar('xtujuan'),
    //                         'perusahaan_id' => $this->request->getVar('idperusahaan'),
    //                         'wilayah_id' => $this->request->getVar('idwilayah'),
    //                         'divisi_id' => $this->request->getVar('iddivisi'),
    //                         'beban_id' => $this->request->getVar('idbeban'),
    //                         'tanggal1' => $this->request->getVar('tanggal1'),
    //                         'tanggal2' => $this->request->getVar('tanggal2'),
    //                         'noadendum' => $this->request->getVar('noadd'),
    //                         'norevisi' => $this->request->getVar('norev'),
    //                     ]);

    //                     $idinduk = $this->deklarModel->satuID('anggaran_induk', $this->request->getVar('idunik'));
    //                     foreach ($db as $item) {
    //                         $this->anggarananakModel->save([
    //                             'anggaraninduk_id' => $idinduk[0]->id,
    //                             'akun_id' => $item->akun_id,
    //                             'bulan' => $item->bulan,
    //                             'jumlah_cco' => $item->jumlah,
    //                             'harga_kontrak_cco' => $item->harga,
    //                             'total_kontrak_cco' => $item->total,
    //                             'catatan' => $item->catatan,
    //                         ]);
    //                     }
    //                     $msg = ['sukses' => lang("app.panggilanggaran")];
    //                 }
    //             } else { //jika suda ada data
    //                 $msg = ['ada' => lang("app.errunik2")];
    //             }
    //             echo json_encode($msg);
    //         } else {
    //             exit('out');
    //         }
    //     }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function tableData()
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
