<?php

namespace App\Controllers\proyek\anggaran;

use Config\App;
use App\Controllers\BaseController;
use App\Models\proyek\BudgetindukModel;

class Accbudget extends BaseController
{
    protected $budgetindukModel;

    public function __construct()
    {
        $this->budgetindukModel = new BudgetindukModel();
    }

    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        (!preg_match("/119/i", $this->session->menu->menu_1)) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $data = [
            't_menu' => lang("app.tt_accanggaran"),
            't_submenu' => '',
            't_icon' => '<i class="fa fa-book ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-book"></i>',
            't_dir1' => lang("app.anggaran"),
            't_dirac' => lang("app.tandat"),
            't_link' => '/accbudget',
            'perusahaan' => $this->deklarModel->getPerusahaan('t'),
            'wilayah' => $this->deklarModel->getDivisi('wilayah', 't'),
            'menu' => 'accbudget',
            'asal' => 'acc',
            'lt' => '10',
            'tuser' => $this->user,
        ];

        return view('proyek/anggaran/budget_view', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function showdata($idunik)
    {
        // (!preg_match("/122/i", $this->session->menu->menu_1)) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $db1 = $this->deklarModel->satuID('budget_induk', $idunik);
        $proyek = (empty(!$db1)) ? $db1['0']->proyek_id : '';
        $ruas = (empty(!$db1)) ? $db1['0']->ruas_id : '';

        $data = [
            't_menu' => lang("app.tt_accanggaran"),
            't_submenu' => '',
            't_icon' => '<i class="fa fa-book ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-book"></i>',
            't_dir1' => lang("app.anggaran"),
            't_dirac' => lang("app.tandat"),
            't_link' => '/accbudget',
            'idunik' => $idunik,
            'perusahaan' => $this->deklarModel->getPerusahaan('t'),
            'wilayah' => $this->deklarModel->getDivisi('wilayah', 't'),
            'divisi' => $this->deklarModel->getDivisi('divisi', 't', 't'),
            'budget' => $this->deklarModel->satuID('budget_induk', $idunik),
            'proyek1' => $this->deklarModel->satuID('m_proyek', $proyek, 't'),
            'ruas1' => $this->deklarModel->satuID('m_ruas', $ruas, 't'),
            'tuser' => $this->user,
        ];

        ((empty($data['budget'])) && (empty($data['idu']))) && throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('proyek/anggaran/accbudget_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function savedokumen()
    {

        var_dump("aa");
        die;
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();

            $rule_akses = 'permit_empty';
            $status = '2';

            $rule_lampiran = ($this->request->getFile('lampiran')) ? 'uploaded[lampiran]|max_size[lampiran,2048]|ext_in[lampiran,pdf]' : 'permit_empty';
            if (!$this->validate([
                'akses' => [
                    'rules' => $rule_akses,
                    'errors' => [
                        'required' => lang("app.errnoakses"),
                    ]
                ],
                'cabang' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang("app.errblank"),
                    ]
                ],
            ])) {
                $msg = [
                    'error' => [
                        'akses' => $validation->getError('akses'),
                        'beban' => $validation->getError('cabang'),
                    ]
                ];
            } else {
                $param = $this->deklarModel->satuID('m_konfigurasi', '4', 't', 't');
                $db1 = $this->deklarModel->satuID('budget_induk', $this->request->getVar('idunik'));
                $proyek1 = $this->deklarModel->satuID('m_proyek', $db1['0']->proyek_id, 't');
                $ruas1 = $this->deklarModel->satuID('m_ruas', $db1['0']->ruas_id, 't');

                if (empty(!$db1)) {
                    $this->budgetindukModel->save([
                        'id' => $db1['0']->id,
                        'tanggal1' => $this->request->getVar('tanggal1'),
                        'tanggal2' => $this->request->getVar('tanggal2'),
                        'st_confirm' => '1',
                    ]);
                }
                $this->logModel->saveLog('/budgetbiayal', $db1['0']->id, 'Save', $proyek1['0']->kode . ' => ' . $ruas1['0']->kode);
                $msg = ['sukses' => $db1['0']->nodoc . ' ' . lang("app.judulsimpan"), 'perus' => $db1['0']->perusahaan_id, 'div' => $db1['0']->divisi_id];


                $this->logModel->saveLog('/budgetbiayal', $db['0']->id, 'Cancel', $proyek1['0']->kode . ' => ' . $ruas1['0']->kode);
                $this->session->setflashdata(['judul' => $proyek1['0']->kode . ' => ' . $ruas1['0']->kode . ' ' . lang("app.judulbatal"), 'perus' => $proyek1['0']->perusahaan_id, 'wil' => $proyek1['0']->wilayah_id, 'tahun' => $proyek1['0']->periode1]);
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
