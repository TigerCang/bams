<?php

namespace App\Controllers\tritem\pembelian;

use Config\App;
use App\Controllers\BaseController;
use App\Models\tritem\POtawarModel;
use App\Models\tritem\POpilihModel;

class Pilihharga extends BaseController
{
    protected $potawarModel;
    protected $popilihModel;
    public function __construct()
    {
        $this->potawarModel = new POtawarModel();
        $this->popilihModel = new POpilihModel();
    }

    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        // (!preg_match("/107/i", $this->menu['menu_1'])) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $data = [
            't_menu' => strtoupper(lang("app.pilihharga")), 't_submenu' => '',
            't_icon' => '<i class="icofont icofont-touch ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-product-hunt"></i>', 't_dir1' => lang("app.pembelian"), 't_dirac' => lang("app.pilihharga"), 't_link' => '/pilihharga',
            'menu' => 'pilihharga', 'baru' => 'hidden', 'filstat' => 'hidden', 'filcek' => 'hidden',
            'perusahaan' => $this->deklarModel->getPerusahaan('', 't'),
            'divisi' => $this->deklarModel->getDivisi('', 'divisi', 't'),
            'btnclascr' => lang('app.btncCreate'), 'btntextcr' => lang('app.btnCreate'),
            'actcreate' => ($this->user['act_create'] == '0' ? 'hidden' : ''),
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        return view('tritem/pembelian/mintabarang_view', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function showdata($idunik)
    {
        // (!preg_match("/126/i", $this->menu['menu_1'])) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $db1 = $this->deklarModel->satuID('po_minta', $idunik);
        $data = [
            't_menu' => strtoupper(lang("app.pilihharga")), 't_submenu' => '',
            't_icon' => '<i class="icofont icofont-touch ' . lang("app.xinput") . '"></i>',
            't_diricon' => '<i class="fa fa-product-hunt"></i>', 't_dir1' => lang("app.pembelian"), 't_dirac' => lang("app.pilihharga"), 't_link' => '/pilihharga',
            'idunik' => $idunik,
            'perusahaan' => $this->deklarModel->getPerusahaan('', 't'),
            'wilayah' => $this->deklarModel->getDivisi('', 'wilayah', 't'),
            'divisi' => $this->deklarModel->getDivisi('', 'divisi', 't'),
            'anak' => $this->tranModel->getPOanak($db1[0]->id),
            'user1' => $this->deklarModel->get1User($db1[0]->peminta_id),
            'selnama' => $this->deklarModel->distSelect('beban'),
            'minta' => $db1,
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        (empty($data['minta'])) && throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($data['minta']) {
            if ($this->user['act_perusahaan'] == "0" && !preg_match("/," . $data['minta'][0]->perusahaan_id . ",/i", $this->user['perusahaan'])) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
            if ($this->user['act_wilayah'] == "0" && !preg_match("/," . $data['minta'][0]->wilayah_id . ",/i", $this->user['wilayah'])) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
            if ($this->user['act_divisi'] == "0" && !preg_match("/," . $data['minta'][0]->divisi_id . ",/i", $this->user['divisi'])) throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        }
        if ($db1) $this->logModel->saveLog('Read', $idunik, $db1[0]->nodoc, '-');
        return view('tritem/pembelian/pilihharga_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function pilihpenawaran()
    {
        if ($this->request->isAJAX()) {
            $this->deklarModel->updateData('po_tawar', 'st_pilih', '0', 'poanak_id', $this->request->getVar('anak'));
            $this->deklarModel->updateData('po_tawar', 'st_pilih', '1', 'id', $this->request->getVar('id'));
            $dbanak = $this->deklarModel->satuID('po_anak', $this->request->getVar('anak'), '', 'id');
            $dbminta = $this->deklarModel->satuID('po_minta', $dbanak[0]->pominta_id, '', 'id');

            $this->popilihModel->save([
                'pominta_id' => $dbminta[0]->id,
                'poanak_id' => $this->request->getVar('anak'),
                'potawar_id' => $this->request->getVar('id'),
                'selected_by' => $this->user['id'],
            ]);
            $this->logModel->saveLog('Add', $dbminta[0]->idunik, "{$dbminta[0]->nodoc} => " . $this->request->getVar('suplier'));
            $msg = ['sukses' => $this->request->getVar('suplier') . " " . lang("app.judulpilih")];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
