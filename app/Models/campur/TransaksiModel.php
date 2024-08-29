<?php

namespace App\Models\campur;

use CodeIgniter\Database\BaseBuilder; //sub query
use CodeIgniter\Database\MySQLi\Builder;

class TransaksiModel
{
    protected $db;
    public function __construct()
    {
        $this->db = \config\Database::connect();
    }

    // if ($minta && in_array($minta['0']->st_setuju, ['2', '4', '5', '6', '7'])) $stadð = 'disabled';
    // ____________________________________________________________________________________________________________________________
    public function update1Data($tabel, $fieldset, $nilaiset, $fieldwhere, $nilaiwhere)
    {
        $builder = $this->db->table($tabel);
        $builder->set($fieldset, $nilaiset)->where($fieldwhere, $nilaiwhere);
        $builder->update();
    }
    // ____________________________________________________________________________________________________________________________
    // public function UpdatePOPesanAnak($popesan, $pominta, $penerima, $pajak)
    // {
    //     $builder = $this->db->table('po_anak');
    //     $builder->set('popesan_id', $popesan)->where('pominta_id', $pominta)->where('penerima_id', $penerima)->where('st_pajak', $pajak);
    //     $builder->update();
    // }

    // public function delID($data)
    // {
    //     $builder = $this->db->table('m_idunik');
    //     $builder->delete(['idunik' => $data]);
    // }
    // // // public function updateRevisi($table, $idunik, $norevisi)
    // // // {
    // // //     $builder = $this->db->table($table);
    // // //     $builder->set('norevisi', $norevisi)->where('idunik', $idunik);
    // // //     $builder->set('st_rev', '0')->where('idunik', $idunik);
    // // //     $builder->update();
    // // // }
    public function getnoDokumen($table, $awal, $tahun)
    {
        $builder = $this->db->table($table);
        $builder->like('nodokumen', $awal, 'after')->like('nodokumen', $tahun);
        $builder->orderby('right(nodokumen,4) DESC');
        $builder->limit(1);
        return $builder->get()->getResult();
    }

    // ____________________________________________________________________________________________________________________________
    public function getAnggaraninduk($menu, $perusahaan, $wilayah, $divisi, $tahun, $pilih, $tujuan)
    {
        $builder = $this->db->table('anggaran_induk a');
        $builder->select('a.*, b.total_kontrak_cco as totallev1, c.kode as perusahaan, d.nama as wilayah, e.nama as divisi, f.kode as proyek, f.paket as paketproyek, f.periode1 as tahunproyek,
            g.kode as ruas, g.nama as namaruas, h.kode as camp, h.nama as namacamp, j.kode as alat, j.nomor as nomoralat, j.nama as namaalat, k.kode as tanah, k.nama as namatanah, x.id as xlog');
        if ($perusahaan != '') $builder->where('a.perusahaan_id', $perusahaan);
        if ($wilayah != '') $builder->where('a.wilayah_id', $wilayah);
        if ($divisi != '') $builder->where('a.divisi_id', $divisi);
        if ($tahun != '') ($tujuan == 'proyek' ? $builder->where("(f.periode1 like \"%$tahun%\")") : $builder->where("(a.tanggal1 like \"%$tahun%\")"));
        if ($pilih != '') $builder->where('a.pilihan', $pilih);
        ($menu == 'anggobjek') ? $builder->where(['a.ruas_id' => null]) : $builder->where(['a.ruas_id !=' => null]);
        $builder->where('a.tujuan', $tujuan);
        // $builder->where('b.levsatu', '1')->whereIn('a.is_use', ['0', '1']);
        $builder->where('b.levsatu', '1');
        $strx = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.created_by = "' . session()->usernama . '"' : '');
        $builder->where(['a.deleted_at' => null]);
        $builder->join('anggaran_anak b', 'a.id=b.anggaraninduk_id', 'left');
        $builder->join('m_perusahaan c', 'a.perusahaan_id=c.id', 'left');
        $builder->join('m_divisi d', 'a.wilayah_id=d.id', 'left');
        $builder->join('m_divisi e', 'a.divisi_id=e.id', 'left');
        $builder->join('m_proyek f', 'a.beban_id=f.id', 'left');
        $builder->join('m_ruas g', 'a.ruas_id=g.id', 'left');
        $builder->join('m_camp h', 'a.beban_id=h.id', 'left');
        $builder->join('m_alat j', 'a.beban_id=j.id', 'left');
        $builder->join('m_tanah k', 'a.beban_id=k.id', 'left');
        $builder->join('log_data x', 'x.idunik = a.idunik' . $strx, 'left');
        $builder->groupBy('a.id')->orderby('a.nodoc, a.beban_id, a.ruas_id, a.adendum, a.revisi');
        return $builder->get()->getResult();
    }
    public function getAnggarananak($induk, $kategori, $level = false)
    {
        $builder = $this->db->table('anggaran_anak a');
        $builder->select('a.*, b.noakun as noakun, b.nama as namaakun, b.level as levelakun, c.kode as biaya, c.nama as namabiaya, c.matabayar as matabayar, c.satuan as satuan, c.level as levelbiaya');
        $builder->where('a.anggaraninduk_id', $induk)->where(['a.deleted_at' => null]);
        if ($kategori != '') $builder->where('c.tipe_id', $kategori);
        $builder->join('m_akun b', 'a.akun_id = b.id', 'left');
        $builder->join('m_biaya c', 'a.biaya_id = c.id', 'left');
        $builder->orderby('b.noakun, c.kode, a.id');
        return $builder->get()->getResult();
    }
    public function cekAnggaraninduk($pilihan, $tujuan, $jenis, $beban, $ruas, $noadd = false, $norev = false)
    {
        $builder = $this->db->table('anggaran_induk');
        $builder->where('pilihan', $pilihan)->where('tujuan', $tujuan);
        if ($beban != '') $builder->where('beban_id', $beban);
        if ($ruas != '') $builder->where('ruas_id', $ruas);
        if ($noadd == true) $builder->where('adendum', $noadd)->where('revisi', $norev);
        $builder->where(['deleted_at' => null]);
        return $builder->get()->getResult();
    }
    public function cekAnggarananak($indukbudget, $field, $data)
    {
        $builder = $this->db->table('anggaran_anak');
        $builder->where('anggaraninduk_id', $indukbudget)->where($field, $data);
        return $builder->get()->getResult();
    }
    public function getAnggarantotal($indukbudget, $indukbiaya, $tabel)
    {
        $builder = $this->db->table('anggaran_anak a');
        $builder->select('sum(a.total_kontrak) as totalkontrak,sum(a.total_kerja) as totalkerja,sum(a.total_kontrak_cco) as totalkontrakcco,sum(a.total_kerja_cco) as totalkerjacco');
        $builder->where('a.anggaraninduk_id', $indukbudget)->where(['a.deleted_at' => null]);
        $builder->where('b.induk_id', $indukbiaya);
        $builder->groupBy('b.induk_id');
        ($tabel == 'akun' ? $builder->join('m_akun b', 'a.akun_id = b.id', 'left') : $builder->join('m_biaya b', 'a.biaya_id = b.id', 'left'));
        return $builder->get()->getResult();
    }
    public function loadAnggaran($tujuan, $ruas, $beban, $tipe, $tanggal)
    {
        $builder = $this->db->table('anggaran_anak a');
        $builder->select('a.*, e.id as idbiaya, e.kode as kodebiaya, e.nama as namabiaya, e.akun_id as akunbiaya, f.id as idakun, f.noakun as noakun, f.nama as namaakun');
        $builder->where('b.tujuan', $tujuan)->where('b.beban_id', $beban);
        // $builder->where('b.is_use', '1')->where(['b.deleted_at' => null]);
        // $builder->where('a.tanggal BETWEEN "' . date('Y-m-d', strtotime($awal)) . '" and "' . date('Y-m-d', strtotime($akhir)) . '"');
        if ($ruas != '') { //level 3
            $builder->where('b.ruas_id', $ruas)->where('c.tipe_id', $tipe); //proyek
            $builder->where('e.level', '3');
        } else {
            ($tujuan == 'proyek' ? $builder->where('e.level', '4') : $builder->where('f.level', '4'));
        }
        $builder->join('anggaran_induk b', 'a.anggaraninduk_id=b.id', 'left');
        $builder->join('m_proyek c', 'b.beban_id=c.id', 'left');
        $builder->join('m_biaya e', 'a.biaya_id=e.id', 'left');
        $builder->join('m_akun f', 'a.akun_id=f.id', 'left');
        ($tujuan == 'proyek') ? $builder->orderby('e.kode') : $builder->orderby('f.noakun');
        return $builder->get()->getResult();
    }

    // public function getAnggarancabanginduk($menu, $perusahaan = false, $wilayah = false, $divisi = false, $tahun = false, $tujuan = false, $status = false)
    // {
    //     //isconf 0=new 1=need save 2=save 3=confirm 4=cancel
    //     $builder = $this->db->table('anggaran_induk a');
    //     $builder->select('a.*, c.kode as perusahaan, d.nama as wilayah, e.nama as divisi, f.kode as kodealat, f.nama as namaalat, g.kode as kodecamp, g.nama as namacamp, h.kode as kodetanah, h.nama as namatanah, x.id as xlog');
    //     if ($perusahaan == true) $builder->where('a.perusahaan_id', $perusahaan);
    //     if ($wilayah == true) $builder->where('a.wilayah_id', $wilayah);
    //     if ($divisi == true) $builder->where('a.divisi_id', $divisi);
    //     if ($tahun == true) $builder->where("(a.tanggal1 like \"%$tahun%\" OR a.tanggal1 IS NULL)");
    //     // ($status != '') ? $builder->where('a.st_confirm', $status) : '';
    //     $builder->where('a.tujuan', $tujuan);
    //     $strx = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.created_by = "' . session()->usernama . '"' : '');
    //     $builder->where('a.tujuan', $tujuan);
    //     $builder->where(['a.deleted_at' => null]);
    //     $builder->join('m_perusahaan c', 'a.perusahaan_id=c.id', 'left');
    //     $builder->join('m_divisi d', 'a.wilayah_id=d.id', 'left');
    //     $builder->join('m_divisi e', 'a.divisi_id=e.id', 'left');
    //     $builder->join('m_alat f', 'a.tujuan_id=f.id', 'left');
    //     $builder->join('m_camp g', 'a.tujuan_id=g.id', 'left');
    //     $builder->join('m_tanah h', 'a.tujuan_id=h.id', 'left');
    //     $builder->join('log_data x', 'x.idunik = a.idunik' . $strx, 'left');
    //     $builder->groupBy('a.id')->orderby('f.kode,g.kode,h.kode,a.noadendum,a.norevisi');
    //     return $builder->get()->getResult();
    // }

    public function getAnggarancabanganak($induk, $level = false)
    {
        $builder = $this->db->table('anggaran_anak a');
        $builder->select('a.*,b.noakun as noakun, b.nama as namaakun,b.level as level');
        $builder->where('a.anggaraninduk_id', $induk)->where(['a.deleted_at' => null]);
        if ($level == true) $builder->where('b.level', $level);
        $builder->join('m_akun b', 'a.akun_id = b.id', 'left');
        $builder->orderby('b.noakun');
        return $builder->get()->getResult();
    }

    // ____________________________________________________________________________________________________________________________
    public function getPOminta($menu, $user = false, $status = false, $level = false, $sama = false, $awal = false, $akhir = false, $perusahaan = false, $wilayah = false, $divisi = false)
    // status setuju =>0:new, c:belum sama, 1:save tunda, 2:proses cek/setuju, 3:revisi, 4:tolak, 5:batal, 6:gudang, 7:ok, 8:Purchase, 9:Selesai
    {
        $builder = $this->db->table('po_minta a');
        $builder->select('a.*, b.kode as perusahaan, c.nama as divisi, d.nama as wilayah, e.kode as kodeuser, f.kode as kodepeminta, x.id as xlog');
        if ($menu == 'mintabarang') {
            $builder->where("(a.user_id LIKE '$user' OR peminta_id LIKE '$user')");
            if ($status != 'all') $builder->where('a.status', $status);
        }
        // if ($menu == 'cekbarang') {
        //     $builder->where('a.status BETWEEN 1 AND 8');
        //     if ($level != '') $builder->whereIn('a.status', ['1', '2'])->where('a.level_pos', $level);
        // }
        if ($menu == 'cekbarang') $builder->whereIn('a.status', ['1', '2']);
        if ($menu == 'cekada') $builder->whereIn('a.status', ['6', '7']);
        if ($menu == 'tawarharga') $builder->whereIn('a.status', ['7', '8']);
        if ($menu == 'pilihharga') $builder->whereIn('a.status', ['8']);
        if ($perusahaan == true) $builder->where('a.perusahaan_id', $perusahaan);
        if ($wilayah == true) $builder->where('a.wilayah_id', $wilayah);
        if ($divisi == true) $builder->where('a.divisi_id', $divisi);
        $builder->where('a.tanggal BETWEEN "' . date('Y-m-d', strtotime($awal)) . '" and "' . date('Y-m-d', strtotime($akhir)) . '"');
        $builder->where(['a.deleted_at' => null]);
        $strx = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.created_by = "' . session()->usernama . '"' : '');
        $builder->join('m_perusahaan b', 'a.perusahaan_id=b.id', 'left');
        $builder->join('m_divisi c', 'a.divisi_id=c.id', 'left');
        $builder->join('m_divisi d', 'a.wilayah_id=d.id', 'left');
        $builder->join('m_user e', 'a.user_id=e.id', 'left');
        $builder->join('m_user f', 'a.peminta_id=f.id', 'left');
        $builder->join('log_data x', 'x.idunik = a.idunik' . $strx, 'left');
        $builder->groupBy('a.id')->orderby('a.tanggal desc')->orderby('a.nodoc desc');
        return $builder->get()->getResult();
    }
    public function getPOanak($poid, $nodoc = false, $penerima = false, $pajak = false, $popesan = false)
    {
        // count(c.id) as jltawar, , d.nama as namapenerima
        $builder = $this->db->table('po_anak a');
        $builder->select('a.*, c.kode as kodeitem, c.nama as namaitem, c.satuan as satuandetil, d.kode as kodeakun, d.nama as namaakun, count(e.id) as jltawar, e.jumlah as jlorder, e.harga, e.diskon, e.total, e.st_pajak, e.penerima_id');
        $builder->where('a.pominta_id', $poid)->where(['a.deleted_at' => null]);
        $builder->join('po_minta b', 'a.pominta_id=b.id', 'left');
        $builder->join('m_barang c', 'a.item_id=c.id', 'left');
        $builder->join('m_akun d', 'a.item_id=d.id', 'left');
        $builder->join('po_tawar e', 'a.id=e.poanak_id', 'left');
        // $builder->where(['c.deleted_at' => null]);
        // ($nodoc == true) ? $builder->where('f.nodoc', $nodoc)->where('a.penerima_id', $penerima)->where('a.st_pajak', $pajak)->where('a.popesan_id', $popesan) : '';
        // ($nodoc == true) ? $builder->where('f.nodoc', $nodoc)->where('a.penerima_id', $penerima)->where('a.st_pajak', $pajak) : '';
        // $builder->join('po_tawar c', 'a.id=c.anak_id', 'left');
        // $builder->join('m_penerima d', 'a.penerima_id=d.id', 'left');
        $builder->groupby('a.id');
        return $builder->get()->getResult();
    }
    public function cekPOgudang($poid)
    {
        $builder = $this->db->table('po_anak');
        $builder->where('pominta_id', $poid)->where('is_ada', '0')->where(['deleted_at' => null]);
        return $builder->get()->getResult();
    }
    public function getPOtawar($poid, $item = false)
    {
        // count(c.id) as jltawar, , d.nama as namapenerima
        $builder = $this->db->table('po_tawar a');
        $builder->select('a.*, b.jenis, b.satuan, b.spesifikasi, c.kode as kodeitem, c.nama as namaitem, c.satuan as satuandetil, d.kode as kodeakun, d.nama as namaakun, e.nama as namapenerima');
        $builder->where('a.pominta_id', $poid)->where(['a.deleted_at' => null]);
        if ($item == true) $builder->where('a.poanak_id', $item);
        $builder->join('po_anak b', 'a.poanak_id=b.id', 'left');
        $builder->join('m_barang c', 'b.item_id=c.id', 'left');
        $builder->join('m_akun d', 'b.item_id=d.id', 'left');
        $builder->join('m_penerima e', 'a.penerima_id=e.id', 'left');
        $builder->groupby('a.id')->orderby('a.poanak_id');
        return $builder->get()->getResult();
    }
    public function getPOambil($menu, $dist = '1', $tanggal = false, $status = false, $awal = false, $akhir = false)
    {
        $builder = $this->db->table('po_ambil a');
        if ($dist == '1') {
            // $builder->select('a.*, b.kode as perusahaan, c.nama as divisi, d.nama as wilayah, e.nama as pegawai, f.nama as barang x.id as xlog');
            // $builder->where('a.tanggal BETWEEN "' . date('Y-m-d', strtotime($awal)) . '" and "' . date('Y-m-d', strtotime($akhir)) . '"');
            // $builder->where(['a.deleted_at' => null]);
            // $strx = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.created_by = "' . session()->usernama . '"' : '');
            // $builder->join('m_perusahaan b', 'a.perusahaan_id=b.id', 'left');
            // $builder->join('m_divisi c', 'a.divisi_id=c.id', 'left');
            // $builder->join('m_divisi d', 'a.wilayah_id=d.id', 'left');
            // $builder->join('m_penerima e', 'a.pegawai_id=e.id', 'left');
            // $builder->join('m_atk f', 'a.barang_id=f.id', 'left');
            // $builder->join('log_data x', 'x.idunik = a.idunik' . $strx, 'left');
            // $builder->groupBy('a.id')->orderby('a.tanggal desc')->orderby('a.nodoc desc');
        } else {
            $builder->select('a.*, b.kode as perusahaan, c.nama as divisi, d.nama as wilayah, e.nama as pegawai, f.nama as barang, f.satuan as satuan');
            $builder->where('a.tanggal', $tanggal)->where(['a.deleted_at' => null]);
            $builder->join('m_perusahaan b', 'a.perusahaan_id=b.id', 'left');
            $builder->join('m_divisi c', 'a.divisi_id=c.id', 'left');
            $builder->join('m_divisi d', 'a.wilayah_id=d.id', 'left');
            $builder->join('m_penerima e', 'a.penerima_id=e.id', 'left');
            $builder->join('m_atk f', 'a.atk_id=f.id', 'left');
            $builder->orderby('a.nodoc')->orderby('e.nama')->orderby('f.nama');
        }
        return $builder->get()->getResult();
    }
    public function cekPOambil($perusahaan, $wilayah, $divisi, $tanggal)
    {
        $builder = $this->db->table('po_ambil');
        $builder->where('perusahaan_id', $perusahaan)->where('wilayah_id', $wilayah)->where('divisi_id', $divisi);
        $builder->where('tanggal', $tanggal);
        return $builder->get()->getResult();
    }

    // public function cekPurchase($table, $nodoc, $idunik)
    // {
    //     $builder = $this->db->table($table);
    //     $builder->where('nodoc', $nodoc)->where('idunik !=', $idunik);
    //     return $builder->get()->getResult();
    // }

    // public function getDataPOminta($idunik)
    // {
    //     $builder = $this->db->table('po_minta a');
    //     $builder->select('a.*,b.kode as perusahaan,b.nama as namaperusahaan,c.nama as divisi,d.nama as wilayah');
    //     $builder->where('a.idunik', $idunik)->where(['a.deleted_at' => null]);
    //     $builder->join('m_perusahaan b', 'a.perusahaan_id=b.id', 'left');
    //     $builder->join('m_divisi c', 'a.divisi_id=c.id', 'left');
    //     $builder->join('m_divisi d', 'a.wilayah_id=d.id', 'left');
    //     return $builder->get()->getResult();
    // }
    // public function getPOtawar($id)
    // {
    //     $builder = $this->db->table('po_tawar a');
    //     $builder->select('a.*,b.nama as namasuplier,c.jl_beli as jlbeli,c.penerima_id as penerima');
    //     $builder->where('a.poanak_id', $id)->where(['a.deleted_at' => null]);
    //     $builder->join('m_penerima b', 'a.penerima_id=b.id', 'left');
    //     $builder->join('po_anak c', 'a.poanak_id=c.id', 'left');
    //     return $builder->get()->getResult();
    // }
    // public function getDokumenPO($dokumen, $suplier)
    // {
    //     $builder = $this->db->table('po_minta a');
    //     $builder->select('a.*,b.st_pajak as ppn,c.kode as perusahaan,d.nama as wilayah,e.nama as divisi,f.kode as kodeproyek,f.nama as namaproyek,g.kode as kodecamp,g.nama as namacamp,h.kode as kodealat,h.nama as namaalat,j.kode as kodetanah,j.nama as namatanah');
    //     // $builder->where('b.penerima_id', $suplier)->where(['a.deleted_at' => null])->where('b.popesan_id', '0');
    //     $builder->where('b.penerima_id', $suplier)->where(['a.deleted_at' => null]);
    //     $builder->where("(a.nodoc like\"%$dokumen%\")");
    //     $builder->join('po_anak b', 'b.pominta_id=a.id', 'left');
    //     $builder->join('m_perusahaan c', 'c.id=a.perusahaan_id', 'left');
    //     $builder->join('m_divisi d', 'd.id=a.wilayah_id', 'left');
    //     $builder->join('m_divisi e', 'e.id=a.divisi_id', 'left');
    //     $builder->join('m_proyek f', 'f.id=a.cabang_id', 'left');
    //     $builder->join('m_camp g', 'g.id=a.cabang_id', 'left');
    //     $builder->join('m_alat h', 'h.id=a.cabang_id', 'left');
    //     $builder->join('m_tanah j', 'j.id=a.cabang_id', 'left');
    //     $builder->groupby('b.st_pajak')->groupby('a.id', 'desc');
    //     return $builder->get()->getResult();
    // }
    // public function getPOpesan($idunik, $perusahaan = false, $wilayah = false, $divisi = false, $level = false, $status = false, $awal = false, $akhir = false)
    // // status =>0:draft, 1:minta, 2:proses, 3:revisi, 4:tolak, 5:cancel, 6:gudang, 7:harga, 8:dipilih, 9:order, 10:datang, 11:lunas
    // {
    //     $builder = $this->db->table('po_pesan a');
    //     if ($idunik == '') {
    //         $builder->select('a.*,b.kode as perusahaan,c.nama as divisi,d.nama as wilayah,e.nama as suplier,m.userid as peminta, m.pilihan as pilihan');
    //         $builder->where(['a.deleted_at' => null]);
    //         ($perusahaan != '') ? $builder->where('m.perusahaan_id', $perusahaan) : '';
    //         ($wilayah != '') ? $builder->where('m.wilayah_id', $wilayah) : '';
    //         ($divisi != '') ? $builder->where('m.divisi_id', $divisi) : '';
    //         $builder->where('a.tgl_po BETWEEN "' . date('Y-m-d', strtotime($awal)) . '" and "' . date('Y-m-d', strtotime($akhir)) . '"');
    //         $builder->join('po_minta m', 'a.pominta_id=m.id', 'left');
    //         $builder->join('m_perusahaan b', 'm.perusahaan_id=b.id', 'left');
    //         $builder->join('m_divisi c', 'm.divisi_id=c.id', 'left');
    //         $builder->join('m_divisi d', 'm.wilayah_id=d.id', 'left');
    //         $builder->join('m_penerima e', 'a.penerima_id=e.id', 'left');
    //         $builder->orderby('a.tgl_po desc')->orderby('a.nodoc desc');
    //         return $builder->get()->getResult();
    //     }
    //     return $builder->where('idunik', $idunik)->get()->getResult();
    // }
    // public function getDataPOpesan($idunik)
    // {
    //     $builder = $this->db->table('po_minta a');
    //     $builder->select('a.*,b.kode as perusahaan,b.nama as namaperusahaan,c.nama as divisi,d.nama as wilayah,p.pominta_id as pominta,p.st_pajak as stpajak,p.nodoc as nodocpesan,p.tgl_po as tglpo');
    //     $builder->where('p.idunik', $idunik)->where(['p.deleted_at' => null]);
    //     $builder->join('m_perusahaan b', 'a.perusahaan_id=b.id', 'left');
    //     $builder->join('m_divisi c', 'a.divisi_id=c.id', 'left');
    //     $builder->join('m_divisi d', 'a.wilayah_id=d.id', 'left');
    //     $builder->join('po_pesan p', 'a.id=p.pominta_id', 'right');
    //     return $builder->get()->getResult();
    // }
    // public function getPObiaya($idunik)
    // {
    //     $builder = $this->db->table('po_biayaplus a');
    //     $builder->select('a.*,b.spesifikasi,c.nama as namabarang,d.nama as namabiaya');
    //     $builder->where('a.idunik_po', $idunik)->where(['a.deleted_at' => null]);
    //     $builder->join('po_anak b', 'a.poanak_id=b.id', 'left');
    //     $builder->join('m_barang c', 'b.barang_id=c.id', 'left');
    //     $builder->join('m_akun d', 'a.akun_id=d.id', 'left');
    //     return $builder->get()->getResult();
    // }
    // public function getPOmasuk($idunik)
    // {
    //     $builder = $this->db->table('po_masuk a');
    //     $builder->select('a.*,c.jenis as jenis,c.spesifikasi as spesifikasi,d.nama as namabarang,d.satuan as satuan,e.nama as namaakun');
    //     $builder->where('b.idunik', $idunik)->where(['a.deleted_at' => null]);
    //     $builder->join('po_pesan b', 'a.popesan_id=b.id', 'left');
    //     $builder->join('po_anak c', 'a.poanak_id=c.id', 'left');
    //     $builder->join('m_barang d', 'c.barang_id=d.id', 'left');
    //     $builder->join('m_akun e', 'c.barang_id=e.id', 'left');
    //     return $builder->get()->getResult();
    // }
    // public function updatePOminta($idunik, $level, $aksi, $status)
    // {
    //     $builder = $this->db->table('po_minta');
    //     $builder->set('level_pos', $level)->set('aksi', $aksi);
    //     $builder->set('status', $status);
    //     $builder->where('idunik', $idunik);
    //     $builder->update();
    // }

    // // public function getPOtawar($poid) //po anak
    // // {
    // //     $builder = $this->db->table('po_tawar a');
    // //     $builder->select('a.*,b.jumlah as jlpo,c.nama as namasuplier,d.nama as namabarang');
    // //     $builder->where('a.poanak_id', $poid)->where(['a.deleted_at' => null]);
    // //     $builder->join('po_anak b', 'a.poanak_id=b.id', 'left');
    // //     $builder->join('m_penerima c', 'a.penerima_id=c.id', 'left');
    // //     $builder->join('m_barang d', 'b.barang_id=d.id', 'left');
    // //     $builder->orderby('a.id');
    // //     return $builder->get()->getResult();
    // // }

    // // public function allCekbarang($idunik = false)
    // // {
    // //     $builder = $this->db->table('po_minta');
    // //     if ($idunik == false) {
    // //         $builder->select('nominta')->distinct();
    // //         $builder->select('idunik,tanggal,peminta,pilihan,perusahaan,wilayah,divisi,level,aksi,status');
    // //         $builder->orderby('tanggal')->orderby('nominta');
    // //         return $builder->get()->getResult();
    // //     }
    // //     return $builder->where('idunik', $idunik)->get()->getResult();
    // // }
    // // public function allTawar($idunik = false, $id = false)
    // // {
    // //     $builder = $this->db->table('po_minta');
    // //     if ($idunik == false) {
    // //         $builder->select('po_minta.*,nm_barang.nama as namaitem');
    // //         $builder->where(['po_minta.deleted_at' => null]);
    // //         $builder->join('nm_barang', 'po_minta.kode = nm_barang.kode');
    // //         $builder->orderby('tanggal')->orderby('nominta')->orderBy('kode');
    // //         return $builder->get()->getResult();
    // //     }
    // //     return $builder->where(['id' => $id])->where('idunik', $idunik)->get()->getResult();
    // // }
    // // public function getMintabarang($nodoc)
    // // {
    // //     // status =>0:blm acc, 1:minta, 2:harga, 3:dipilih, 4: ditolak, 5: order, 6:datang, 7:retur, 8:lunas

    // //     $builder = $this->db->table('po_minta');
    // //     // $status = ['1', '2', '3', '4'];
    // //     // $builder->wherein('status', $status);
    // //     $builder->select('po_minta.*,nm_barang.nama as namaitem');
    // //     $builder->where('nominta', $nodoc);
    // //     $builder->where(['po_minta.deleted_at' => null]);
    // //     $builder->join('nm_barang', 'po_minta.kode = nm_barang.kode');
    // //     $builder->orderby('po_minta.id');
    // //     return $builder->get()->getResult();
    // // }

    // // public function getNomorurut($awal, $tahun)
    // // {
    // //     $builder = $this->db->table('po_minta');
    // //     $builder->like('nominta', $awal, 'after');
    // //     $builder->like('nominta', $tahun);
    // //     $builder->orderby('right(nominta,4) DESC');
    // //     $builder->limit(1);
    // //     return $builder->get()->getResult();
    // // }
    // // public function updatepermintaanbarang($idunik, $level, $aksi, $status = false)
    // // {
    // //     $builder = $this->db->table('po_minta');
    // //     $builder->set('level', $level);
    // //     $builder->set('aksi', $aksi);
    // //     if ($status == true) {
    // //         $builder->set('status', $status);
    // //     }
    // //     $builder->where('idunik', $idunik);
    // //     $builder->update();
    // // }




    // public function getBudgetBL($proyek, $ruas, $kategori, $tanggal)
    // {
    //     $builder = $this->db->table('budget_anak a');
    //     $builder->select('a.*,b.kode as biaya, b.nama as namabiaya, b.matabayar as matabayar');
    //     $builder->where('c.proyek_id', $proyek)->where('c.ruas_id', $ruas);
    //     $builder->where('b.tipe_id', $kategori)->where('b.level', '3');
    //     // $builder->where('a.is_user', '1')->where('a.st_confirm','2');
    //     $builder->join('budget_induk c', 'a.budgetinduk_id = c.id', 'left');
    //     $builder->join('m_biaya b', 'a.biaya_id = b.id', 'left');
    //     $builder->orderby('b.kode');
    //     return $builder->get()->getResult();
    // }


    // public function cekAdendum($proyek, $ruas)
    // {
    //     $builder = $this->db->table('budget_induk');
    //     $builder->where('proyek_id', $proyek)->where('ruas_id', $ruas);
    //     $builder->where('st_confirm !=', '4');
    //     $builder->orderby('noadendum desc');
    //     $builder->limit(1);
    //     return $builder->get()->getResult();
    // }


    // ____________________________________________________________________________________________________________________________
    // status =>0:minta, 1:butuh acc, 2:proses, 3:revisi, 4:tolak, 5:cancel 6:siap bayar, 7:bayar
    public function getSalesinduk($mode, $status = false, $camp = false, $awal = false, $akhir = false)
    {
        $builder = $this->db->table('sales_induk a');
        $builder->select('a.*,b.kode as camp,c.nama as penerima,d.kode as proyek,e.nama as divisi');
        $builder->where('a.modeorder', $mode)->where(['a.deleted_at' => null]);
        if ($camp == true) $builder->where('a.camp_id', $camp);
        $builder->where('a.st_jual >=', $status);
        $builder->where('a.tanggal BETWEEN "' . date('Y-m-d', strtotime($awal)) . '" and "' . date('Y-m-d', strtotime($akhir)) . '"');
        $builder->join('m_camp b', 'a.camp_id=b.id', 'left');
        $builder->join('m_penerima c', 'a.penerima_id=c.id', 'left');
        $builder->join('m_proyek d', 'a.proyek_id=d.id', 'left');
        $builder->join('m_divisi e', 'a.divisi_id=e.id', 'left');
        $builder->orderby('a.tanggal desc')->orderby('a.nodoc desc');
        return $builder->get()->getResult();
    }
    public function getSalesanak($induk)
    {
        $builder = $this->db->table('sales_anak a');
        $builder->select('a.*, b.id as idbarang, b.kode as kodebarang, b.nama as namabarang, c.nama as kategori, d.kode as kodealat, d.nama as namaalat');
        $builder->where('a.soinduk_id', $induk)->where(['a.deleted_at' => null]);
        $builder->join('m_barang b', 'a.data_id=b.id', 'left');
        $builder->join('m_divisi c', 'a.kategori_id=c.id', 'left');
        $builder->join('m_alat d', 'a.data_id=d.id', 'left');
        return $builder->get()->getResult();
    }
    public function cekSalesinduk($nodoc, $idunik)
    {
        $builder = $this->db->table('sales_induk');
        $builder->where('nodoc', $nodoc)->where('idunik !=', $idunik);
        return $builder->get()->getResult();
    }

    // public function cekSalesinduk($pilih, $cabang, $tujuan, $ruas, $noadd = false, $norev = false)
    // {
    //     $builder = $this->db->table('anggaran_induk');
    //     $builder->where('pilihan', $pilih)->where('tujuan_id', $tujuan);
    //     ($cabang != '') ? $builder->where('tujuan', $cabang) : '';
    //     ($ruas != '') ? $builder->where('ruas_id', $ruas) : '';
    //     ($noadd != '') ? $builder->where('noadendum', $noadd)->where('norevisi', $norev) : '';
    //     return $builder->get()->getResult();
    // }



    public function getDokumen($pilih, $camp, $proyek = false)
    {
        $builder = $this->db->table('jual_induk a');
        $builder->select('a.*,b.kode as proyek,b.paket as paket');
        $builder->where('a.pilihan', $pilih);
        if ($proyek == true) $builder->where('a.proyek_id !=', '0');
        if ($camp != '') $builder->where('a.cabang_id', $camp);
        $builder->join('m_proyek b', 'a.proyek_id=b.id', 'left');
        $builder->orderby('a.nodoc desc');
        return $builder->get()->getResult();
    }
    public function getKategoriSOsewa($idanak)
    {
        $builder = $this->db->table('jual_anak a');
        $builder->select('a.kategori_id, c.nama as kategori');
        $builder->where('a.id', $idanak);
        $builder->join('m_divisi c', 'a.kategori_id=c.id', 'left');
        return $builder->get()->getResult();
    }
    // ____________________________________________________________________________________________________________________________
    public function getTiket($docjual)
    {
        $builder = $this->db->table('tiket_camp a');
        $builder->select('a.*, c.nama as namabahan, d.nomor as nopol, e.nama as namasupir, f.nama as namaruas');
        $builder->where('a.sojual_id', $docjual);
        $builder->join('jual_induk b', 'a.sojual_id=b.id', 'left');
        $builder->join('m_barang c', 'a.barang_id=c.id', 'left');
        $builder->join('m_alat d', 'a.alat_id=d.id', 'left');
        $builder->join('m_penerima e', 'a.supir_id=e.id', 'left');
        $builder->join('m_ruas f', 'a.subruas_id=f.id', 'left');
        $builder->orderby('a.tanggal desc');
        return $builder->get()->getResult();
    }
    public function loadtiket($isi)
    {
        $builder = $this->db->table('tiket_camp a');
        $builder->select('a.id, a.notiket, b.nomor as nopol, b.nama as namaalat');
        $builder->where("(a.notiket like \"%$isi%\" or b.nomor like \"%$isi%\" or b.nama like \"%$isi%\")");
        $builder->join('m_alat b', 'a.alat_id=b.id', 'left');
        $builder->orderby('a.notiket desc');
        return $builder->get()->getResult();
    }

    // ____________________________________________________________________________________________________________________________
    public function loadts($isi)
    {
        $builder = $this->db->table('tiket_camp a');
        $builder->select('a.id, a.notiket, b.nomor as nopol, b.nama as namaalat');
        $builder->where("(a.notiket like \"%$isi%\" or b.nomor like \"%$isi%\" or b.nama like \"%$isi%\")");
        $builder->join('m_alat b', 'a.alat_id=b.id', 'left');
        $builder->orderby('a.notiket desc');
        return $builder->get()->getResult();
    }


    // // public function getCekpajak($nodoc)
    // // {
    // //     $builder = $this->db->table('log_aksi');
    // //     $builder->where('nodoc', $nodoc);
    // //     $builder->where('aksi', 'cek');
    // //     $builder->orderby('id', 'desc');
    // //     $builder->limit(1);
    // //     return $builder->get()->getResult();
    // // }
    // // public function updateLogaksi($nodoc)
    // // {
    // //     $builder = $this->db->table('log_aksi');
    // //     $builder->set('lama', '1')->where('nodoc', $nodoc);
    // //     $builder->update();
    // // }
    // // // ____________________________________________________________________________________________________________________________
    // // public function getTawarbarang($id)
    // // {
    // //     $builder = $this->db->table('po_tawar');
    // //     $builder->select('po_tawar.*,m_person.nama as namasuplier')->where('id_minta', $id);
    // //     $builder->join('m_person', 'm_person.kode = po_tawar.suplier');
    // //     $builder->orderby('suplier');
    // //     return $builder->get()->getResult();
    // // }
    // // public function updatePenawaran($id, $idminta)
    // // {
    // //     $builder = $this->db->table('po_tawar');
    // //     $builder->set('pilih', '0')->where('id_minta', $idminta);
    // //     $builder->update();
    // //     $builder->set('pilih', '1')->where('id', $id);
    // //     $builder->update();
    // // }





    // ____________________________________________________________________________________________________________________________
    // status =>0:minta, 1:butuh acc, 2:proses, 3:revisi, 4:tolak, 5:cancel 6:siap bayar, 7:bayar
    // public function getKasinduk($idunik, $proses = false, $userid = false, $perusahaan = false, $wilayah = false, $divisi = false, $asal = false, $awal = false, $akhir = false)
    // {
    //     $builder = $this->db->table('kas_induk a');
    //     if ($idunik == false) {
    //         $builder->select('a.*,b.kode as perusahaan,c.nama as divisi,d.nama as wilayah');
    //         $builder->where("(peminta like\"%$userid%\" or userid like\"%$userid%\")");
    //         $builder->where("(a.asal like\"%$asal%\")")->where(['a.deleted_at' => null]);
    //         ($perusahaan != '') ? $builder->where('a.perusahaan_id', $perusahaan) : '';
    //         ($wilayah != '') ? $builder->where('a.wilayah_id', $wilayah) : '';
    //         ($divisi != '') ? $builder->where('a.divisi_id', $divisi) : '';
    //         $builder->where('a.status >=', $proses);
    //         $builder->where('a.tgl_minta BETWEEN "' . date('Y-m-d', strtotime($awal)) . '" and "' . date('Y-m-d', strtotime($akhir)) . '"');
    //         $builder->join('m_perusahaan b', 'a.perusahaan_id=b.id', 'left');
    //         $builder->join('m_divisi c', 'a.divisi_id=c.id', 'left');
    //         $builder->join('m_divisi d', 'a.wilayah_id=d.id', 'left');
    //         $builder->orderby('a.tgl_minta desc')->orderby('a.nodoc desc');
    //         return $builder->get()->getResult();
    //     }
    //     return $builder->where('idunik', $idunik)->get()->getResult();
    // }

    // ____________________________________________________________________________________________________________________________
    public function getKasinduk($menu, $param = false, $user = false, $status = false, $level = false, $awal = false, $akhir = false, $perusahaan = false, $divisi = false)
    // status setuju =>0:new, c:belum sama, 1:save tunda, 2:proses cek/setuju, 3:revisi, 4:tolak, 5:batal, 6:gudang, 7:ok, 8:Purchase, 9:Selesai
    {
        $builder = $this->db->table('kas_induk a');
        $builder->select('a.*, x.id as xlog');
        $builder->where("(a.usernama LIKE '$user' OR a.peminta LIKE '$user')");
        if ($param == true) $builder->where('a.param', $param);
        if ($status == true) $builder->where('substring(a.status,2,1)', $status);
        if ($perusahaan == true) $builder->where('a.perusahaan_id', $perusahaan);
        if ($divisi == true) $builder->where('a.divisi_id', $divisi);
        $builder->where('a.tgl_minta BETWEEN "' . date('Y-m-d', strtotime($awal)) . '" and "' . date('Y-m-d', strtotime($akhir)) . '"');
        $builder->where(['a.deleted_at' => null]);
        $strx = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.usernama = "' . session()->usernama . '"' : '');
        $builder->join('user_log x', 'x.idunik = a.idunik' . $strx, 'left');
        $builder->groupBy('a.id')->orderby('a.tgl_minta desc')->orderby('a.nodokumen desc');
        return $builder->get()->getResult();
    }
    // // // public function cariRevisikas($idunik)
    // // // {
    // // //     $builder = $this->db->table('kas_beban');
    // // //     $builder->selectmax('norevisi')->where('idunik', $idunik);
    // // //     return $builder->get()->getResult();
    // // // }
    // // public function getDatakasinduk($idunik)
    // // {
    // //     $builder = $this->db->table('kas_induk a');
    // //     $builder->select('a.*,b.kode as perusahaan,b.nama as namaperusahaan,c.nama as divisi,d.nama as wilayah,e.kode as penerima,e.nama as namapenerima');
    // //     $builder->where('a.idunik', $idunik)->where(['a.deleted_at' => null]);
    // //     $builder->join('m_perusahaan b', 'a.perusahaan_id=b.id', 'left');
    // //     $builder->join('m_divisi c', 'a.divisi_id=c.id', 'left');
    // //     $builder->join('m_divisi d', 'a.wilayah_id=d.id', 'left');
    // //     $builder->join('m_penerima e', 'a.penerima_id=e.id', 'left');
    // //     return $builder->get()->getResult();
    // // }
    public function getKasanak($kasid, $field = false, $nilai = false)
    {
        $builder = $this->db->table('kas_anak a');
        // , g.nama as namasupir, h.nama as namabarang 
        $builder->select('a.*, b.tujuan as tujuan, c.kode as ruas, d.kode as biaya, d.nama as namabiaya, e.kode as sumberdaya, e.nama as namasumberdaya, f.noakun as noakun, f.nama as namaakun,');
        $builder->where('a.kasinduk_id', $kasid)->where(['a.deleted_at' => null]);
        if ($field == true) $builder->where('a.' . $field, $nilai);
        $builder->join('kas_induk b', 'a.kasinduk_id = b.id', 'left');
        $builder->join('m_ruas c', 'a.ruas_id = c.id', 'left');
        $builder->join('m_biaya d', 'a.biaya_id = d.id', 'left');
        $builder->join('m_biaya e', 'a.sumberdaya_id = e.id', 'left');
        $builder->join('m_akun f', 'a.akun_id = f.id', 'left');

        // $builder->join('m_penerima g', 'a.supir_id = g.id', 'left');
        // $builder->join('m_barang h', 'a.barang_id = h.id', 'left');
        $builder->orderby('a.id');
        return $builder->get()->getResult();
    }
    public function getKasdetil($indukid)
    {
        $builder = $this->db->table('kas_detil a');
        $builder->select('a.*,b.noakun as noakun, b.nama as namaakun');
        $builder->where('a.kasinduk_id', $indukid)->where(['a.deleted_at' => null]);
        $builder->join('m_akun b', 'a.biaya_id = b.id', 'left');
        $builder->orderby('a.id');
        return $builder->get()->getResult();
    }
    // // // public function getUMkeluar($penerima)
    // // // {
    // // //     $builder = $this->db->table('kas_beban');
    // // //     $builder->where('penerima', $penerima)->where('asal', 'umkeluar');
    // // //     $builder->where('debit <> bayar');
    // // //     $builder->where(['deleted_at' => null]);
    // // //     $builder->orderby('pilihan', 'cabang', 'id');
    // // //     return $builder->get()->getResult();
    // // // }
    public function getPiutang($penerima, $pilihan)
    {
        $builder = $this->db->table('kas_anak a');
        $builder->select('a.*,b.id as idinduk,b.tgl_minta as tanggal,b.nodoc as nodoc, c.noakun as noakun,sum(d.kredit) as bayar'); //, sum(d.kredit) as bayar');
        $builder->where('b.penerima_id', $penerima)->where('b.pilihan', $pilihan);
        $builder->where('b.asal', 'kasum')->where(['b.deleted_at' => null]);
        $builder->join('kas_induk b', 'a.kasinduk_id=b.id', 'left');
        $builder->join('m_akun c', 'a.akun_id=c.id', 'left');
        $builder->join('kas_detil d', 'a.id=d.kasanak_id', 'left');
        $builder->groupBy('a.id');
        $builder->orderby('right(b.nodoc,4) DESC');
        return $builder->get()->getResult();

        // return $builder->getCompiledSelect();
    }
    // // public function getNomorkas($awal, $tahun)
    // // {
    // //     $builder = $this->db->table('kas_induk');
    // //     $builder->like('nodoc', $awal, 'after');
    // //     $builder->like('nodoc', $tahun);
    // //     $builder->orderby('right(nodoc,4) DESC');
    // //     $builder->limit(1);
    // //     return $builder->get()->getResult();
    // // }
    public function updateKasinduk($idunik, $level, $status, $cek, $setuju, $pajak)
    {
        $builder = $this->db->table('kas_induk');
        ($level != '') ? $builder->set('level_pos', $level) : '';
        ($status != '') ? $builder->set('status', $status) : '';
        ($cek != '') ? $builder->set('st_cek', $cek) : '';
        ($setuju != '') ? $builder->set('st_setuju', $setuju) : '';
        ($pajak != '') ? $builder->set('st_pajak', $pajak) : '';
        $builder->where('idunik', $idunik);
        $builder->update();
    }
    public function updateBayarKas($id, $cek, $setuju, $pajak)
    {
        $builder = $this->db->table('kas_induk');
        $status = (($cek == '1') && ($setuju == '1') && ($pajak == '1')) ? '6' : '2';
        $builder->set('status', $status);
        $builder->where('id', $id);
        $builder->update();
    }
    public function getsumKasanak($indukid)
    {
        $builder = $this->db->table('kas_anak');
        $builder->selectSum('debit');
        $builder->selectSum('kredit');
        $builder->where('kasinduk_id', $indukid)->where(['deleted_at' => null]);
        // $builder->where('asal', 'biaya');
        return $builder->get()->getResult();
    }

    // // // public function getPurchaseMinta($idunik, $usernama)
    // // // {
    // // //     $builder = $this->db->table('po_minta');
    // // //     if (empty($idunik)) {
    // // //         $builder->where(['peminta' => $usernama]);
    // // //         $builder->orderby('tanggal')->orderby('nominta')->orderby('nama');
    // // //         return $builder->get()->getResult();
    // // //     }
    // // //     return $builder->where(['idunik' => $idunik])->get()->getResult();
    // // // }

    // ____________________________________________________________________________________________________________________________
    public function getCuti($idunik, $userid = false, $pegawai = false, $awal = false, $akhir = false)
    {
        $builder = $this->db->table('hrd_cuti a');
        if ($idunik == false) {
            $builder->select('a.*,b.kode as perusahaan,c.nama as divisi,d.nama as wilayah,e.nama as pegawai');
            $builder->where("(userid like '%$userid%')");
            ($pegawai != '') ? $builder->Where('a.pegawai_id', $pegawai) : '';
            $builder->where('a.tgl_minta BETWEEN "' . date('Y-m-d', strtotime($awal)) . '" and "' . date('Y-m-d', strtotime($akhir)) . '"');
            $builder->join('m_perusahaan b', 'a.perusahaan_id=b.id', 'left');
            $builder->join('m_divisi c', 'a.divisi_id=c.id', 'left');
            $builder->join('m_divisi d', 'a.wilayah_id=d.id', 'left');
            $builder->join('m_pegawai e', 'a.pegawai_id=e.id', 'left');
            $builder->orderby('a.tgl_minta desc')->orderby('a.nodoc desc');
            return $builder->get()->getResult();
        }
        return $builder->where('idunik', $idunik)->get()->getResult();
    }
    public function getCekcuti($mode, $pegawai = false, $awal = false, $akhir = false)
    {
        $builder = $this->db->table('hrd_cuti a');
        $builder->select('a.*,b.kode as perusahaan,c.nama as divisi,d.nama as wilayah,e.nama as pegawai');
        ($mode != 'hrd') ? $builder->Where('e.atasan_id', $pegawai) : '';
        $builder->where('a.tgl_minta BETWEEN "' . date('Y-m-d', strtotime($awal)) . '" and "' . date('Y-m-d', strtotime($akhir)) . '"');
        $builder->join('m_perusahaan b', 'a.perusahaan_id=b.id', 'left');
        $builder->join('m_divisi c', 'a.divisi_id=c.id', 'left');
        $builder->join('m_divisi d', 'a.wilayah_id=d.id', 'left');
        $builder->join('m_pegawai e', 'a.pegawai_id=e.id', 'left');
        $builder->orderby('a.tgl_minta desc')->orderby('a.nodoc desc');
        return $builder->get()->getResult();
    }
    public function updateHrdcuti($idunik, $field, $status, $potong)
    {
        $builder = $this->db->table('hrd_cuti');
        ($field != '') ? $builder->set($field, '1') : '';
        ($status != '') ? $builder->set('status', $status) : '';
        ($potong != '') ? $builder->set('potong', $potong) : '';
        $builder->where('idunik', $idunik);
        $builder->update();
    }
    public function getNilaiPegawai($pegawai, $bulan)
    {
        $builder = $this->db->table('m_pegawai a');
        $builder->select('a.*,b.kode as perusahaan,c.nama as divisi,d.nama as wilayah,e.idunik as hrdunik');
        $builder->Where('a.atasan_id', $pegawai);
        // $builder->where("e.tgl_nilai = DATE_FORMAT(:tanggal, '%Y-%m')", ['tanggal' => $tanggal]);
        $builder->join('m_perusahaan b', 'a.perusahaan_id=b.id', 'left');
        $builder->join('m_divisi c', 'a.divisi_id=c.id', 'left');
        $builder->join('m_divisi d', 'a.wilayah_id=d.id', 'left');
        $builder->join('hrd_nilai e', 'a.id=e.pegawai_id', 'left');
        $builder->orderby('a.kode');
        return $builder->get()->getResult();
    }

    // ____________________________________________________________________________________________________________________________
    public function getLogaksi($idunik, $menu, $pilihan)
    {
        $builder = $this->db->table('log_aksi a');
        $builder->select('a.*, b.nama as pegawai, c.kode as usernama, d.nama as divisipegawai');
        $builder->where('a.pilihan', $pilihan)->where('a.menu', $menu)->where('a.idunik', $idunik);
        $builder->join('m_penerima b', 'a.user_id=b.user_id', 'left');
        $builder->join('m_user c', 'a.user_id=c.id', 'left');
        $builder->join('m_divisi d', 'b.divisi_id=d.id', 'left');
        $builder->orderby('a.created_at', 'desc');
        return $builder->get()->getResult();
    }
}
