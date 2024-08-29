<?php

namespace App\Controllers\file\sdm;

use Config\App;
use App\Controllers\BaseController;

class Pengumuman extends BaseController
{
    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        (!preg_match("/149/i", $this->menu['menu_1'])) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $data = [
            't_menu' => strtoupper(lang("app.pengumuman")), 't_submenu' => '',
            't_icon' => '<i class="fa fa-newspaper-o ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="icofont icofont-support"></i>', 't_dir1' => lang("app.sdm"), 't_dirac' => lang("app.pengumuman"), 't_link' => '/pengumuman',
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        return view('file/sdm/pengumuman_view', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function savedata()
    {
        if (!$this->validate([
            'filepdf' => [
                'rules' => 'uploaded[filepdf]|max_size[filepdf,10240]|ext_in[filepdf,pdf]',
                'errors' => ['max_size' => lang("app.errblank"), 'uploaded' => lang("app.errnotimg"), 'ext_in' => lang("app.errextin")]
            ]
        ])) {
            return redirect()->to('/pengumuman')->withInput();
        }
        unlink('assets/pengumuman'); //hapus file lama
        $filepdf = $this->request->getFile('filepdf'); //ambil image
        $filepdf->move('assets'); //pindahkan file ke folder yg dituju
        $namapdf = $filepdf->getName(); // get namafile
        rename("assets/" . $namapdf, "assets/pengumuman");
        $this->logModel->savelog('Upload', '', $namapdf);
        $this->session->setFlashdata(['judul' => lang("app.simpanjudul"), 'pesan' => lang("app.simpandata") . ' ' . $namapdf . ' ' . lang("app.sukses")]);
        return redirect()->to('/pengumuman');
    }
}
