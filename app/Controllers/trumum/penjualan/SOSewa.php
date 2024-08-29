<?php

namespace App\Controllers\umum\penjualan;

use Config\App;
use App\Controllers\BaseController;
use App\Models\umum\SalesindukModel;
use App\Models\umum\SalesanakModel;

class SOSewa extends BaseController
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
            't_menu' => lang("app.tt_ordersewa"),
            't_submenu' => '',
            't_icon' => '<i class="icofont icofont-cart-alt ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="icofont icofont-cart-alt"></i>',
            't_dir1' => lang("app.penjualan"),
            't_dirac' => lang("app.pesansewa"),
            't_link' => '/sosewa',
            'menu' => 'sosewa',
            'asal' => 'sewa',
            'hid' => 'hidden',
            'cepsa' => '01111',
            'tuser' => $this->user,
        ];

        return view('umum/penjualan/sojual_view', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function crany()
    {
        do {
            $idu = buatid();
            $db = $this->deklarModel->satuID('sales_induk', $idu);
        } while (!empty($db));
        $this->iduModel->saveID($idu);
        return redirect()->to('/sosewa/input/' . $idu);
    }

    // ____________________________________________________________________________________________________________________________
    public function showdata($idunik)
    {
        // (!preg_match("/123/i", $this->session->menu->menu_1)) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $db1 = $this->deklarModel->satuID('sales_induk', $idunik);
        $data = [
            't_menu' => lang("app.tt_ordersewa"),
            't_submenu' => '',
            't_icon' => '<i class="icofont icofont-cart-alt ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="icofont icofont-cart-alt"></i>',
            't_dir1' => lang("app.penjualan"),
            't_dirac' => lang("app.pesansewa"),
            't_link' => '/sosewa',
            'idu' => $this->iduModel->cekID($idunik),
            'idunik' => $idunik,
            'perusahaan' => $this->deklarModel->getPerusahaan('', 't'),
            'wilayah' => $this->deklarModel->getDivisi('', 'wilayah', 't'),
            'divisi' => $this->deklarModel->getDivisi('', 'divisi', 't'),
            'selitem' => $this->deklarModel->distSelect('itemso'),
            'satuan' => $this->deklarModel->getDivisi('', 'satuan', 't'),
            'jasaso' => $this->deklarModel->distItem('sales_anak', 'namajasa'),
            'jual' => $db1,
            'camp1' => $this->deklarModel->satuID('m_camp', $db1['0']->camp_id ?? '', 'id'),
            'proyek1' => $this->deklarModel->satuID('m_proyek', $db1['0']->proyek_id ?? '', 'id'),
            'penerima1' => $this->deklarModel->satuID('m_penerima', $db1['0']->penerima_id ?? '', 'id'),
            'katalat' => $this->deklarModel->getDivisi('', 'katalat', 't'),
            'selbentuk' => $this->deklarModel->distSelect('bentuk'),
            'menu' => 'sewaalat',
            'cja' => '011', //camp alat aksi
            'tuser' => $this->user,
        ];
        return view('umum/penjualan/sojual_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function tambahdata()
    {
        if ($this->request->isAJAX()) {
            $cek = $this->tranModel->cekJualinduk('camp', $this->request->getVar('nodoc'), $this->request->getVar('idunik'));
            $rule_akses = (!empty($cek) ? 'required' : 'permit_empty');
            $dbcamp = $this->deklarModel->satuID('m_camp', $this->request->getVar('idcamp'), 'id');
            $rule_perusahaan = (!empty($dbcamp) ? ($this->request->getVar('idperusahaan') == $dbcamp['0']->perusahaan_id ? 'required' : 'valid_email') : 'required');
            $rule_wilayah = (!empty($dbcamp) ? ($this->request->getVar('idwilayah') == $dbcamp['0']->wilayah_id ? 'required' : 'valid_email') : 'required');
            $rule_divisi = (!empty($dbcamp) ? ($this->request->getVar('iddivisi') == $dbcamp['0']->divisi_id ? 'required' : 'valid_email') : 'required');

            $validationRules = [
                'akses' => [
                    'rules' => $rule_akses,
                    'errors' => ['required' => lang("app.errunik2")]
                ],
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
                'kodecamp' => [
                    'rules' => 'permit_empty',
                    'errors' => ['required' => lang("app.errblank")]
                ],
                'penerima' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'barang' => [
                    'rules' => 'permit_empty',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'jasa' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'bentuk' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'kategori' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'satuan2' => [
                    'rules' => 'required',
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
                        'kodecamp' => $this->validation->getError('kodecamp'),
                        'penerima' => $this->validation->getError('penerima'),
                        'barang' => $this->validation->getError('barang'),
                        'jasa' => $this->validation->getError('jasa'),
                        'bentuk' => $this->validation->getError('bentuk'),
                        'kategori' => $this->validation->getError('kategori'),
                        'satuan2' => $this->validation->getError('satuan2'),
                        'total' => $this->validation->getError('total'),
                        'catatan' => $this->validation->getError('catatan'),
                    ]
                ];
            } else {
                $nomordokumen = $this->request->getVar('nodoc');
                if ($this->request->getVar('nodoc') == "") {
                    $db = $this->tranModel->getNomordoc('jual_induk', $this->request->getVar('kui'), "-" . substr($this->request->getVar('tanggal'), 2, 2));
                    $nomor = (empty($db['0']->nodoc)) ? "1" : substr($db['0']->nodoc, -4) + 1;
                    $nomordokumen = nodokumen($this->request->getVar('kui'), $this->request->getVar('tanggal'), $nomor);
                }
                if ($this->request->getVar('nopo') == "") {
                    $nopo = $this->request->getVar('po') . substr($this->request->getVar('kui'), 3, 14);
                    $db2 = $this->tranModel->getNomordoc('po_pesan', $nopo, "-" . substr($this->request->getVar('tanggal'), 2, 2));
                    $nomor2 = (empty($db2['0']->nodoc)) ? "1" : substr($db2['0']->nodoc, -4) + 1;
                    $nomorpo = nodokumen($nopo, $this->request->getVar('tanggal'), $nomor2);
                } else {
                    $nomorpo = $this->request->getVar('nopo');
                }

                $jualinduk1 = $this->deklarModel->satuID('jual_induk', $this->request->getVar('idunik'));
                if (empty($jualinduk1)) {
                    $this->penjualanindukModel->save([
                        'idunik' =>  $this->request->getVar('idunik'),
                        'perusahaan_id' => $this->request->getVar('idperusahaan'),
                        'wilayah_id' => $this->request->getVar('idwilayah'),
                        'divisi_id' => $this->request->getVar('iddivisi'),
                        'pilihan' => 'alat',
                        'nodoc' => $nomordokumen,
                        'tanggal' => $this->request->getVar('tanggal'),
                        'nopo' => $nomorpo,
                        'penerima_id' =>  $this->request->getVar('penerima'),
                        'proyek_id' => $this->request->getVar('idproyek'),
                        'is_pajak' => $this->request->getVar('pajak'),
                    ]);
                } else {
                    $this->penjualanindukModel->save([
                        'id' =>  $jualinduk1['0']->id,
                        'st_jual' => '0',
                    ]);
                }

                $idinduk = $this->deklarModel->satuID('jual_induk', $this->request->getVar('idunik'));
                $this->penjualananakModel->save([
                    'jualinduk_id' => $idinduk['0']->id,
                    'jasa' => $this->request->getVar('jasa'),
                    'bentuk' => $this->request->getVar('bentuk'),
                    'kategori_id' => $this->request->getVar('kategori'),
                    'alat_id' => $this->request->getVar('alat'),
                    'jumlah' => ubahSeparator($this->request->getVar('jumlah')),
                    'satuan' => ubahSeparator($this->request->getVar('satuan2')),
                    'harga' => ubahSeparator($this->request->getVar('harga')),
                    'total' => ubahSeparator($this->request->getVar('total')),
                    'catatan' => $this->request->getVar('catatan'),
                ]);

                $jasa = $this->deklarModel->distItem('jual_anak', 'jasa');
                $isijasa = "";
                $isijasa .= '<option value="">' . lang("app.pilihcr") . '</option>';
                foreach ($jasa as $db) :
                    $isijasa .= "<option value='{$db->jasa}'>{$db->jasa}</option>";
                endforeach;
                $msg = [
                    'sukses' => $nomordokumen . " => " . $this->request->getVar('jasa') . " " . lang("app.judultambah"),
                    'nodoc' => $nomordokumen,
                    'nopo' => $nomorpo,
                    'jasaso' => $isijasa,
                ];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function savedata($idunik)
    {
        $db1 = $this->deklarModel->satuID('m_alat', $idunik);
        $rule_kode = (empty($db1) ? 'required|is_unique[m_alat.kode]|min_length[10]' : ($db1['0']->kode != strtoupper($this->request->getVar('kode')) ? 'required|is_unique[m_alat.kode]|min_length[10]' : 'required|min_length[10]'));

        $validationRules = [
            'kode' => [
                'rules' => $rule_kode,
                'errors' => ['required' => lang("app.errblank"), 'is_unique' => lang("app.errunik"), 'min_length' => lang("app.errlength", [10])]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => ['required' => lang("app.errblank")]
            ],
            'idperusahaan' => [
                'rules' => 'required',
                'errors' => ['required' => lang("app.errpilih")]
            ],
            'idwilayah' => [
                'rules' => 'required',
                'errors' => ['required' => lang("app.errpilih")]
            ],
            'iddivisi' => [
                'rules' => 'required',
                'errors' => ['required' => lang("app.errpilih")]
            ],
            'kbli' => [
                'rules' => 'required',
                'errors' => ['required' => lang("app.errpilih")]
            ],
            'kelakun' => [
                'rules' => 'required',
                'errors' => ['required' => lang("app.errpilih")]
            ],
            'nibeli' => [
                'rules' => 'required',
                'errors' => ['required' => lang("app.errblank")]
            ],
            'nisewa' => [
                'rules' => 'required',
                'errors' => ['required' => lang("app.errblank")]
            ],
            'msusut' => [
                'rules' => 'required',
                'errors' => ['required' => lang("app.errpilih")]
            ],
            'biaya' => [
                'rules' => 'required',
                'errors' => ['required' => lang("app.errpilih")]
            ],
            'catatan' => [
                'rules' => 'required',
                'errors' => ['required' => lang("app.errblank")]
            ],
            'gambar' => [
                'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/bmp,image/png]',
                'errors' => ['max_size' => lang("app.errfilebesar1"), 'is_image' => lang("app.errnotimg"), 'mime_in' => lang("app.errfileext")]
            ],
        ];
        if (!$this->validate($validationRules)) return redirect()->to('/alat/input/' . $idunik)->withInput();

        $file_gambar = $this->request->getFile('gambar');
        $nama_gambar = (($file_gambar->getError() == 4) ? $this->request->getVar('gambarlama') : $file_gambar->getName());
        if ($file_gambar->getError() != 4) $file_gambar->move('assets/fileimg/alat', $nama_gambar);
        if ($this->request->getVar('gambarlama') != 'default.png' && $file_gambar->getError() != 4) unlink('assets/fileimg/alat' . $this->request->getVar('gambarlama'));

        $act = (empty($db1) ? "Create" : "Update");
        $savj = (empty($db1) ? lang("app.judulsimpan") : lang("app.judulubah"));
        $id = (empty($db1) ? '' : $db1[0]->id);

        $this->alatModel->save([
            'id' => $id,
            'idunik' => $idunik,
            'perusahaan_id' => $this->request->getVar('idperusahaan'),
            'wilayah_id' => $this->request->getVar('idwilayah'),
            'divisi_id' => $this->request->getVar('iddivisi'),
            'perusahaanin_id' => $this->request->getVar('perusahaaninternal'),
            'kakun_id' => $this->request->getVar('kelakun'),
            'kode' => strtoupper($this->request->getVar('kode')),
            'nomor' => $this->request->getVar('nomor'),
            'nama' => $this->request->getVar('nama'),
            'kbli_id' => $this->request->getVar('kbli'),
            'merk' => $this->request->getVar('merk'),
            'kategori' => $this->request->getVar('kategori'),
            'surat' => $this->request->getVar('surat'),
            'mesin' => $this->request->getVar('mesin'),
            'transmisi' => $this->request->getVar('transmisi'),
            'jenis' => $this->request->getVar('jenis'),
            'tgl_beli' => $this->request->getVar('tglbeli'),
            'tgl_produksi' => $this->request->getVar('tglbuat'),
            'tgl_stnk' => $this->request->getVar('tglstnk'),
            'tgl_keur' => $this->request->getVar('tglkir'),
            'umur' => $this->request->getVar('umur'),
            'sisa' => $this->request->getVar('sisa'),
            'ni_beli' => ubahSeparator($this->request->getVar('nibeli')),
            'ni_residu' => ubahSeparator($this->request->getVar('niresidu')),
            'ni_target' => ubahSeparator($this->request->getVar('nitarget')),
            'ni_sewa' => ubahSeparator($this->request->getVar('nisewa')),
            'ni_susut' => ubahSeparator($this->request->getVar('nisusut')),
            'modsusut' => $this->request->getVar('msusut'),
            'berat' => ubahSeparator($this->request->getVar('kapasitas')),
            'ibbm' => ubahSeparator($this->request->getVar('ibbm')),
            'bukti' => $this->request->getVar('faktur'),
            'supir_id' => $this->request->getVar('pegawai'),
            'biaya_id' => $this->request->getVar('biaya'),
            'catatan' => $this->request->getVar('catatan'),
            'gambar' => $nama_gambar,
            'is_aktif' => $this->request->getVar('aktif'),
        ]);

        $menu = $this->deklarModel->satuID('m_alat', $idunik);
        $this->logModel->savelog('/alat', $menu['0']->id, $act, strtoupper($this->request->getVar('kode')));
        $this->session->setFlashdata(['judul' => strtoupper($this->request->getVar('kode')) . " " . $savj, 'perus' => $this->request->getVar('idperusahaan'), 'div' => $this->request->getVar('iddivisi')]);
        return redirect()->to('/alat');
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
    public function loadbentuk()
    {
        if ($this->request->isAJAX()) {
            $db = $this->deklarModel->satuID('m_alat', $this->request->getvar('alat'), 'id');
            $data = [
                'bentuk' => $db['0']->bentuk,
                'kategori' => $db['0']->kategori_id,
            ];
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
