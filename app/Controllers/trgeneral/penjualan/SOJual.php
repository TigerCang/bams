<?php

namespace App\Controllers\umum\penjualan;

use Config\App;
use App\Controllers\BaseController;
use App\Models\umum\SalesindukModel;
use App\Models\umum\SalesanakModel;

class SOJual extends BaseController
{
    protected $salesindukModel;
    protected $salesanakModel;
    public function __construct()
    {
        $this->salesindukModel = new SalesindukModel();
        $this->salesanakModel = new SalesanakModel();
    }

    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        // (!preg_match("/123/i", $this->session->menu->menu_1)) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $data = [
            't_menu' => lang("app.tt_orderpenj"), 't_submenu' => '',
            't_icon' => '<i class="icofont icofont-cart-alt ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="icofont icofont-cart-alt"></i>', 't_dir1' => lang("app.penjualan"), 't_dirac' => lang("app.pesanjual"), 't_link' => '/sojual',
            'menu' => 'sojual', 'asal' => 'jual', 'hid' => '', 'cepsa' => '11111',
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        return view('umum/penjualan/sojual_view', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function crany()
    {
        do {
            $idu = buatid();
            $db = $this->deklarModel->satuID('sales_induk', $idu);
        } while ($db);
        $this->iduModel->saveID($idu);
        return redirect()->to('/sojual/input/' . $idu);
    }

    // ____________________________________________________________________________________________________________________________
    public function showdata($idunik)
    {
        // (!preg_match("/123/i", $this->session->menu->menu_1)) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $db1 = $this->deklarModel->satuID('sales_induk', $idunik);
        $data = [
            't_menu' => lang("app.tt_orderpenj"), 't_submenu' => '',
            't_icon' => '<i class="icofont icofont-cart-alt ' . lang("app.xinput") . '"></i>',
            't_diricon' => '<i class="icofont icofont-cart-alt"></i>', 't_dir1' => lang("app.penjualan"), 't_dirac' => lang("app.pesanjual"), 't_link' => '/sojual',
            'idu' => $this->iduModel->cekID($idunik), 'idunik' => $idunik,
            'perusahaan' => $this->deklarModel->getPerusahaan('', 't'),
            'wilayah' => $this->deklarModel->getDivisi('', 'wilayah', 't'),
            'divisi' => $this->deklarModel->getDivisi('', 'divisi', 't'),
            'selitem' => $this->deklarModel->distSelect('itemso'),
            'satuan' => $this->deklarModel->getDivisi('', 'satuan', 't'),
            'jasaso' => $this->deklarModel->distItem('sales_anak', 'namajasa'),
            'camp1' => $this->deklarModel->satuID('m_camp', $db1['0']->camp_id ?? '', 'id'),
            'proyek1' => $this->deklarModel->satuID('m_proyek', $db1['0']->proyek_id ?? '', 'id'),
            'penerima1' => $this->deklarModel->satuID('m_penerima', $db1['0']->penerima_id ?? '', 'id'),
            'katalat' => $this->deklarModel->getDivisi('', 'katalat', 't'),
            'selbentuk' => $this->deklarModel->distSelect('bentuk'),
            'menu' => 'sojual', 'cja' => '101', //camp jasa aksi
            'jual' => $db1,
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        return view('umum/penjualan/sojual_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function tambahdata()
    {
        if ($this->request->isAJAX()) {
            // $cek = $this->tranModel->cekSalesinduk($this->request->getVar('nodoc'), $this->request->getVar('idunik'));
            // $rule_akses = (!empty($cek) ? 'required' : 'permit_empty');
            // $dbcamp = $this->deklarModel->satuID('m_camp', $this->request->getVar('idcamp'), 'id');
            // $rule_perusahaan = (!empty($dbcamp) ? ($this->request->getVar('idperusahaan') == $dbcamp['0']->perusahaan_id ? 'required' : 'valid_email') : 'required');
            // $rule_wilayah = (!empty($dbcamp) ? ($this->request->getVar('idwilayah') == $dbcamp['0']->wilayah_id ? 'required' : 'valid_email') : 'required');
            // $rule_divisi = (!empty($dbcamp) ? ($this->request->getVar('iddivisi') == $dbcamp['0']->divisi_id ? 'required' : 'valid_email') : 'required');

            if (empty($this->request->getVar('idcamp'))) {
                $cekbeban = $this->deklarModel->satuID('m_camp', $this->request->getVar('idcamp'), 'id', 't');
                $rule_perusahaan = ($cekbeban ? ($this->request->getVar('idperusahaan') == $cekbeban['0']->perusahaan_id ? 'required' : 'valid_email') : 'required');
                $rule_wilayah = ($cekbeban ? ($this->request->getVar('idwilayah') == $cekbeban['0']->wilayah_id ? 'required' : 'valid_email') : 'required');
                $rule_divisi = ($cekbeban ? ($this->request->getVar('iddivisi') == $cekbeban['0']->divisi_id ? 'required' : 'valid_email') : 'required');
            } else {
                $rule_perusahaan = $rule_wilayah = $rule_divisi = 'required';
            }

            $rule_barang = $rule_alat = $rule_tanah = $rule_inventaris = 'permit_empty';
            switch ($this->request->getVar('xdata')) {
                case 'stok':
                    $rule_barang = 'required';
                    break;
                case 'alat':
                    $rule_alat = 'required';
                    break;
                case 'tanah':
                    $rule_tanah = 'required';
                    break;
                case 'inventaris':
                    $rule_inventaris = 'required';
                    break;
            }

            $validationRules = [
                // 'akses' => [
                //     'rules' => $rule_akses,
                //     'errors' => ['required' => lang("app.errunik2")]
                // ],
                'idperusahaan' => [
                    'rules' => $rule_perusahaan,
                    'errors' => ['required' => lang("app.errpilih"), 'valid_email' => lang("app.errunik3")]
                ],
                'idwilayah' => [
                    'rules' => $rule_wilayah,
                    'errors' => ['required' => lang("app.errpilih"), 'valid_email' => lang("app.errunik3")]
                ],
                'iddivisi' => [
                    'rules' => $rule_divisi,
                    'errors' => ['required' => lang("app.errpilih"), 'valid_email' => lang("app.errunik3")]
                ],
                'penerima' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'barang' => [
                    'rules' => $rule_barang,
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'alat' => [
                    'rules' => $rule_alat,
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'tanah' => [
                    'rules' => $rule_tanah,
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'inventaris' => [
                    'rules' => $rule_inventaris,
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'jasa' => [
                    'rules' => 'permit_empty',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'bentuk' => [
                    'rules' => 'permit_empty',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'kategori' => [
                    'rules' => 'permit_empty',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'satuan2' => [
                    'rules' => 'permit_empty',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'total' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
                'catatan' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'akses' => $this->validation->getError('akses'),
                        'perusahaan' => $this->validation->getError('idperusahaan'),
                        'wilayah' => $this->validation->getError('idwilayah'),
                        'divisi' => $this->validation->getError('iddivisi'),
                        'penerima' => $this->validation->getError('penerima'),
                        'barang' => $this->validation->getError('barang'),
                        'alat' => $this->validation->getError('alat'),
                        'tanah' => $this->validation->getError('tanah'),
                        'inventaris' => $this->validation->getError('inventaris'),
                        'jasa' => $this->validation->getError('jasa'),
                        'bentuk' => $this->validation->getError('bentuk'),
                        'kategori' => $this->validation->getError('kategori'),
                        'satuan2' => $this->validation->getError('satuan2'),
                        'total' => $this->validation->getError('total'),
                        'catatan' => $this->validation->getError('catatan'),
                    ]
                ];
            } else {
                $salesinduk1 = $this->deklarModel->satuID('sales_induk', $this->request->getVar('idunik'));
                if (empty($salesinduk1)) {
                    $this->salesindukModel->save([
                        'idunik' =>  $this->request->getVar('idunik'),
                        'perusahaan_id' => $this->request->getVar('idperusahaan'),
                        'wilayah_id' => $this->request->getVar('idwilayah'),
                        'divisi_id' => $this->request->getVar('iddivisi'),
                        'modeorder' => 'jual',
                        'camp_id' => $this->request->getVar('idcamp'),
                        'tanggal' => $this->request->getVar('tanggal'),
                        'penerima_id' =>  $this->request->getVar('penerimaid'),
                        'proyek_id' => $this->request->getVar('idproyek'),
                        'pilihdata' => $this->request->getVar('xdata'),
                        'is_pajak' => $this->request->getVar('pajak'),
                    ]);
                } else {
                    $this->salesindukModel->save([
                        'id' =>  $salesinduk1['0']->id,
                        'perusahaan_id' => $this->request->getVar('idperusahaan'),
                        'wilayah_id' => $this->request->getVar('idwilayah'),
                        'divisi_id' => $this->request->getVar('iddivisi'),
                        'camp_id' => $this->request->getVar('idcamp'),
                        'tanggal' => $this->request->getVar('tanggal'),
                        'penerima_id' =>  $this->request->getVar('penerimaid'),
                        'proyek_id' => $this->request->getVar('idproyek'),
                        'st_jual' => '0',
                    ]);
                }

                $idinduk = $this->deklarModel->satuID('sales_induk', $this->request->getVar('idunik'));
                $datade = ($this->request->getVar('xdata') == 'stok') ? $this->request->getVar('barang') : $this->request->getVar($this->request->getVar('xdata'));
                $satuan = ($this->request->getVar('xdata') == 'stok') ? $this->request->getVar('satuan') : $this->request->getVar('satuan2');
                $this->salesanakModel->save([
                    'soinduk_id' => $idinduk['0']->id,
                    'data_id' => $datade,
                    // 'noseri_id' => $this->request->getVar('datade'),
                    'jumlah' => ubahSeparator($this->request->getVar('jumlah')),
                    'satuan' => $satuan,
                    'harga' => ubahSeparator($this->request->getVar('harga')),
                    'diskon' => ubahSeparator($this->request->getVar('diskon')),
                    'total' => ubahSeparator($this->request->getVar('total')),
                    'catatan' => $this->request->getVar('catatan'),
                ]);
                $msg = ['sukses' => $datade . " " . lang("app.judultambah")];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function savedata($idunik)
    {
        //aa
    }

    // ____________________________________________________________________________________________________________________________
    public function tabeldata()
    {
        if ($this->request->isAJAX()) {
            $perush = ($this->request->getVar('perusahaan') != 'all' ? $this->request->getVar('perusahaan') : '');
            $div = ($this->request->getVar('divisi') != 'all' ? $this->request->getVar('divisi') : '');
            $data = ['alat' => $this->deklarModel->getAlat('', $perush, $div)];
            $msg = ['data' => view('x-file/alat_tabel', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function loadsatuan()
    {
        if ($this->request->isAJAX()) {
            $db = $this->deklarModel->getSatuan($this->request->getvar('barang'));
            $data = ($db) ? ['satuan' => $db['0']->satuan, 'harga' => $db['0']->harga] : ['satuan' => '', 'harga' => ''];
            echo json_encode($data);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function loadbentuk()
    {
        if ($this->request->isAJAX()) {
            $db = $this->deklarModel->satuID('m_alat', $this->request->getvar('alat'), 'id');
            $data = ($db) ? ['bentuk' => $db['0']->bentuk, 'kategori' => $db['0']->kategori_id,] : ['bentuk' => '', 'kategori' => ''];
            echo json_encode($data);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function loadcamp()
    {
        if ($this->request->isAJAX()) {
            $camp = $this->deklarModel->loadcamp($this->request->getvar('searchTerm'), '', '', '');
            $campdata = array();
            $campdata[] = array('id' => '', 'text' => lang("app.pilihsr"));
            foreach ($camp as $row) {
                $campdata[] = array('id' => $row->id, 'text' => $row->kode . " => " . $row->nama);
            }
            echo json_encode($campdata);
        } else {
            exit('out');
        }
    }
}
