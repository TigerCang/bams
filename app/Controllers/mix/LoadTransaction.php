<?php

namespace App\Controllers\mix;

use Config\App;
use App\Controllers\BaseController;

class LoadTransaction extends BaseController
{
    // Search ___________________________________________________________________________________________________________________________________________________________________________________________
    public function searchBudget()
    {
        if ($this->request->isAJAX()) {
            var_dump($this->request->getVar('url'), $this->request->getVar('object'), $this->request->getVar('year'));
            $data = [
                'budget' => $this->transModel->getBudget($this->request->getVar('url'), $this->request->getVar('object'), '', '', $this->request->getVar('year')),
                //     $data = ['cost' => $this->mainModel->getCost(substr($this->request->getVar('url'), 1), $this->request->getVar('param'), $category)];
                //     public function getBudget($menu, $object = false, $objectid = false, $type = false, $year = false)
            ];
            var_dump($data['budget']);
            die;
            $msg = ['data' => view('x-general/budget_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }








    // ____________________________________________________________________________________________________________________________
    public function tabelanggaraninduk()
    {
        if ($this->request->isAJAX()) {
            $perus = ($this->request->getVar('perusahaan') == 'all' ? '' : $this->request->getVar('perusahaan'));
            $wil = ($this->request->getVar('wilayah') == 'all' ? '' : $this->request->getVar('wilayah'));
            $div = ($this->request->getVar('divisi') == 'all' ? '' : $this->request->getVar('divisi'));
            $pilih = ($this->request->getVar('pilih') == '' ? '' : $this->request->getVar('pilih'));
            $tahun = ($this->request->getVar('tahun') == '' ? '' : $this->request->getVar('tahun'));
            $data = [
                'anggaran' => $this->tranModel->getAnggaraninduk($this->urls[1], $perus, $wil, $div, $tahun, $pilih, $this->request->getVar('tujuan')),
                'menu' => $this->request->getVar('menu'),
                'tujuan' => $this->request->getVar('tujuan'),
            ];
            $msg = ['data' => view('x-umum/anggaraninduk_tabel', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
    public function tabeldataanggaran()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->deklarModel->satuID('anggaran_induk', $this->request->getVar('idunik'));
            // var_dump($this->request->getVar('bapmsacpkxa'));
            // die;
            $data = [
                'anggaran' => $this->tranModel->getAnggarananak($db1[0]->id ?? '', $this->request->getVar('kategori')),
                'tujuan' => $this->request->getVar('tujuan'),
                'bapmsacpkix' => $this->request->getVar('bapmsacpkix'),
                //biaya akun matabayar bulan satuan awal cco persen kelompok aksi
            ];
            $msg = ['data' => view("x-umum/anggarananak{$this->request->getvar('menu')}_tabel", $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
    public function loadanggaran()
    {
        if ($this->request->isAJAX()) {
            $anggaran = $this->tranModel->loadanggaran($this->request->getvar('tujuan'), $this->request->getvar('ruas'), $this->request->getvar('beban'), $this->request->getvar('tipe'), $this->request->getvar('tanggal'));
            $isianggaran = "";
            $isianggaran .= '<option value="">' . lang("app.pilih-") . '</option>';
            foreach ($anggaran as $db) :
                $this->request->getvar('tujuan') == 'proyek' ? ($nid = $db->idbiaya) && ($nkode = $db->kodebiaya) && ($nnama = $db->namabiaya) && ($nakun = $db->akunbiaya) : ($nid = $db->idakun) && ($nkode = $db->noakun) && ($nnama = $db->namaakun) && ($nakun = $db->idakun);
                $isianggaran .= '<option value="' . $db->id . '" data-idbiaya="' . $nid . '" data-akunbiaya="' . $nakun . '">' . $nkode . " => " . $nnama . " ; (" . formatkoma($db->jumlah_cco, '4') . " x " . formatkoma($db->harga_kontrak_cco) . ")" . '</option>';
            endforeach;
            $data = ['anggaran' => $isianggaran, 'tujuan' => $this->request->getvar('tujuan')];
            echo json_encode($data);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function tabelmintabarang()
    {
        if ($this->request->isAJAX()) {
            $levacc = ($this->request->getVar('acc') == 'true' ? ($this->user['acc_setuju'] == $this->level[0]['nilai'] ? '0' : $this->user['acc_setuju'] + 1) : '');
            $perus = (empty($this->request->getVar('perusahaan')) ? '-' : ($this->request->getVar('perusahaan') == 'all' ? '' : $this->request->getVar('perusahaan')));
            $wil = (empty($this->request->getVar('wilayah')) ? '-' : ($this->request->getVar('wilayah') == 'all' ? '' : $this->request->getVar('wilayah')));
            $div = (empty($this->request->getVar('divisi')) ? '-' : ($this->request->getVar('divisi') == 'all' ? '' : $this->request->getVar('divisi')));
            $tgl_aw = tanggalmundur($this->request->getvar('tanggal'), '-1');
            $data = [
                'barang' => $this->tranModel->getPOminta($this->urls[1], $this->user['id'], $this->request->getVar('status'), $levacc, '', $tgl_aw, $this->request->getvar('tanggal'), $perus, $wil, $div),
                'menu' => $this->urls[1],
            ];
            $msg = ['data' => view('x-item/mintabarang_tabel', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
    public function tabeldatabarang()
    {
        if ($this->request->isAJAX()) {
            $po1 = $this->deklarModel->satuID('po_minta', $this->request->getVar('idunik'));
            $s7 = 0;
            if ($this->request->getVar('asal') == 'minta') {
                $s7 = $po1[0]->status ?? '0';
                $s7 = ($po1 && ($po1[0]->user_id != $this->request->getVar('user')) ? '2' : $s7);
                if ($po1 && $po1[0]->status == 'c' && $po1[0]->user_id == $this->request->getVar('user'))  $s7 = '0';
            } elseif ($this->request->getVar('asal') == 'cekada') {
                $s7 =  ($po1[0]->status == '7' ? '7' : '0');
            }
            $data = [
                'barang' => $this->tranModel->getPOanak($po1[0]->id ?? ''),
                'nstat' => $s7,
                'jaboskix' => $this->request->getVar('jaboskix'),
                //jumlah ada beli order satuan konversi aksi
                'asal' => $this->request->getVar('asal'),
            ];
            $msg = ['data' => view('x-item/poanak_tabel', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
    public function tabelhargatawar()
    {
        if ($this->request->isAJAX()) {
            $po1 = $this->deklarModel->satuID('po_minta', $this->request->getVar('idunik'));
            $data = [
                'barang' => $this->tranModel->getPOtawar($po1[0]->id, $this->request->getVar('item')),
                'bsomshdtpspix' => $this->request->getVar('bsomshdtpspix'),
                //barang spesifikasi order masuk satuan harga diskon total pajak suplier pilih aksi pilihaksi
                // editdel  pilsup
                'asal' => $this->request->getVar('asal'),
            ];
            $msg = ['data' => view('x-item/barangtawardetil_tabel', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
    // public function tabelpesanbarang()
    // {
    //     if ($this->request->isAJAX()) {
    //         (empty($this->request->getVar('perusahaan'))) ? $perus = '-' : (($this->request->getVar('perusahaan') == 'all') ? $perus = '' : $perus = $this->request->getVar('perusahaan'));
    //         (empty($this->request->getVar('wilayah'))) ? $wil = '-' : (($this->request->getVar('wilayah') == 'all') ? $wil = '' : $wil = $this->request->getVar('wilayah'));
    //         (empty($this->request->getVar('divisi'))) ? $div = '-' : (($this->request->getVar('divisi') == 'all') ? $div = '' : $div = $this->request->getVar('divisi'));
    //         $tgl_aw = tanggalmundur($this->request->getvar('tanggal'), '-1');

    //         $data = [
    //             'po' => $this->tranModel->getPOpesan('', $perus, $wil, $div, '', '', $tgl_aw, $this->request->getvar('tanggal')),
    //             'menu' => $this->request->getVar('menu'),
    //             'pesan' => $this->request->getVar('pesan'),
    //         ];
    //         $msg = ['data' => view('x-umum/pesanbarang_tabel', $data)];
    //         echo json_encode($msg);
    //     } else {
    //         exit('out');
    //     }
    // }
    // public function tabelambilbarang()
    // {
    //     if ($this->request->isAJAX()) {
    //         $tgl_aw = tanggalmundur($this->request->getvar('tanggal'), '-1');
    //         $data = [
    //             'ambil' => $this->tranModel->getPOambil($this->urls[1], '1', '', $tgl_aw, $this->request->getvar('tanggal')),
    //             'menu' => $this->urls[1],
    //         ];
    //         $msg = ['data' => view('x-item/ambilbarang_tabel', $data)];
    //         echo json_encode($msg);
    //     } else {
    //         exit('out');
    //     }
    // }
    // public function tabelbarangambil()
    // {
    //     if ($this->request->isAJAX()) {
    //         $data = ['barang' => $this->tranModel->getPOambil('', '0', $this->request->getvar('tanggal'))];
    //         $msg = ['data' => view('x-item/ambilbarangdetil_tabel', $data)];
    //         echo json_encode($msg);
    //     } else {
    //         exit('out');
    //     }
    // }




    // ____________________________________________________________________________________________________________________________
    // public function tabelsalesinduk()
    // {
    //     if ($this->request->isAJAX()) {
    //         $tgl_aw = tanggalmundur($this->request->getvar('tanggal'), '-1');
    //         $data = [
    //             'sales' => $this->tranModel->getSalesinduk($this->request->getVar('asal'), $this->request->getVar('proses'), $this->request->getVar('camp'), $tgl_aw, $this->request->getvar('tanggal')),
    //             'menu' => $this->request->getVar('menu'),
    //             'cepsa' => $this->request->getVar('cepsa'), // bcamp penerima proyek status action
    //         ];
    //         $msg = ['data' => view('x-umum/salesorder_tabel', $data)];
    //         echo json_encode($msg);
    //     } else {
    //         exit('out');
    //     }
    // }
    // public function tabelsalesanak()
    // {
    //     if ($this->request->isAJAX()) {
    //         $sales1 = $this->deklarModel->satuID('sales_induk', $this->request->getVar('idunik'));
    //         $salesid = (empty(!$sales1) ? $sales1[0]->id : '');
    //         $data = ['sales' => $this->tranModel->getSalesanak($salesid), 'cja' => $this->request->getVar('cja')];
    //         $msg = ['data' => view('x-umum/soitem_tabel', $data)];
    //         echo json_encode($msg);
    //     } else {
    //         exit('out');
    //     }
    // }

    // ____________________________________________________________________________________________________________________________
    // public function tabeltiket()
    // {
    //     if ($this->request->isAJAX()) {
    //         $data = [
    //             'tiket' => $this->tranModel->getTiket($this->request->getVar('docjual')),
    //             // 'menu' => $this->request->getVar('menu'),
    //         ];
    //         $msg = ['data' => view('x-alat/tiket_tabel', $data)];
    //         echo json_encode($msg);
    //     } else {
    //         exit('out');
    //     }
    // }

    // ____________________________________________________________________________________________________________________________
    public function tabelKasinduk()
    {
        if ($this->request->isAJAX()) {

            // $levacc = ($this->request->getVar('acc') == 'true' ? ($this->user['acc_setuju'] == $this->level[0]['nilai'] ? '0' : $this->user['acc_setuju'] + 1) : '');
            // status: getStatus,
            // acc: getAcc,
            $status = ($this->request->getVar('param') == '' ? '' : $this->request->getVar('status'));
            $perus = $this->request->getVar('perusahaan');
            $div = $this->request->getVar('divisi');
            $tgl_aw = tanggalMundur($this->request->getvar('tanggal'), '-1');
            $data = [
                'kas' => $this->transaksiModel->getKasinduk($this->urls[1], $this->request->getVar('param'), session()->usernama, $status, '', $tgl_aw, $this->request->getvar('tanggal'), $perus, $div),
            ];
            $msg = ['data' => view('x-kas/mintakas_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // public function tabelcekkas()
    // {
    //     if ($this->request->isAJAX()) {
    //         (empty($this->request->getVar('perusahaan'))) ? $perus = '-' : (($this->request->getVar('perusahaan') == 'all') ? $perus = '' : $perus = getid($this->request->getVar('perusahaan')));
    //         (empty($this->request->getVar('wilayah'))) ? $wil = '-' : (($this->request->getVar('wilayah') == 'all') ? $wil = '' : $wil = getid($this->request->getVar('wilayah')));
    //         (empty($this->request->getVar('divisi'))) ? $div = '-' : (($this->request->getVar('divisi') == 'all') ? $div = '' : $div = getid($this->request->getVar('divisi')));
    //         $tgl_aw = ubahtanggal($this->request->getvar('tanggal'), '-1');
    //         $data = [
    //             'kas' => $this->tranModel->getKasinduk('', '', $perus, $wil, $div, $tgl_aw, $this->request->getvar('tanggal')),
    //         ];

    //         $msg = [
    //             'data' => view('x-tabel/cekkas_view', $data)
    //         ];
    //         echo json_encode($msg);
    //     } else {
    //         exit('out');
    //     }
    // }
    public function tabeldatakas()
    {
        if ($this->request->isAJAX()) {
            $kas1 = $this->deklarModel->satuID('kas_induk', $this->request->getVar('idunik'));
            // $nstatus = (empty(!$kasinduk1)) ? $kasinduk1[0]->status : '0';
            if ($this->request->getvar('asal') == 'kaspindah') {
                $data = [
                    // 'biaya' => $this->tranModel->getKasdetil($kasid),
                    // 'nstat' => $nstatus,
                    'pilih' => $this->request->getVar('pilih'),
                    'menu' => $this->request->getvar('asal'),
                    'ed' => $this->request->getvar('ed'),
                ];
                $msg = ['data' => view('x-kas/biayadetil_tabel', $data)];
            } else {
                $data = [
                    'biaya' => $this->tranModel->getKasanak($kas1[0]->id ?? ''),
                    // 'nstat' => $nstatus,
                    'menu' => $this->request->getvar('asal'),
                    'basbprix' => $this->request->getvar('basbprix'),
                    //biaya akun supir barang pajak rekaplaporan aksi
                ];
                $msg = ['data' => view('x-kas/kasanak_tabel', $data)];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function tabelmintacuti()
    {
        if ($this->request->isAJAX()) {
            $tgl_aw = tanggalmundur($this->request->getvar('tanggal'), '-1');

            $data = [
                'cuti' => empty($this->request->getvar('peminta')) ? $this->tranModel->getCekcuti($this->request->getvar('mode'), $this->request->getvar('pegawai'), $tgl_aw, $this->request->getvar('tanggal')) : $this->tranModel->getCuti('', $this->request->getvar('peminta'), $this->request->getvar('pegawai'), $tgl_aw, $this->request->getvar('tanggal')),
                'menu' => $this->request->getvar('menu'),
            ];
            $msg = ['data' => view('x-hrd/mintacuti_tabel', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
    public function tabelnilaipegawai()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'nilai' => $this->tranModel->getNilaiPegawai($this->request->getvar('pegawai'), $this->request->getvar('tanggal')),
                'menu' => $this->request->getvar('menu'),
            ];
            $msg = ['data' => view('x-hrd/nilaipegawai_tabel', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function tabellogaksi()
    {
        if ($this->request->isAJAX()) {
            $data = ['log' => $this->tranModel->getLogaksi($this->request->getvar('idunik'), $this->request->getvar('asal'), $this->request->getvar('pilihan'))];
            $msg = ['data' => view('x-modal/show_logaksi', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
