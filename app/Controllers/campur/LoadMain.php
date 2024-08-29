<?php

namespace App\Controllers\campur;

use Config\App;
use App\Controllers\BaseController;

class Loadmain extends BaseController
{
    public function cariBiaya()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'biaya' => $this->mainModel->getBiaya($this->urls[1], $this->request->getVar('asal'), $this->request->getVar('kategori')),
                'tuser' => $this->user,
            ];
            $msg = ['data' => view('x-main/biaya_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    public function cariBerkas()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'berkas' => $this->mainModel->getBerkas($this->urls[1], $this->request->getVar('kategori')),
                'ihid' => $this->request->getVar('ihid'),
                'tuser' => $this->user,
            ];
            $msg = ['data' => view('x-main/berkas_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    public function cariRuas()
    {
        if ($this->request->isAJAX()) {
            $proyek = $this->request->getVar('proyek');
            $cabang = $this->request->getVar('cabang');
            $data = [
                'ruas' => $this->mainModel->getRuas($this->urls[1], $this->request->getVar('tujuan'), '', $proyek, $cabang),
                'cpl' => $this->request->getVar('cpl'),
                'tuser' => $this->user,
            ];
            $msg = ['data' => view('x-main/jarak_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function loadAkun()
    {
        if ($this->request->isAJAX()) {
            $akun = $this->mainModel->loadAkun($this->request->getvar('searchTerm'), $this->request->getvar('awal'));
            $akundata = array();
            foreach ($akun as $row) {
                $akundata[] = array('id' => $row->id, 'text' => $row->kode, 'data-subtext' => $row->nama);
            }
            return $this->response->setJSON($akundata);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function loadBiaya()
    {
        if ($this->request->isAJAX()) {
            switch ($this->request->getvar('param')) {
                case 'biayasd':
                    $param = ($this->request->getvar('ruas') != '' ? 'sumber daya' : 'blank');
                    $biaya = $this->mainModel->loadBiaya($param, '2', '', $this->request->getvar('searchTerm'));
                    break;
                case 'biaya':
                    if ($this->request->getvar('ruas') == '')
                        $biaya = $this->mainModel->loadBiaya('biaya taklangsung', '4', '', $this->request->getvar('searchTerm'), $this->request->getvar('awal'));
                    else
                        $biaya = $this->mainModel->loadBiaya('biaya langsung', '3', $this->request->getvar('kategori'), $this->request->getvar('searchTerm'));
                    break;
                case 'blank';
                    break;
            }
            $biayadata = array();
            foreach ($biaya as $row) {
                $biayadata[] = array('id' => $row->id, 'text' => $row->kode, 'data-subtext' => $row->nama);
            }
            return $this->response->setJSON($biayadata);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function loadCabang()
    {
        if ($this->request->isAJAX()) {
            $perus = $wil = $div = '';
            $cabang = $this->mainModel->loadCabang($this->request->getvar('searchTerm'), $perus, $wil, $div);
            $cabangdata = array();
            foreach ($cabang as $row) {
                $cabangdata[] = array('id' => $row->id, 'text' => $row->kode, 'data-subtext' => $row->nama);
            }
            return $this->response->setJSON($cabangdata);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function loadUser()
    {
        if ($this->request->isAJAX()) {
            $user = $this->mainModel->loadUser($this->request->getvar('searchTerm'), $this->request->getvar('pegawai'));
            $userdata = array();
            foreach ($user as $row) {
                $userdata[] = array('id' => $row->kode, 'text' => $row->kode, 'data-subtext' => $row->namapegawai);
            }
            return $this->response->setJSON($userdata);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function loadPenerima()
    {
        if ($this->request->isAJAX()) {
            $pel = substr($this->request->getvar('pilih'), 0, 1);
            $sup = substr($this->request->getvar('pilih'), 1, 1);
            $lain = substr($this->request->getvar('pilih'), 2, 1);
            $peg = substr($this->request->getvar('pilih'), 3, 1);
            $osm = substr($this->request->getvar('pilih'), 4, 1);
            $penerima = $this->mainModel->loadPenerima($this->request->getvar('searchTerm'), $pel, $sup, $lain, $peg, $osm);
            $penerimadata = array();
            foreach ($penerima as $row) {
                $penerimadata[] = array('id' => $row->id, 'text' => $row->kode, 'data-subtext' => $row->nama);
            }
            return $this->response->setJSON($penerimadata);
        } else {
            exit('out');
        }
    }










    // ____________________________________________________________________________________________________________________________
    public function loadbarang()
    {
        if ($this->request->isAJAX()) {
            $barang = $this->deklarModel->loadbarang($this->request->getvar('searchTerm'), $this->request->getvar('pilihan'), $this->request->getvar('sn')); // find all
            $barangdata = array();
            $barangdata[] = array('id' => '', 'text' => lang("app.pilihsr"));
            foreach ($barang as $row) {
                $barangdata[] = array('id' => $row->id, 'text' => $row->kode . " => " . $row->nama . " (" . $row->partnumber . ")");
            }
            echo json_encode($barangdata);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    // public function loadpenerima()
    // {
    //     if ($this->request->isAJAX()) {
    //         $pel = substr($this->request->getvar('pilih'), 0, 1);
    //         $sup = substr($this->request->getvar('pilih'), 1, 1);
    //         $lain = substr($this->request->getvar('pilih'), 2, 1);
    //         $peg = substr($this->request->getvar('pilih'), 3, 1);
    //         $penerima = $this->deklarModel->loadpenerima($this->request->getvar('searchTerm'), $pel, $sup, $lain, $peg, $this->request->getvar('osm'));
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
    public function loadpenerima1()
    {
        if ($this->request->isAJAX()) {
            $penerima1 = $this->deklarModel->satuID('m_penerima', $this->request->getvar('penerima'), '', 'id');
            $isipenerima = "";
            $isipenerima .= '<option value="">' . lang("app.pilihsr") . '</option>';
            if (!empty($penerima1)) $isipenerima .= '<option value="' . $penerima1[0]->id . '" selected >' .  $penerima1[0]->kode . " => " . $penerima1[0]->nama . '</option>';
            $data = ['penerima' => $isipenerima];
            echo json_encode($data);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function loadruas()
    {
        if ($this->request->isAJAX()) {
            $sruas = $this->request->getvar('ruas');
            $proyek = ($this->request->getvar('proyek') != '' ? $this->request->getvar('proyek') : '-');
            $ruas = $this->deklarModel->getRuas('', $this->request->getvar('pilih'), 't', $proyek);
            $isiruas = "";
            $isiruas .= '<option value="">' . lang("app.pilih-") . '</option>';
            foreach ($ruas as $db) :
                $terpilih = "";
                if ($db->id == $sruas) $terpilih = 'selected';
                $isiruas .= '<option value="' . $db->id . '" data-kode="' . $db->kode . '" ' . $terpilih . '>' . $db->kode . " => " . $db->nama . '</option>';
            endforeach;
            $data = ['ruas' => $isiruas];
            echo json_encode($data);
        } else {
            exit('out');
        }
    }





    // ____________________________________________________________________________________________________________________________
    public function loadalat()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->isAJAX()) {
                $alat = $this->deklarModel->loadAlat($this->request->getvar('searchTerm'), $this->request->getvar('pilihan'), '', '', '');
                $alatdata = array();
                $alatdata[] = array('id' => '', 'text' => lang("app.pilihsr"));
                foreach ($alat as $row) {
                    $alatdata[] = array('id' => $row->id, 'text' => $row->kode . " ; " . $row->nomor . " => " . $row->nama);
                }
                echo json_encode($alatdata);
            } else {
                exit('out');
            }
        }
    }

    // ____________________________________________________________________________________________________________________________
    // public function loadtanah()
    // {
    //     if ($this->request->isAJAX()) {
    //         if ($this->request->isAJAX()) {
    //             $tanah = $this->deklarModel->loadTanah($this->request->getvar('searchTerm'), '', '');
    //             $tanahdata = array();
    //             $tanahdata[] = array('id' => '', 'text' => lang("app.pilihsr"));
    //             foreach ($tanah as $row) {
    //                 $tanahdata[] = array('id' => $row->id, 'text' => $row->kode . " => " . $row->nama);
    //             }
    //             echo json_encode($tanahdata);
    //         } else {
    //             exit('out');
    //         }
    //     }
    // }

    // ____________________________________________________________________________________________________________________________
    public function modalBeban()
    {
        if ($this->request->isAJAX()) {
            $perus = $this->request->getvar('perusahaan');
            $wil = $this->request->getvar('wilayah');
            $div = $this->request->getvar('divisi');
            $beban = $this->request->getvar('beban');
            switch ($beban) {
                case 'proyek':
                    $data = [
                        'proyek' => $this->mainModel->loadProyek($this->request->getvar('isi'), $perus, $wil, $div),
                        'wenbrako' => $this->request->getvar('wenbrako'),
                        'tuser' => $this->user,
                    ];
                    $alamat = 'select_proyek';
                    break;
                case 'cabang':
                    $data = [
                        'cabang' => $this->deklarModel->loadCamp($this->request->getVar('isi'), $this->request->getvar('perusahaan'), $this->request->getvar('wilayah'), $this->request->getvar('divisi')),
                        'wenbrako' => $this->request->getvar('wenbrako'),
                        'tuser' => $this->user,
                    ];
                    $alamat = 'select_camp';
                    break;

                case "alat tool":
                    $data = [
                        'alat' => $this->deklarModel->loadAlat($this->request->getVar('isi'), 'tool', $this->request->getvar('perusahaan'), $this->request->getvar('wilayah'), $this->request->getvar('divisi')),
                        'wenbrako' => $this->request->getvar('wenbrako'),
                        'tuser' => $this->user,
                    ];
                    $alamat = 'select_alat';
                    break;
                    // case "alat":
                    //     $data = [
                    //         'alat' => $this->deklarModel->loadAlat($this->request->getVar('isi'), 'pribadi', $this->request->getvar('perusahaan'), $this->request->getvar('wilayah'), $this->request->getvar('divisi')),
                    //         'wenbrako' => $this->request->getvar('wenbrako'),
                    //         'tuser' => $this->user,
                    //     ];
                    //     $alamat = 'select_alat';
                    //     break;
                case 'tanah bangunan':
                    $data = [
                        'tanah' => $this->deklarModel->loadTanah($this->request->getvar('isi'), $this->request->getvar('perusahaan'), $this->request->getvar('wilayah'), $this->request->getvar('divisi')),
                        'wenbrako' => $this->request->getvar('wenbrako'),
                        'tuser' => $this->user,
                    ];
                    $alamat = 'select_tanah';
                    break;
                default:
                    $data = [];
                    $alamat = 'select_kosong';
                    break;
            }
            $msg = ['data' => view('x-modal/' . $alamat, $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function modalproyek()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'proyek' => $this->deklarModel->loadProyek($this->request->getvar('isi'), $this->request->getvar('perusahaan'), $this->request->getvar('wilayah'), $this->request->getvar('divisi')),
                'wenbrako' => $this->request->getvar('wenbrako'), // wilayah penerima nilai beban ruas(sd) anggaran kelakun nol       
                'tuser' => $this->user,
            ];
            $msg = ['data' => view('x-modal/select_proyek', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function modalcamp()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'camp' => $this->deklarModel->loadCamp($this->request->getvar('isi'), $this->request->getvar('perusahaan'), $this->request->getvar('wilayah'), $this->request->getvar('divisi')),
                'wenbrako' => $this->request->getvar('wenbrako'),
                'tuser' => $this->user,
            ];
            $msg = ['data' => view('x-modal/select_camp', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    // public function modalalat()
    // {
    //     if ($this->request->isAJAX()) {
    //         $data = [
    //             'alat' => $this->deklarModel->loadAlat($this->request->getvar('isi'), $this->request->getvar('pilih'), $this->request->getvar('perusahaan'), $this->request->getvar('divisi')),
    //             'wenbrako' => $this->request->getvar('wenbrako'),
    //             'tuser' => $this->user,
    //         ];
    //         $msg = ['data' => view('x-modal/select_alat', $data)];
    //         echo json_encode($msg);
    //     } else {
    //         exit('out');
    //     }
    // }

    // ____________________________________________________________________________________________________________________________
    public function modalbarang()
    {
        if ($this->request->isAJAX()) {
            $jenis = (($this->request->getvar('jenis') == '1') || ($this->request->getvar('jenis') == 'on') ? 'on' : 'off');
            $data = ['barang' => ($jenis == 'on' ? $this->deklarModel->satuID('m_barang', $this->request->getvar('isi'), '', 'id') : '')];
            $msg = ['data' => view('x-modal/show_item', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function modalpenerima()
    {
        if ($this->request->isAJAX()) {
            $data = ['penerima' => $this->deklarModel->satuID('m_penerima', $this->request->getvar('isi'), '', 'id')];
            $msg = ['data' => view('x-modal/show_penerima', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function tabelbarang()
    {
        if ($this->request->isAJAX()) {
            $kategori = ($this->request->getVar('kategori') != 'all' ? $this->request->getVar('kategori') : '');
            $data = [
                'barang' => $this->deklarModel->getBarang($this->urls[1], $this->request->getVar('menu'), $kategori),
                'menu' => $this->request->getVar('menu'),
                'ihid' => $this->request->getVar('ihid'),
                'bhid' => $this->request->getVar('bhid'),
            ];
            $msg = ['data' => view('x-file/barang_tabel', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
    // ____________________________________________________________________________________________________________________________

}
