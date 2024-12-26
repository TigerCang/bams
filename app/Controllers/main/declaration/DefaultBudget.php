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
            'link' => '/defaultbudget',
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
            'link' => "/defaultbudget",
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
            $type = ($object == 'project' ? $this->request->getVar('xType') : '');
            $ruleObject = 'permit_empty';
            if ($db1 && (($db1[0]->object == 'project') xor ($object == 'project'))) $ruleObject = 'valid_email';
            $unique = $this->request->getVar('unique');

            $validationRules = [
                'object' => ['rules' => $ruleObject, 'errors' => ['valid_email' => lang("app.err invalid")]],
                'title' => ['rules' => $ruleTitle, 'errors' => ['required' => lang("app.err blank"), 'valid_email' => lang("app.err unique")]],
                'cost' => ['rules' => $ruleCost, 'errors' => ['required' => lang("app.err select")]],
                'account' => ['rules' => $ruleAccount, 'errors' => ['required' => lang("app.err select")]],
                'total' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'object' => $this->validation->getError('object'),
                        'title' => $this->validation->getError('title'),
                        'cost' => $this->validation->getError('cost'),
                        'account' => $this->validation->getError('account'),
                        'total' => $this->validation->getError('total'),
                    ]
                ];
            } else {
                if ($unique == '') $unique = create_Unique();
                $adaptation = (empty($db1) ? '021' : $db1[0]->adaptation[0] . '2' . $db1[0]->adaptation[2]);
                if (empty($db1)) {
                    $this->budget1Model->save([
                        'unique' => $unique,
                        'title' => $this->request->getVar('title'),
                        'source' => $this->request->getVar('xSource'),
                        'object' => $object,
                        'type' => $type,
                        'adaptation' => $adaptation,
                    ]);
                }

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
                $cekLevel3 = $this->mainModel->cekBudget($dbParent[0]->id, $nField, $nID, $db4[0]->idLevel3);
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

                $cekLevel2 = $this->mainModel->cekBudget($dbParent[0]->id, $nField, $nID, $db4[0]->idLevel2);
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

                $cekLevel1 = $this->mainModel->cekBudget($dbParent[0]->id, $nField, $nID, $db4[0]->idLevel1);
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

                $total = $this->mainModel->budgetTotal($nField, $dbParent[0]->id, '', '1');
                $this->mainModel->updateData('m_budget1', 'total', $total[0]->subtotal, 'unique', $unique);
                if ($this->request->getVar('unique') == '') {
                    $msg = [
                        'redirect' => '/defaultbudget/input?search=' . $unique,
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
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_budget1', $this->request->getVar('unique'));
            $cekData = $this->mainModel->cekData('m_budget1', 'title', $this->request->getVar('title'), '', '', $this->request->getVar('unique'));
            $object = $this->request->getVar('xObject');
            $ruleTitle = ($cekData ? 'required|valid_email' : 'required');
            $ruleAccess = ($db1 ? 'permit_empty' : 'required');
            $type = ($object == 'project' ? $this->request->getVar('xType') : '');
            $ruleObject = 'permit_empty';
            if ($db1 && (($db1[0]->object == 'project') xor ($object == 'project'))) $ruleObject = 'valid_email';

            $validationRules = [
                'access' => ['rules' => $ruleAccess, 'errors' => ['required' => lang("app.err access")]],
                'object' => ['rules' => $ruleObject, 'errors' => ['valid_email' => lang("app.err invalid")]],
                'title' => ['rules' => $ruleTitle, 'errors' => ['required' => lang("app.err blank"), 'valid_email' => lang("app.err unique")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'access' => $this->validation->getError('access'),
                        'object' => $this->validation->getError('object'),
                        'title' => $this->validation->getError('title'),
                    ]
                ];
            } else {
                // Save
                if ($this->request->getVar('postAction') == 'save') {
                    $adaptation = ($db1[0]->adaptation[0] . '0' . $db1[0]->adaptation[2]);
                    $this->deklarModel->updateData('m_anggaran', 'is_confirm', '0', 'idunik', $idunik);
                    $this->deklarModel->updateData('m_anggaran', 'updated_by', $this->user['id'], 'idunik', $idunik);
                    $this->deklarModel->updateData('m_anggaran', 'confirmed_by', '0', 'idunik', $idunik);
                    $this->logModel->saveLog('Save', $idunik, "{$this->request->getVar('xpilih')} ; {$this->request->getVar('xtujuan')}");
                    session()->setFlashdata('judul', lang('app.' . $this->request->getVar('xpilih')) . ' ; ' . lang('app.' . $this->request->getVar('xtujuan')) . ' ' . lang("app.judulsimpan"));
                } elseif ($this->request->getVar('postAction') == 'confirm') {
                    $this->deklarModel->updateData('m_anggaran', 'is_confirm', '1', 'idunik', $idunik);
                    $this->deklarModel->updateData('m_anggaran', 'confirmed_by', $this->user['id'], 'idunik', $idunik);
                    $this->logModel->saveLog('Confirm', $idunik, "{$this->request->getVar('xpilih')} ; {$this->request->getVar('xtujuan')}");
                    session()->setFlashdata('judul', lang('app.' . $this->request->getVar('xpilih')) . ' ; ' . lang('app.' . $this->request->getVar('xtujuan')) . ' ' . lang("app.judulkonf"));
                    // } elseif ($this->request->getVar('postAction') == 'delete') {
                } elseif ($this->request->getVar('postAction') == 'active') {
                    $this->deklarModel->updateData('m_anggaran', 'is_aktif', $this->request->getVar('niaktif'), 'idunik', $idunik);
                    $this->deklarModel->updateData('m_anggaran', 'activated_by', $akby, 'idunik', $idunik);
                    $this->logModel->saveLog('Active', $idunik, "{$this->request->getVar('xpilih')} ; {$this->request->getVar('xtujuan')} {$onoff}");
                    session()->setFlashdata('judul', lang('app.' . $this->request->getVar('xpilih')) . ' ; ' . lang('app.' . $this->request->getVar('xtujuan')) . ' ' . lang("app.judulkonf") . ' ' . $savj);
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
            ];
            $msg = ['data' => view('x-modal/defaultBudget_edit', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $tujuan = $this->request->getVar('mtujuan');
            $idunik = $this->request->getVar('midunik');

            $validationRules = [
                'mcatatan' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
            ];
            if (!$this->validate($validationRules)) {
                $msg = ['error' => ['mcatatan' => $this->validation->getError('mcatatan')]];
            } else {
                $ntabel = ($this->request->getVar('mtujuan') == 'proyek' ? 'm_biaya' : 'm_akun');
                $nfield = ($tujuan == 'proyek' ? 'biaya' : 'akun');
                $nid = ($this->request->getVar('mtujuan') == 'proyek' ? 'biaya_id' : 'akun_id');
                $this->anggaranModel->save([
                    'id' => $this->request->getVar('mid'),
                    'bulan' => ubahSeparator($this->request->getVar('mbulan')),
                    'jumlah' => ubahSeparator($this->request->getVar('mjumlah')),
                    'harga' =>  ubahSeparator($this->request->getVar('mharga')),
                    'total' => ubahSeparator($this->request->getVar('mtotal')),
                    'catatan' => $this->request->getVar('mcatatan'),
                ]);
                $dbu = $this->deklarModel->satuID('m_anggaran', $idunik);
                // $stconf = (($dbu && $dbu[0]->is_confirm != 'off') ? 'onoff' : 'off');
                // $this->deklarModel->updateData('m_anggaran', 'is_confirm', $stconf, 'idunik', $idunik);
                $db4 = $this->deklarModel->satuID($ntabel, $this->request->getVar('mitem'), '', 'id');
                $item = ($tujuan == 'proyek') ? $db4[0]->kode : $db4[0]->noakun;
                // 
                $db3 = $this->deklarModel->satuID($ntabel, $db4[0]->induk_id, '', 'id');
                $ceklev3 = $this->deklarModel->cekAnggaran($idunik, $nfield, $nid, $db3[0]->id);
                $total3 = $this->deklarModel->anggaranTotal($idunik, $db3[0]->id, $nfield);
                $this->anggaranModel->save(['id' => $ceklev3[0]->id, 'total' => $total3[0]->subtotal]);
                // 
                $db2 = $this->deklarModel->satuID($ntabel, $db3[0]->induk_id, '', 'id');
                $ceklev2 = $this->deklarModel->cekAnggaran($idunik, $nfield, $nid, $db2[0]->id);
                $total2 = $this->deklarModel->anggaranTotal($idunik, $db2[0]->id, $nfield);
                $this->anggaranModel->save(['id' => $ceklev2[0]->id, 'total' => $total2[0]->subtotal]);
                // 
                $db1 = $this->deklarModel->satuID($ntabel, $db2[0]->induk_id, '', 'id');
                $ceklev1 = $this->deklarModel->cekAnggaran($idunik, $nfield, $nid, $db1[0]->id);
                $total1 = $this->deklarModel->anggaranTotal($idunik, $db1[0]->id, $nfield);
                $this->anggaranModel->save(['id' => $ceklev1[0]->id, 'total' => $total1[0]->subtotal]);
                $msg = ['sukses' => "{$item}" . lang("app.judulubah")];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function deletedata()
    {
        if ($this->request->isAJAX()) {
            die;
            $id = $this->request->getVar('id');
            $dbu = $this->deklarModel->satuID('m_anggaran', $id, '', 'id');
            $idunik = $dbu[0]->idunik;
            $stconf = (($dbu && $dbu[0]->is_confirm != 'off') ? 'onoff' : 'off');

            // $pilihan = $dbu[0]->pilihan;
            $tujuan = $dbu[0]->tujuan;
            // $jenis = $dbu[0]->idunik;


            // $total = ubahSeparator($this->request->getVar('total'));
            $nfield = ($tujuan == 'proyek' ? 'biaya' : 'akun');
            $ntabel = ($tujuan == 'proyek' ? 'm_biaya' : 'm_akun');
            $nid = ($tujuan == 'proyek' ? 'biaya_id' : 'akun_id');
            $nitem = ($tujuan == 'proyek' ? $dbu[0]->biaya_id : $dbu[0]->akun_id);


            // $this->deklarModel->updateData('m_anggaran', 'is_confirm', $stconf, 'idunik', $idunik);
            // $this->anggaranModel->delete($id);

            $db4 = $this->deklarModel->satuID($ntabel, $nitem, '', 'id');
            $item = ($tujuan == 'proyek') ? $db4[0]->kode : $db4[0]->noakun;

            var_dump($tujuan, $nfield, $ntabel, $id, $nitem, $item);
            die;

            // 
            $db3 = $this->deklarModel->satuID($ntabel, $db4[0]->induk_id, '', 'id');
            $ceklev3 = $this->deklarModel->cekAnggaran($idunik, $nfield, $nid, $db3[0]->id);
            $total3 = $this->deklarModel->anggaranTotal($idunik, $db3[0]->id, $nfield);
            $this->anggaranModel->save(['id' => $ceklev3[0]->id, 'total' => $total3[0]->subtotal]);
            $this->deklarModel->updateDeletedat('m_anggaran', $ceklev3[0]->id);
            // 
            $db2 = $this->deklarModel->satuID($ntabel, $db3[0]->induk_id, '', 'id');
            $ceklev2 = $this->deklarModel->cekAnggaran($idunik, $nfield, $nid, $db2[0]->id);
            $total2 = $this->deklarModel->anggaranTotal($idunik, $db2[0]->id, $nfield);
            $this->anggaranModel->save(['id' => $ceklev2[0]->id, 'total' => $total2[0]->subtotal]);
            $this->deklarModel->updateDeletedat('m_anggaran', $ceklev2[0]->id);
            // 
            $db1 = $this->deklarModel->satuID($ntabel, $db2[0]->induk_id, '', 'id');
            $ceklev1 = $this->deklarModel->cekAnggaran($idunik, $nfield, $nid, $db1[0]->id);
            $total1 = $this->deklarModel->anggaranTotal($idunik, $db1[0]->id, $nfield);
            $this->anggaranModel->save(['id' => $ceklev1[0]->id, 'total' => $total1[0]->subtotal]);
            $this->deklarModel->updateDeletedat('m_anggaran', $ceklev1[0]->id);

            $msg = ['sukses' => $this->request->getVar('kode') . ' ' . lang("app.judulhapus")];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function tableData()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'link' => '/defaultbudget',
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
