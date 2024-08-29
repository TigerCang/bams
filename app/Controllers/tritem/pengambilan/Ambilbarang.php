<?php

namespace App\Controllers\tritem\pengambilan;

use Config\App;
use App\Controllers\BaseController;
use App\Models\tritem\POambilModel;
use App\Models\file\AtkModel;

class Ambilbarang extends BaseController
{
    protected $poambilModel;
    protected $atkModel;
    public function __construct()
    {
        $this->poambilModel = new POambilModel();
        $this->atkModel = new AtkModel();
    }

    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        // (!preg_match("/107/i", $this->menu['menu_1'])) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $data = [
            't_menu' => strtoupper(lang("app.ambilbarang")), 't_submenu' => '',
            't_icon' => '<i class="icofont icofont-paper ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="icofont icofont-paper"></i>', 't_dir1' => lang("app.ambilbarang"), 't_dirac' => lang("app.ambilbarang"), 't_link' => '/ambilbarang',
            'menu' => 'ambilbarang', 'baru' => '',
            'btnclascr' => lang('app.btncCreate'), 'btntextcr' => lang('app.btnCreate'),
            'actcreate' => ($this->user['act_create'] == '0' ? 'hidden' : ''),
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        return view('tritem/pengambilan/ambilbarang_view', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function showdata()
    {
        // (!preg_match("/126/i", $this->menu['menu_1'])) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $data = [
            't_menu' => strtoupper(lang("app.ambilbarang")), 't_submenu' => '',
            't_icon' => '<i class="icofont icofont-paper ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="icofont icofont-paper"></i>', 't_dir1' => lang("app.ambilbarang"), 't_dirac' => lang("app.ambilbarang"), 't_link' => '/ambilbarang',
            'perusahaan' => $this->deklarModel->getPerusahaan('', 't'),
            'wilayah' => $this->deklarModel->getDivisi('', 'wilayah', 't'),
            'divisi' => $this->deklarModel->getDivisi('', 'divisi', 't'),
            'nodoc' => $this->deklarModel->cekForm('dokumen', 'ambilbarang', 't', '', '', ''),
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        // if ($db1) $this->logModel->saveLog('Read', $idunik, $db1[0]->tanggal, '-');
        return view('tritem/pengambilan/ambilbarang_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function tambahdata()
    {
        if ($this->request->isAJAX()) {
            $validationRules = [
                'pegawai' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'barang' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'jumlah' => [
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
                        'pegawai' => $this->validation->getError('pegawai'),
                        'barang' => $this->validation->getError('barang'),
                        'jumlah' => $this->validation->getError('jumlah'),
                        'catatan' => $this->validation->getError('catatan'),
                    ]
                ];
            } else {
                if ($this->request->getVar('idunik') == "") {
                    do {
                        $idunik = buatid(60);
                        $idu = $this->deklarModel->satuID('po_ambil', $idunik);
                    } while ($idu);
                } else {
                    $idunik = $this->request->getVar('idunik');
                }
                if ($this->request->getVar('nodoc') == "") {
                    $dbperus = $this->deklarModel->satuID('m_perusahaan', $this->request->getVar('idperusahaan'), '', 'id');
                    $dbwil = $this->deklarModel->satuID('m_divisi', $this->request->getVar('idwilayah'), '', 'id');
                    $dbdiv = $this->deklarModel->satuID('m_divisi', $this->request->getVar('iddivisi'), '', 'id');
                    $kui = "{$this->request->getVar('awal')}/{$dbperus[0]->kui}/{$dbwil[0]->kode}.{$dbdiv[0]->kode}/";
                    $dbdoc = $this->tranModel->getNomordoc('po_minta', $kui, "-" . substr($this->request->getVar('tanggal'), 2, 2));
                    $nomor = ($dbdoc ? substr($dbdoc[0]->nodoc, -4) + 1 : '1');
                    $nodokumen = nodokumen($kui, $this->request->getVar('tanggal'), $nomor);
                } else {
                    $nodokumen = $this->request->getVar('nodoc');
                }

                $this->poambilModel->save([
                    'idunik' =>  $idunik,
                    'nodoc' => $nodokumen,
                    'tanggal' => $this->request->getVar('tanggal'),
                    'perusahaan_id' => $this->request->getVar('idperusahaan'),
                    'wilayah_id' => $this->request->getVar('idwilayah'),
                    'divisi_id' => $this->request->getVar('iddivisi'),
                    'user_id' => $this->user['id'],
                    'penerima_id' => $this->request->getVar('pegawai'),
                    'atk_id' => $this->request->getVar('barang'),
                    'jumlah' => ubahSeparator($this->request->getVar('jumlah')),
                    'catatan' => $this->request->getVar('catatan'),
                    'status' => '0',
                ]);
                $dbpeg = $this->deklarModel->satuID('m_penerima', $this->request->getVar('pegawai'), '', 'id');
                $dbatk = $this->deklarModel->satuID('m_atk', $this->request->getVar('barang'), '', 'id');
                $this->logModel->saveLog('Add', $this->request->getVar('idunik'), "{$dbpeg[0]->nama} => {$dbatk[0]->nama}");
                $msg = ['sukses' => "{$dbpeg[0]->nama} => {$dbatk[0]->nama}" . lang('app.judultambah')];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $validationRules = [
                'mbarang' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'mjumlah' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
                'mcatatan' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'mbarang' => $this->validation->getError('mbarang'),
                        'mjumlah' => $this->validation->getError('mjumlah'),
                        'mcatatan' => $this->validation->getError('mcatatan'),
                    ]
                ];
            } else {
                $this->poambilModel->save([
                    'id' => $this->request->getVar('mid'),
                    'atk_id' => $this->request->getVar('mbarang'),
                    'jumlah' => ubahSeparator($this->request->getVar('mjumlah')),
                    'catatan' => $this->request->getVar('mcatatan'),
                ]);
                $dbatk = $this->deklarModel->satuID('m_atk', $this->request->getVar('mbarang'), '', 'id');
                $this->logModel->saveLog('Update', $this->request->getVar('midunik'), "{$dbatk[0]->nama}");
                $msg = ['sukses' => "{$dbatk[0]->nama}" . lang('app.judulubah')];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
    public function deletedata()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $this->poambilModel->delete($id);
            $msg = ['sukses' => "{$this->request->getVar('barang')}" . lang("app.judulhapus")];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function loadperusahaan()
    {
        if ($this->request->isAJAX()) {
            $dbpeg = $this->deklarModel->satuID('m_penerima', $this->request->getvar('pegawai'), '', 'id');
            $dbpo = null;
            $idunik = '';
            $nodokumen = '';
            if ($dbpeg) $dbpo = $this->tranModel->cekPOambil($dbpeg[0]->perusahaan_id, $dbpeg[0]->wilayah_id, $dbpeg[0]->divisi_id, $this->request->getvar('tanggal'));
            if ($dbpo) {
                $idunik = $dbpo[0]->idunik;
                $nodokumen = $dbpo[0]->nodoc;
            }
            $data = [
                'pegawai' => $dbpeg,
                'idunik' => $idunik,
                'nodoc' => $nodokumen,
            ];
            echo json_encode($data);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function modalinput()
    {
        if ($this->request->isAJAX()) {
            $data = ['satuan' => $this->deklarModel->getDivisi('', 'satuan', 't')];
            $msg = ['data' => view('x-modal/input_atk', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
    public function modaldata()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getvar('id');
            $db = $this->deklarModel->satuID('po_ambil', $id, '', 'id');
            $data = [
                'po' => $db,
                'barang1' => $this->deklarModel->satuID('m_atk', $db[0]->atk_id, '', 'id'),
            ];
            $msg = ['data' => view('x-modal/koreksi_ambilbarang', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function saveatk()
    {
        if ($this->request->isAJAX()) {
            $validationRules = [
                'mbarang' => [
                    'rules' => 'required|is_unique[m_atk.nama]',
                    'errors' => ['required' => lang("app.errblank"), 'is_unique' => lang("app.errunik")]
                ],
                'msatuan' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errpilih")]
                ]
            ];
            if (!$this->validate($validationRules)) {
                $msg = ['error' => ['mbarang' => $this->validation->getError('mbarang'), 'msatuan' => $this->validation->getError('msatuan')]];
            } else {
                $this->atkModel->save([
                    'idunik' => buatid(),
                    'nama' => $this->request->getVar('mbarang'),
                    'satuan' => $this->request->getVar('msatuan'),
                    'updated_by' => $this->user['id'],
                ]);
                $idakhir = $this->deklarModel->lastID('m_atk');
                $this->logModel->saveLog('Save', $idakhir[0]->idunik, "{$this->request->getVar('mbarang')}");
                $msg = ['sukses' => $this->request->getVar('mbarang') . ' ' . lang("app.judulsimpan")];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function loadatk()
    {
        if ($this->request->isAJAX()) {
            $barang = $this->deklarModel->loadatk($this->request->getvar('searchTerm'));
            $barangdata = [['id' => '', 'data-satuan' => '', 'text' => lang("app.pilihsr")]];
            foreach ($barang as $row) {
                $barangdata[] = ['id' => $row->id, 'data-satuan' => $row->satuan, 'text' => "{$row->nama}"];
            }
            return json_encode($barangdata);
        } else {
            exit('out');
        }
    }
}
