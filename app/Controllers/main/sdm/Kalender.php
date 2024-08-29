<?php

namespace App\Controllers\main\sdm;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\KalenderModel;

class Kalender extends BaseController
{
    protected $kalenderModel;
    public function __construct()
    {
        $this->kalenderModel = new KalenderModel();
    }

    public function index()
    {
        checkPage('102');
        $data = [
            't_judul' => lang('app.kalender'), 't_span' => lang('app.span kalender'), 'link' => '/kalender',
            'kalender' => $this->mainModel->getKalender('2024'),
        ];
        $this->render('main/sdm/kalender_list', $data);
    }

    public function inputData()
    {
        if ($this->request->isAJAX()) {
            checkPage('102', '', 'y', 'n');
            $data = [
                't_modal' => lang('app.kalender'), 'link' => "/kalender",
                'tuser' => $this->user,
            ];
            $msg = ['data' => view('main/sdm/kalender_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    public function saveData()
    {
        if ($this->request->isAJAX()) {

            var_dump($this->request->getVar('tanggalaw'), $this->request->getVar('deskripsi'));
            die;
            $validationRules = [
                'tanggalaw' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'deskripsi' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'tanggalaw' => $this->validation->getError('tanggalaw'),
                        'nama' => $this->validation->getError('nama'),
                    ]
                ];
            } else {
                //Simpan
                if ($this->request->getVar('postaction') == 'save') {
                    $tglawal = strtotime($this->request->getVar('tanggalaw'));
                    $tglakhir = strtotime($this->request->getVar('tanggalak'));
                    $hariInput = date('N', strtotime($this->request->getVar('tanggalaw')));
                    $tanggalHari = array();
                    do {
                        $hari = date('N', $tglawal);
                        if ($hari == $hariInput) $tanggalHari[] = date('Y-m-d', $tglawal);
                        $tglawal = strtotime('+1 day', $tglawal);
                    } while ($tglawal <= $tglakhir);

                    $data = [
                        'nama' => $this->request->getVar('nama'),
                        'potong_cuti' => ($this->request->getVar('potcuti') == 'on' ? '1' : '0'),
                        'updated_by' => $this->user['id'],
                    ];
                    foreach ($tanggalHari as $tanggal) {
                        $db = $this->deklarModel->getTanggal($tanggal);
                        if (empty($db)) $this->kalenderModel->save(['tanggal' => $tanggal] + $data);
                    }
                    $menu = $this->deklarModel->lastID('m_kalender');
                    $strtanggal = date('d-m-Y', strtotime($this->request->getVar('tanggalaw')));
                    $this->logModel->saveLog('Save', $menu[0]->id, $strtanggal);
                }
                $msg = ['sukses' => $strtanggal . " " . lang("app.judulsimpan")];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function deletedata()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $this->kalenderModel->delete($id);
            $this->logModel->saveLog('Save', $id, $this->request->getVar('tanggal') . " hapus");
            $msg = ['sukses' => date('d-m-Y', strtotime($this->request->getVar('tanggal'))) . ' ' . lang("app.judulhapus")];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function tabeldata()
    {
        if ($this->request->isAJAX()) {
            $data = ['kalender' => $this->deklarModel->getKalender($this->request->getVar('tahun'))];
            $msg = ['data' => view('x-file/kalender_tabel', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
