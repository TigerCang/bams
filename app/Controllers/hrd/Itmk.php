<?php

namespace App\Controllers\hrd;

use Config\App;
use App\Controllers\BaseController;
use App\Models\hrd\HrdcutiModel;

class Itmk extends BaseController
{
    protected $hrdcutiModel;

    public function __construct()
    {
        $this->hrdcutiModel = new HrdcutiModel();
    }

    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        // (!preg_match("/118/i", $this->session->menu->menu_1)) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();      
        $db2 = $this->deklarModel->getBiodata($this->session->menu->id);
        $pegawai = (!empty($db2)) ? $db2['0']->id : '';

        $data = [
            't_menu' => lang("app.tt_ijincuti"),
            't_submenu' => '',
            't_icon' => '<i class="fa fa-money ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-money"></i>',
            't_dir1' => lang("app.mintakas"),
            't_dirac' => lang("app.kaslangsung"),
            't_link' => '/itmk',
            'menu' => 'itmk',
            'tandat' => '0',
            'mode' => '',
            'peminta' => $this->session->username,
            'pegawai' => $pegawai,
            'tuser' => $this->user,
        ];

        return view('hrd/mintacuti_view', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function crany()
    {
        do {
            $idu = buatid('60');
            $db = $this->deklarModel->satuID('hrd_cuti', $idu);
        } while (!empty($db));

        $this->iduModel->saveID($idu);
        return redirect()->to('/itmk/input/' . $idu);
    }

    // ____________________________________________________________________________________________________________________________
    public function showdata($idunik)
    {
        // (!preg_match("/118/i", $this->session->menu->menu_1)) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();      
        $db1 = $this->deklarModel->satuID('hrd_cuti', $idunik);
        $db2 = $this->deklarModel->getBiodata($this->session->menu->id);
        empty($db2) && throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $ticon = (!empty($db1) && $db1['0']->id != '0') ? '<i class="fa fa-money ' . lang("app.xdetil") . '"></i>' : '<i class="fa fa-money ' . lang("app.xinput") . '"></i>';
        $perusahaan = empty($db1) ? $db2['0']->perusahaan_id : $db1['0']->perusahaan_id;
        $divisi = empty($db1) ? $db2['0']->divisi_id : $db1['0']->divisi_id;
        $wilayah = empty($db1) ? $db2['0']->wilayah_id : $db1['0']->wilayah_id;
        $pegawai = empty($db1) ? $db2['0']->id : $db1['0']->pegawai_id;
        $revisi = "n";

        $data = [
            't_menu' => lang("app.tt_ijincuti"),
            't_submenu' => '',
            't_icon' => $ticon,
            't_diricon' => '<i class="fa fa-money"></i>',
            't_dir1' => lang("app.mintakas"),
            't_dirac' => lang("app.cuti"),
            't_link' => '/itmk',
            'idu' => $this->iduModel->cekID($idunik),
            'idunik' => $idunik,
            'perusahaan' => $this->deklarModel->getPerusahaan('t'),
            'wilayah' => $this->deklarModel->getDivisi('wilayah', 't'),
            'divisi' => $this->deklarModel->getDivisi('divisi', 't'),
            'kategori' => $this->deklarModel->getDivisi('cuti', 't'),
            'nodoc' => $this->deklarModel->cekForm('dokumen', 'cuti', 't', '', '', ''),
            'minta' => $this->deklarModel->satuID('hrd_cuti', $idunik),
            'pegawai' => $this->deklarModel->satuID('m_pegawai', $db2['0']->idunik),
            'perusahaan1' => $this->deklarModel->satuID('m_perusahaan', $perusahaan, 't'),
            'divisi1' => $this->deklarModel->satuID('m_divisi', $divisi, 't'),
            'wilayah1' => $this->deklarModel->satuID('m_divisi', $wilayah, 't'),
            'pegawai1' => $this->deklarModel->satuID('m_pegawai', $pegawai, 't'),
            'revisi' => $revisi,
            'menu' => 'itmk',
            'tuser' => $this->user,
        ];

        (empty($data['nodoc']) || (empty($data['minta']) && empty($data['idu']))) && throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('hrd/cuti_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function savedata($idunik)
    {
        $db1 = $this->deklarModel->satuID('hrd_cuti', $idunik);
        $rule_pegawai = empty($db1) ? 'required' : 'permit_empty';
        $rule_tanggal = $this->request->getVar('tanggalak') < $this->request->getVar('tanggalaw') ? 'required' : 'permit_empty';
        // $selisihDetik = strtotime($this->request->getVar('tanggalak')) - strtotime($this->request->getVar('tanggalaw'));
        // $selisihHari = abs($selisihDetik / (60 * 60 * 24)) + 1;

        $selisihHari = 0;
        $tanggalPerhitungan = strtotime($this->request->getVar('tanggalaw'));
        while ($tanggalPerhitungan <= strtotime($this->request->getVar('tanggalak'))) {
            $tanggal = date('Y-m-d', $tanggalPerhitungan);
            $dbt = $this->deklarModel->getTanggal($tanggal);
            if (empty($dbt)) $selisihHari++;
            $tanggalPerhitungan = strtotime('+1 day', $tanggalPerhitungan);
        }
        if ($this->request->getVar('lama') != '0' && $this->request->getVar('lama') != $selisihHari) $rule_tanggal = 'required';

        $validationRules = [
            'pegawai' => [
                'rules' => $rule_pegawai,
                'errors' => [
                    'required' => lang("app.errpilih"),
                ]
            ],
            'kategori' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang("app.errpilih"),
                ]
            ],
            'tglak' => [
                'rules' => $rule_tanggal,
                'errors' => [
                    'required' => lang("app.errunik3"),
                ]
            ],
            'catatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang("app.errblank"),
                ]
            ],
            'lampiran' => [
                'rules' => 'max_size[lampiran,1024]|is_image[lampiran]|mime_in[lampiran,image/jpg,image/jpeg,image/bmp,image/png]',
                'errors' => [
                    'max_size' => lang("app.errfilebesar1"),
                    'is_image' => lang("app.errnotimg"),
                    'mime_in' => lang("app.errfileext"),
                ]
            ],
        ];
        if (!$this->validate($validationRules)) return redirect()->to('/itmk/input/' . $idunik)->withInput();

        $param = $this->deklarModel->satuID('m_konfigurasi', '5', 't');
        $berkaslampiran = $this->request->getFile('lampiran');
        $nama_berkas = ($berkaslampiran->getError() == 4) ? $this->request->getVar('gambarlama') : $berkaslampiran->getName();
        if ($berkaslampiran->getError() != 4) $berkaslampiran->move('assets/lampiran-hrd/' . $param['0']->nilai . '/', $nama_berkas);
        if ($this->request->getVar('gambarlama') != 'default.png' && $berkaslampiran->getError() != 4) unlink('assets/lampiran-hrd/' . $param['0']->nilai . '/' . $this->request->getVar('gambarlama'));

        $nomordokumen = $this->request->getVar('nodoc');
        if ($this->request->getVar('nodoc') == "") {
            $db = $this->tranModel->getNomordoc('hrd_cuti', $this->request->getVar('kui'), "-" . substr($this->request->getVar('tanggal'), 2, 2));
            $nomor = (empty($db['0']->nodoc)) ? "1" : substr($db['0']->nodoc, -4) + 1;
            $nomordokumen = nodokumen($this->request->getVar('kui'), $this->request->getVar('tanggal'), $nomor);
        }

        $act = empty($db1) ? "Create" : "Update";
        $savj = empty($db1) ? lang("app.judulsimpan") : lang("app.judulubah");
        $id = empty($db1) ? '' : $db1[0]->id;

        $this->hrdcutiModel->save([
            'id' => $id,
            'idunik' => $idunik,
            'perusahaan_id' => $this->request->getVar('idperusahaan'),
            'wilayah_id' => $this->request->getVar('idwilayah'),
            'divisi_id' => $this->request->getVar('iddivisi'),
            'userid' => $this->session->username,
            'pegawai_id' => $this->request->getVar('idpegawai'),
            'nodoc' => $nomordokumen,
            'tgl_minta' => $this->request->getVar('tanggal'),
            'tgl_cuti1' => $this->request->getVar('tanggalaw'),
            'tgl_cuti2' => $this->request->getVar('tanggalak'),
            'lama' => $selisihHari,
            'cuti_id' => $this->request->getVar('kategori'),
            'status' => '0',
            'catatan' => $this->request->getVar('catatan'),
            'lampiran' => $nama_berkas,
        ]);

        $menu = $this->deklarModel->satuID('hrd_cuti', $idunik);
        $this->logModel->savelog('/itmk', $menu['0']->id, $act, $nomordokumen);
        $this->session->setFlashdata(['judul' => $nomordokumen . " " . $savj]);
        return redirect()->to('/itmk');
    }

    // ____________________________________________________________________________________________________________________________
    public function loadpegawai()
    {
        if ($this->request->isAJAX()) {
            $pegawai = $this->request->getvar('pegawai');
            $data = ['pegawai' => $this->deklarModel->satuID('m_pegawai', $pegawai, 't'),];
            $msg = $data;
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
