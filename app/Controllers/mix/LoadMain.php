<?php

namespace App\Controllers\mix;

use Config\App;
use App\Controllers\BaseController;

class LoadMain extends BaseController
{
    // Search ___________________________________________________________________________________________________________________________________________________________________________________________
    public function searchLog()
    {
        if ($this->request->isAJAX()) {
            $username = (($this->request->getVar('blank') == "0" && $this->request->getVar('username') == '') ? 'XYZ' : $this->request->getVar('username'));
            $data = [
                'log' => $this->mainModel->getLog($this->request->getVar('isi'), $username),
                'uHid' => $this->request->getVar('blank') == '0' ? 'hidden' : '',
            ];
            $msg = ['data' => view('x-main/log_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    public function searchCost()
    {
        if ($this->request->isAJAX()) {
            $category = ($this->request->getVar('category') != '' ? $this->request->getVar('category') : 'XYZ');
            $data = ['cost' => $this->mainModel->getCost($this->request->getVar('url'), $this->request->getVar('param'), $category)];
            $msg = ['data' => view('x-main/cost_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    public function searchTool()
    {
        if ($this->request->isAJAX()) {
            $param = ($this->request->getVar('url') != 'partnervehicle' ? $this->request->getVar('url') : 'partner');
            $person = ($this->request->getVar('person') != '' ? $this->request->getVar('person') : 'XYZ');
            $data = [
                'tool' => $this->mainModel->getTool($this->request->getVar('url'), '', $param, $this->request->getVar('company'), $person, $this->request->getVar('category')),
                'con' => $this->request->getVar('con'), //company code number
            ];
            $msg = ['data' => view('x-main/tool_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    public function searchDistance()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'distance' => $this->mainModel->getSegment($this->request->getVar('url'), $this->request->getVar('url'), '', $this->request->getVar('project'), $this->request->getVar('branch')),
                'bcd' => $this->request->getVar('bcd'), //branch company distance
            ];
            $msg = ['data' => view('x-main/distance_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    public function searchItem()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'item' => $this->mainModel->getItem($this->request->getVar('url'), $this->request->getVar('url'), $this->request->getVar('category')),
                'pHid' => $this->request->getVar('pHid'),
                'sHid' => $this->request->getVar('sHid'),
            ];
            $msg = ['data' => view('x-main/item_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // Show ___________________________________________________________________________________________________________________________________________________________________________________________
    public function showUnit()
    {
        if ($this->request->isAJAX()) {
            $cost1 = $this->mainModel->getData('m_cost', $this->request->getVar('cost') ?? '', '', 'id');
            $msg = ['unit' => $cost1[0]->unit ?? ''];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // public function searchFile()
    // {
    //     if ($this->request->isAJAX()) {
    //         $data = [
    //             'file' => $this->mainModel->getFile($this->urls[1], $this->request->getVar('param')),
    //             'ihid' => $this->request->getVar('ihid'),
    //             'this_user' => $this->user,
    //         ];
    //         $msg = ['data' => view('x-main/file_table', $data)];
    //         return $this->response->setJSON($msg);
    //     } else {
    //         exit('out');
    //     }
    // }


    // Load ___________________________________________________________________________________________________________________________________________________________________________________________
    public function loadCost()
    {
        if ($this->request->isAJAX()) {
            switch ($this->request->getVar('param')) {
                case 'resources':
                    $param = ($this->request->getVar('segment') != '' ? 'resources' : 'blank');
                    $cost = $this->mainModel->loadCost($param, '2', '', $this->request->getVar('searchTerm'));
                    break;
                case 'cost':
                    if ($this->request->getVar('segment') == '')
                        $cost = $this->mainModel->loadCost('indirect cost', '4', '', $this->request->getVar('searchTerm'), $this->request->getVar('start'));
                    else
                        $cost = $this->mainModel->loadCost('direct cost', '3', $this->request->getVar('category'), $this->request->getVar('searchTerm'));
                    break;
                case 'blank';
                    break;
            }
            $costData = array();
            foreach ($cost as $row) {
                $costData[] = array('id' => $row->id, 'text' => $row->code . str_repeat("\u{00A0}", 6) . $row->name);
            }
            echo json_encode($costData);
        } else {
            exit('out');
        }
    }

    public function loadAccount()
    {
        if ($this->request->isAJAX()) {
            $account = $this->mainModel->loadAccount($this->request->getVar('searchTerm'), $this->request->getVar('start'));
            $accountData = array();
            foreach ($account as $row) {
                $accountData[] = array('id' => $row->id, 'text' => $row->code . str_repeat("\u{00A0}", 6) . $row->name);
            }
            return $this->response->setJSON($accountData);
        } else {
            exit('out');
        }
    }

    public function loadStandard()
    {
        if ($this->request->isAJAX()) {
            $standard = $this->mainModel->loadStandard($this->request->getVar('searchTerm'), $this->request->getVar('param'));
            $standardData = array();
            foreach ($standard as $row) {
                $standardData[] = array('id' => $row->id, 'text' => $row->code . str_repeat("\u{00A0}", 6) . $row->name);
            }
            echo json_encode($standardData);
        } else {
            exit('out');
        }
    }

    public function loadUser()
    {
        if ($this->request->isAJAX()) {
            $user = $this->mainModel->loadUser($this->request->getVar('searchTerm'), '', $this->request->getVar('employee'));
            $userData = array();
            foreach ($user as $row) {
                $userData[] = array('id' => $row->id, 'text' => $row->code . str_repeat("\u{00A0}", 6) . $row->employeeName);
            }
            echo json_encode($userData);
        } else {
            exit('out');
        }
    }

    public function loadPerson()
    {
        if ($this->request->isAJAX()) {
            $customer = substr($this->request->getVar('choose'), 0, 1);
            $supplier = substr($this->request->getVar('choose'), 1, 1);
            $subcontractor = substr($this->request->getVar('choose'), 2, 1);
            $employee = substr($this->request->getVar('choose'), 3, 1);
            $osm = substr($this->request->getVar('choose'), 4, 1);
            $person = $this->mainModel->loadPerson($this->request->getVar('searchTerm'), $customer, $supplier, $subcontractor, $employee, $osm);
            $personData = array();
            foreach ($person as $row) {
                $personData[] = array('id' => $row->id, 'text' => $row->code . str_repeat("\u{00A0}", 6) . $row->name);
            }
            echo json_encode($personData);
        } else {
            exit('out');
        }
    }

    public function loadItem()
    {
        if ($this->request->isAJAX()) {
            $item = $this->mainModel->loadItem($this->request->getVar('searchTerm'), $this->request->getVar('param'), $this->request->getVar('serial'));
            $itemData = array();
            foreach ($item as $row) {
                $itemData[] = array('id' => $row->id, 'text' => $row->code . str_repeat("\u{00A0}", 6) . $row->name . " (" . $row->part_number . ")");
            }
            echo json_encode($itemData);
        } else {
            exit('out');
        }
    }

    public function loadProject()
    {
        if ($this->request->isAJAX()) {
            $project = $this->mainModel->loadProject($this->request->getVar('searchTerm'), $this->request->getVar('company'), $this->request->getVar('region'), $this->request->getVar('division'));
            $projectData = array();
            foreach ($project as $row) {
                $projectData[] = array('id' => $row->id, 'text' => $row->code . str_repeat("\u{00A0}", 6) . $row->package_name);
            }
            echo json_encode($projectData);
        } else {
            exit('out');
        }
    }

    public function loadBranch()
    {
        if ($this->request->isAJAX()) {
            $branch = $this->mainModel->loadBranch($this->request->getVar('searchTerm'), $this->request->getVar('company'), $this->request->getVar('region'), $this->request->getVar('division'));
            $branchData = array();
            foreach ($branch as $row) {
                $branchData[] = array('id' => $row->id, 'text' => $row->code . str_repeat("\u{00A0}", 6) . $row->name);
            }
            echo json_encode($branchData);
        } else {
            exit('out');
        }
    }

    public function loadTool()
    {
        if ($this->request->isAJAX()) {
            $tool = $this->mainModel->loadTool($this->request->getVar('searchTerm'), $this->request->getVar('choose'), $this->request->getVar('company'), $this->request->getVar('region'), $this->request->getVar('division'));
            $toolData = array();
            foreach ($tool as $row) {
                $toolData[] = array('id' => $row->id, 'text' => $row->code . str_repeat("\u{00A0}", 6) . $row->name . " (" . $row->code2 . ")",);
            }
            return $this->response->setJSON($toolData);
        } else {
            exit('out');
        }
    }

    public function loadObject()
    {
        if ($this->request->isAJAX()) {
            $object = $this->request->getVar('object');
            switch ($object) {
                case 'project':
                    $result = $this->mainModel->loadProject($this->request->getVar('searchTerm'), $this->request->getVar('company'), $this->request->getVar('region'), $this->request->getVar('division'));
                    $resultData = array();
                    foreach ($result as $row) {
                        $resultData[] = array('id' => $row->id, 'text' => $row->code . str_repeat("\u{00A0}", 6) . $row->package_name);
                    }
                    break;
                case 'branch':
                    $result = $this->mainModel->loadBranch($this->request->getVar('searchTerm'), $this->request->getVar('company'), $this->request->getVar('region'), $this->request->getVar('division'));
                    $resultData = array();
                    foreach ($result as $row) {
                        $resultData[] = array('id' => $row->id, 'text' => $row->code . str_repeat("\u{00A0}", 6) . $row->name);
                    }
                    break;
                case 'equipment tool':
                    $result = $this->mainModel->loadTool($this->request->getVar('searchTerm'), $this->request->getVar('choose'), $this->request->getVar('company'), $this->request->getVar('region'), $this->request->getVar('division'));
                    $resultData = array();
                    foreach ($result as $row) {
                        $resultData[] = array('id' => $row->id, 'text' => $row->code . str_repeat("\u{00A0}", 6) . $row->name . " (" . $row->code2 . ")");
                    }
                    break;
                case 'land building':
                    // $result = $this->mainModel->loadLand($this->request->getVar('searchTerm'), $this->request->getVar('choose'), $this->request->getVar('company'), $this->request->getVar('region'), $this->request->getVar('division'));
                    // $resultData = array();
                    // foreach ($result as $row) {
                    //     $resultData[] = array('id' => $row->id, 'text' => $row->code, 'data-subtext' => $row->name . " (" . $row->code2 . ")");
                    // }
                    // break;

                    // $result = $this->mainModel->loadTool($this->request->getVar('searchTerm'), $this->request->getVar('choose'), $this->request->getVar('company'), $this->request->getVar('region'), $this->request->getVar('division'));
                    // $resultData = array();
                    // foreach ($result as $row) {
                    //     $resultData[] = array('id' => $row->id, 'text' => $row->code, 'data-subtext' => $row->name);
                    // }
                case 'employee':
                    $result = $this->mainModel->loadPerson($this->request->getVar('searchTerm'), '0', '0', '0', '1', '0');
                    $resultData = array();
                    foreach ($result as $row) {
                        $resultData[] = array('id' => $row->id, 'text' => $row->code . str_repeat("\u{00A0}", 6) . $row->name);
                    }
                    break;
                default:
                    $resultData = [];
                    break;
            }
            return $this->response->setJSON($resultData);
        } else {
            exit('out');
        }
    }

    // public function loadSegment()
    // {
    //     if ($this->request->isAJAX()) {
    //         $sruas = $this->request->getvar('ruas');
    //         $proyek = ($this->request->getvar('proyek') != '' ? $this->request->getvar('proyek') : '-');

    //         public function getSegment($menu, $param, $active = false, $project = false, $branch = false)

    //         $segment = $this->mainModel->getSegment('', $this->request->getvar('pilih'), 't', $proyek);
    //         $isiruas = "";
    //         $isiruas .= '<option value="">' . lang("app.pilih-") . '</option>';
    //         foreach ($ruas as $db) :
    //             $terpilih = "";
    //             if ($db->id == $sruas) $terpilih = 'selected';
    //             $isiruas .= '<option value="' . $db->id . '" data-kode="' . $db->kode . '" ' . $terpilih . '>' . $db->kode . " => " . $db->nama . '</option>';
    //         endforeach;
    //         $data = ['ruas' => $isiruas];
    //         echo json_encode($data);
    //     } else {
    //         exit('out');
    //     }
    // }


    // OutFocus ___________________________________________________________________________________________________________________________________________________________________________________________
    public function OutFocusPerson()
    {
        if ($this->request->isAJAX()) {
            $mapping = ['advance payment' => 'account1_id', 'advance receipt' => 'account2_id', 'road money' => 'account3_id', 'cash receipt' => 'account4_id'];
            $db1 = $this->mainModel->getData('m_person', $this->request->getVar('person') ?? '', '', 'id');
            $resultData = "";
            $field = $mapping[$this->request->getVar('choose')] ?? null;

            $dba1 = $this->mainModel->loadGA_COA($db1[0]->group_account_customer ?? '', $field);
            if (!empty($dba1)) $resultData .= '<option value="' . $dba1[0]->id . '">' . lang('app.customer') . ' -> ' . $dba1[0]->code . str_repeat("\u{00A0}", 6) . $dba1[0]->name . '</option>';
            $dba2 = $this->mainModel->loadGA_COA($db1[0]->group_account_supplier ?? '', $field);
            if (!empty($dba2)) $resultData .= '<option value="' . $dba2[0]->id . '">' . lang('app.supplier') . ' -> ' . $dba2[0]->code . str_repeat("\u{00A0}", 6) . $dba2[0]->name . '</option>';
            $dba3 = $this->mainModel->loadGA_COA($db1[0]->group_account_partner ?? '', $field);
            if (!empty($dba3)) $resultData .= '<option value="' . $dba3[0]->id . '">' . lang('app.subcontractor') . ' -> ' . $dba3[0]->code . str_repeat("\u{00A0}", 6) . $dba3[0]->name . '</option>';
            $dba4 = $this->mainModel->loadGA_COA($db1[0]->group_account_employee ?? '', $field);
            if (!empty($dba4)) $resultData .= '<option value="' . $dba4[0]->id . '">' . lang('app.employee') . ' -> ' . $dba4[0]->code . str_repeat("\u{00A0}", 6) . $dba4[0]->name . '</option>';
            $msg = ['account' => $resultData];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }





    // ____________________________________________________________________________________________________________________________
    // public function loadpenerima()
    // {
    //     if ($this->request->isAJAX()) {
    //         $pel = substr($this->request->getVar('pilih'), 0, 1);
    //         $sup = substr($this->request->getVar('pilih'), 1, 1);
    //         $lain = substr($this->request->getVar('pilih'), 2, 1);
    //         $peg = substr($this->request->getVar('pilih'), 3, 1);
    //         $penerima = $this->deklarModel->loadpenerima($this->request->getVar('searchTerm'), $pel, $sup, $lain, $peg, $this->request->getVar('osm'));
    //         $penerimadata = array();
    //         $penerimadata[] = array('id' => '', 'text' => lang("app.pilihsr"));
    //         foreach ($penerima as $row) {
    //             $penerimadata[] = array('id' => $row->id, 'text' => $row->kode . " => " . $row->nama);
    //         }
    //         echo json_encode($penerimadata);
    //     } else {
    //         exit('out');
    //     }
    // }

    // ____________________________________________________________________________________________________________________________
    // public function loadpenerima1()
    // {
    //     if ($this->request->isAJAX()) {
    //         $penerima1 = $this->deklarModel->satuID(' penerima', $this->request->getVar('penerima'), '', 'id');
    //         $isipenerima = "";
    //         $isipenerima .= '<option value="">' . lang("app.pilihsr") . '</option>';
    //         if (!empty($penerima1)) $isipenerima .= '<option value="' . $penerima1[0]->id . '" selected >' .  $penerima1[0]->kode . " => " . $penerima1[0]->nama . '</option>';
    //         $data = ['penerima' => $isipenerima];
    //         echo json_encode($data);
    //     } else {
    //         exit('out');
    //     }
    // }

    // ____________________________________________________________________________________________________________________________
    // public function loadruas()
    // {
    //     if ($this->request->isAJAX()) {
    //         $sruas = $this->request->getVar('ruas');
    //         $proyek = ($this->request->getVar('proyek') != '' ? $this->request->getVar('proyek') : '-');
    //         $ruas = $this->deklarModel->getRuas('', $this->request->getVar('pilih'), 't', $proyek);
    //         $isiruas = "";
    //         $isiruas .= '<option value="">' . lang("app.pilih-") . '</option>';
    //         foreach ($ruas as $db) :
    //             $terpilih = "";
    //             if ($db->id == $sruas) $terpilih = 'selected';
    //             $isiruas .= '<option value="' . $db->id . '" data-kode="' . $db->kode . '" ' . $terpilih . '>' . $db->kode . " => " . $db->nama . '</option>';
    //         endforeach;
    //         $data = ['ruas' => $isiruas];
    //         echo json_encode($data);
    //     } else {
    //         exit('out');
    //     }
    // }






    // // ____________________________________________________________________________________________________________________________
    // // public function loadtanah()
    // // {
    // //     if ($this->request->isAJAX()) {
    // //         if ($this->request->isAJAX()) {
    // //             $tanah = $this->deklarModel->loadTanah($this->request->getVar('searchTerm'), '', '');
    // //             $tanahdata = array();
    // //             $tanahdata[] = array('id' => '', 'text' => lang("app.pilihsr"));
    // //             foreach ($tanah as $row) {
    // //                 $tanahdata[] = array('id' => $row->id, 'text' => $row->kode . " => " . $row->nama);
    // //             }
    // //             echo json_encode($tanahdata);
    // //         } else {
    // //             exit('out');
    // //         }
    // //     }
    // // }

    // // ____________________________________________________________________________________________________________________________
    // public function modalBeban()
    // {
    //     if ($this->request->isAJAX()) {
    //         $perus = $this->request->getVar('perusahaan');
    //         $wil = $this->request->getVar('wilayah');
    //         $div = $this->request->getVar('divisi');
    //         $beban = $this->request->getVar('beban');
    //         switch ($beban) {
    // case 'proyek':
    //                 $data = [
    //                     'proyek' => $this->mainModel->loadProyek($this->request->getVar('isi'), $perus, $wil, $div),
    //                     'wenbrako' => $this->request->getVar('wenbrako'),
    //                     'tuser' => $this->user,
    //                 ];
    //                 $alamat = 'select_proyek';
    //                 break;
    //             case 'cabang':
    //                 $data = [
    //                     'cabang' => $this->deklarModel->loadCamp($this->request->getVar('isi'), $this->request->getVar('perusahaan'), $this->request->getVar('wilayah'), $this->request->getVar('divisi')),
    //                     'wenbrako' => $this->request->getVar('wenbrako'),
    //                     'tuser' => $this->user,
    //                 ];
    //                 $alamat = 'select_camp';
    //                 break;

    //             case "alat tool":
    //                 $data = [
    //                     'alat' => $this->deklarModel->loadAlat($this->request->getVar('isi'), 'tool', $this->request->getVar('perusahaan'), $this->request->getVar('wilayah'), $this->request->getVar('divisi')),
    //                     'wenbrako' => $this->request->getVar('wenbrako'),
    //                     'tuser' => $this->user,
    //                 ];
    //                 $alamat = 'select_alat';
    //                 break;
    //                 // case "alat":
    //                 //     $data = [
    //                 //         'alat' => $this->deklarModel->loadAlat($this->request->getVar('isi'), 'pribadi', $this->request->getVar('perusahaan'), $this->request->getVar('wilayah'), $this->request->getVar('divisi')),
    //                 //         'wenbrako' => $this->request->getVar('wenbrako'),
    //                 //         'tuser' => $this->user,
    //                 //     ];
    //                 //     $alamat = 'select_alat';
    //                 //     break;
    //             case 'tanah bangunan':
    //                 $data = [
    //                     'tanah' => $this->deklarModel->loadTanah($this->request->getVar('isi'), $this->request->getVar('perusahaan'), $this->request->getVar('wilayah'), $this->request->getVar('divisi')),
    //                     'wenbrako' => $this->request->getVar('wenbrako'),
    //                     'tuser' => $this->user,
    //                 ];
    //                 $alamat = 'select_tanah';
    //                 break;
    //             default:
    //                 $data = [];
    //                 $alamat = 'select_kosong';
    //                 break;
    //         }
    //         $msg = ['data' => view('x-modal/' . $alamat, $data)];
    //         echo json_encode($msg);
    //     } else {
    //         exit('out');
    //     }
    // }

    // // ____________________________________________________________________________________________________________________________
    // public function modalproyek()
    // {
    //     if ($this->request->isAJAX()) {
    //         $data = [
    //             'proyek' => $this->deklarModel->loadProyek($this->request->getVar('isi'), $this->request->getVar('perusahaan'), $this->request->getVar('wilayah'), $this->request->getVar('divisi')),
    //             'wenbrako' => $this->request->getVar('wenbrako'), // wilayah penerima nilai beban ruas(sd) anggaran kelakun nol       
    //             'tuser' => $this->user,
    //         ];
    //         $msg = ['data' => view('x-modal/select_proyek', $data)];
    //         echo json_encode($msg);
    //     } else {
    //         exit('out');
    //     }
    // }

    // // ____________________________________________________________________________________________________________________________
    // public function modalcamp()
    // {
    //     if ($this->request->isAJAX()) {
    //         $data = [
    //             'camp' => $this->deklarModel->loadCamp($this->request->getVar('isi'), $this->request->getVar('perusahaan'), $this->request->getVar('wilayah'), $this->request->getVar('divisi')),
    //             'wenbrako' => $this->request->getVar('wenbrako'),
    //             'tuser' => $this->user,
    //         ];
    //         $msg = ['data' => view('x-modal/select_camp', $data)];
    //         echo json_encode($msg);
    //     } else {
    //         exit('out');
    //     }
    // }

    // // ____________________________________________________________________________________________________________________________
    // // public function modalalat()
    // // {
    // //     if ($this->request->isAJAX()) {
    // //         $data = [
    // //             'alat' => $this->deklarModel->loadAlat($this->request->getVar('isi'), $this->request->getVar('pilih'), $this->request->getVar('perusahaan'), $this->request->getVar('divisi')),
    // //             'wenbrako' => $this->request->getVar('wenbrako'),
    // //             'tuser' => $this->user,
    // //         ];
    // //         $msg = ['data' => view('x-modal/select_alat', $data)];
    // //         echo json_encode($msg);
    // //     } else {
    // //         exit('out');
    // //     }
    // // }

    // // ____________________________________________________________________________________________________________________________
    // public function modalbarang()
    // {
    //     if ($this->request->isAJAX()) {
    //         $jenis = (($this->request->getVar('jenis') == '1') || ($this->request->getVar('jenis') == 'on') ? 'on' : 'off');
    //         $data = ['barang' => ($jenis == 'on' ? $this->deklarModel->satuID('m_barang', $this->request->getVar('isi'), '', 'id') : '')];
    //         $msg = ['data' => view('x-modal/show_item', $data)];
    //         echo json_encode($msg);
    //     } else {
    //         exit('out');
    //     }
    // }

    // // ____________________________________________________________________________________________________________________________
    // public function modalpenerima()
    // {
    //     if ($this->request->isAJAX()) {
    //         $data = ['penerima' => $this->deklarModel->satuID('m_penerima', $this->request->getVar('isi'), '', 'id')];
    //         $msg = ['data' => view('x-modal/show_penerima', $data)];
    //         echo json_encode($msg);
    //     } else {
    //         exit('out');
    //     }
    // }

    // // ____________________________________________________________________________________________________________________________
    // public function tabelbarang()
    // {
    //     if ($this->request->isAJAX()) {
    //         $kategori = ($this->request->getVar('kategori') != 'all' ? $this->request->getVar('kategori') : '');
    //         $data = [
    //             'barang' => $this->deklarModel->getBarang($this->urls[1], $this->request->getVar('menu'), $kategori),
    //             'menu' => $this->request->getVar('menu'),
    //             'ihid' => $this->request->getVar('ihid'),
    //             'bhid' => $this->request->getVar('bhid'),
    //         ];
    //         $msg = ['data' => view('x-file/barang_tabel', $data)];
    //         echo json_encode($msg);
    //     } else {
    //         exit('out');
    //     }
    // }
    // ____________________________________________________________________________________________________________________________

}
