<?php

namespace App\Models\campur;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\MySQLi\Builder;

class MainModel
{
    protected $db;
    public function __construct()
    {
        $this->db = \config\Database::connect(); //diganti dengan db_connect();
        // $this->db = db_connect();
    }

    // ____________________________________________________________________________________________________________________________
    public function satuID($table, $data, $userlog = 'n', $field = 'idunik', $aktif = false, $delete = false)
    {
        if ($userlog == 'u') {
            $builder = $this->db->table("$table a");
            $builder->select('a.*, p.kode as saveby, q.kode as confby, r.kode as aktifby');
            $builder->where("a.$field", $data)->where(['a.deleted_at' => null]);
            // if ($aktif == true) $builder->where('is_confirm', '1')->where('is_aktif', '1');
            $builder->join('m_user p', 'p.id = a.save_by', 'left');
            $builder->join('m_user q', 'q.id = a.conf_by', 'left');
            $builder->join('m_user r', 'r.id = a.aktif_by', 'left');
        } else {
            $builder = $this->db->table($table);
            $builder->where("$field", $data);
            // if ($delete == false) $builder->where(['deleted_at' => null]);
            //            if ($aktif == true) $builder->where('is_confirm', '1')->where('is_aktif', '1');
        }
        return $builder->get()->getResult();
    }


    // public function lastID($table)
    // {
    //     $builder = $this->db->table($table);
    //     $builder->orderby('id desc');
    //     $builder->limit(1);
    //     return $builder->get()->getResult();
    // }
    public function distSelect($param, $kelompok = false)
    {
        $builder = $this->db->table('m_select');
        ($kelompok == false) ? $builder->select('*') : $builder->select('kelompok')->distinct();
        $builder->where('param', $param);
        $builder->orderBy('nomor');
        return $builder->get()->getResult();
    }
    public function distItem($table, $field, $fieldfilter = false, $fieldcari = false)
    {
        $builder = $this->db->table($table);
        $builder->select('*')->where("$field !=", '');
        if ($fieldfilter == true) $builder->where($fieldfilter, $fieldcari);
        $builder->where(['deleted_at' => null]);
        $builder->groupBy($field)->orderBy($field);
        return $builder->get()->getResult();
    }

    // ____________________________________________________________________________________________________________________________
    public function updateData($table, $field, $data, $filter1, $datafilter1, $filter2 = false, $datafilter2 = false)
    {
        $builder = $this->db->table($table);
        $builder->set($field, $data);
        $builder->where($filter1, $datafilter1);
        if ($filter2 == true) $builder->where($filter2, $datafilter2);
        $builder->update();
    }
    // public function updateDeletedat($table, $id, $hapus = false)
    // {
    //     $builder = $this->db->table($table);
    //     $builder->where('id', $id);
    //     $builder->update(['deleted_at' => null]);
    // }



    // ____________________________________________________________________________________________________________________________
    public function getRole($menu, $aktif = false)
    {
        $builder = $this->db->table('m_role a');
        $builder->select('a.*, (select count(b.id) from m_user b where b.role_id = a.id) as jluser, x.id as xlog');
        if ($aktif == true) $builder->where('substring(a.kondisi, 2, 1)', '1')->where('substring(a.kondisi, 3, 1)', '1');
        $strx = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.usernama = "' . session()->usernama . '"' : '');
        $builder->where(['a.deleted_at' => null]);
        $builder->join('m_user b', 'b.role_id = a.id', 'left');
        $builder->join('user_log x', 'x.idunik = a.idunik' . $strx, 'left');
        $builder->groupby('a.id')->orderby('a.nama');
        return $builder->get()->getResult();
    }
    public function cekRole($nama, $idunik)
    {
        $builder = $this->db->table('m_role');
        $builder->where('nama', $nama)->where('idunik !=', $idunik);
        return $builder->get()->getResult();
    }
    public function getUser($menu, $atasan = false, $aktif = false)
    {
        $builder = $this->db->table('m_user a');
        $builder->select('a.*, b.nama as role, c.nama as namauser, d.peminta as peminta, x.id as xlog');
        if ($atasan == true) $builder->where('a.atasan_id', $atasan);
        if ($aktif == true) $builder->where('substring(a.kondisi, 2, 1)', '1')->where('substring(a.kondisi, 3, 1)', '1');
        $strx = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.usernama = "' . session()->usernama . '"' : '');
        $builder->join('m_role b', 'a.role_id = b.id', 'left');
        $builder->join('m_penerima c', 'a.id = c.user_id', 'left');
        $builder->join('user_token d', 'a.token_id = d.id', 'left');
        $builder->join('user_log x', 'x.idunik = a.idunik' . $strx, 'left');
        $builder->where(['a.deleted_at' => null]);
        $builder->groupby('a.id')->orderby('a.kode');
        return $builder->get()->getResult();
    }
    public function get1User($data, $deklar = false)
    {
        $builder = $this->db->table('m_user a');
        $builder->select('a.*, b.nama as role, c.nama as namapegawai');
        $builder->where('a.id', $data)->where('substring(a.kondisi, 2, 1)', '1')->where('substring(a.kondisi, 3, 1)', '1');
        if ($deklar == false) $builder->where('substring(c.kondisi, 2, 1)', '1')->where('substring(c.kondisi, 3, 1)', '1');
        $builder->join('m_role b', 'a.role_id=b.id', 'left');
        $builder->join('m_penerima c', 'a.id=c.user_id', 'left');
        $builder->where(['a.deleted_at' => null]);
        return $builder->get()->getResult();
    }
    public function loadUser($isi, $pegawai = false)
    {
        $builder = $this->db->table('m_user a');
        $builder->select('a.*, b.nama as role, c.id as idpegawai, c.nama as namapegawai');
        $builder->where("(a.kode like \"%$isi%\" or c.nama like \"%$isi%\")");
        $builder->where('substring(a.kondisi, 2, 1)', '1')->where('substring(a.kondisi, 3, 1)', '1');
        $kondisi = ($pegawai != '' ? 'inner' : 'left');
        $builder->where(['a.deleted_at' => null]);
        $builder->join('m_role b', 'a.role_id=b.id', 'left');
        $builder->join('m_penerima c', 'a.id=c.user_id', $kondisi);
        $builder->orderby('a.kode');
        $builder->limit(jllimit);
        return $builder->get()->getResult();
    }

    public function getToken($menu, $id = false)
    {
        $builder = $this->db->table('user_token a');
        $builder->select('a.*, b.kode as user');
        if ($id == true) $builder->where('a.id', $id);
        $builder->join('m_user b', 'a.save_by = b.id', 'left');
        $builder->groupby('a.id')->orderby('a.created_at desc');
        return $builder->get()->getResult();
    }
    public function cekToken($token)
    {
        $builder = $this->db->table('user_token');
        $builder->where('token', $token)->where('is_use', '0');
        return $builder->get()->getResult();
    }


    // public function getLog($usernama, $isi, $detil)
    // {
    //     $builder = $this->db->table('log_data');
    //     $builder->where("(menu like \"%$isi%\" or data like \"%$isi%\")");
    //     if ($usernama != '') $builder->where('created_by', $usernama);
    //     if ($detil == '') $builder->where('is_show', '1');
    //     $builder->orderby('id desc');
    //     $builder->limit(10 * jllimit);
    //     return $builder->get()->getResult();
    // }
    // public function getSandiuser()
    // {
    //     $builder = $this->db->table('m_user a');
    //     $builder->select('a.kode, a.id as iduser, b.kode as kodepeg, b.nip, b.nama, c.kode as perusahaan, d.nama as wilayah, e.nama as divisi');
    //     $builder->join('m_penerima b', 'b.user_id = a.id', 'left');
    //     $builder->join('m_perusahaan c', 'b.perusahaan_id = c.id', 'left');
    //     $builder->join('m_divisi d', 'b.wilayah_id = d.id', 'left');
    //     $builder->join('m_divisi e', 'b.divisi_id = e.id', 'left');
    //     $builder->where('iz_pass',  '1');
    //     $builder->orderby('a.kode');
    //     return $builder->get()->getResult();
    // }

    // ____________________________________________________________________________________________________________________________
    public function getPerusahaan($menu, $aktif = false)
    {
        $builder = $this->db->table('m_perusahaan a');
        $builder->select('a.*, b.kode as kodepenerima, b.nama as namapenerima, x.id as xlog');
        if ($aktif == true) $builder->where('substring(a.kondisi, 2, 1)', '1')->where('substring(a.kondisi, 3, 1)', '1');
        $strx = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.usernama = "' . session()->usernama . '"' : '');
        $builder->join('m_penerima b', 'b.id = a.penerima_id', 'left');
        $builder->join('user_log x', 'x.idunik = a.idunik' . $strx, 'left');
        $builder->where(['a.deleted_at' => null]);
        $builder->groupBy('a.id')->orderby('a.kode');
        return $builder->get()->getResult();
    }

    public function getBerkas($menu, $param, $aktif = false, $sdef = false)
    {
        $builder = $this->db->table('m_berkas a');
        $builder->select('a.*, b.kode as perusahaan, c.nama as wilayah, d.nama as divisi, p.kode as saveby, x.id as xlog');
        if ($aktif == true) $builder->where('substring(a.kondisi, 2, 1)', '1')->where('substring(a.kondisi, 3, 1)', '1');
        if ($sdef == true) $builder->where('a.def_proyek', '1');
        $strx = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.usernama = "' . session()->usernama . '"' : '');
        $builder->join('m_perusahaan b', 'b.id = a.perusahaan_id', 'left');
        $builder->join('m_berkas c', 'c.id = a.wilayah_id', 'left');
        $builder->join('m_berkas d', 'd.id = a.divisi_id', 'left');
        $builder->join('m_user p', 'p.id = a.save_by', 'left');
        $builder->join('user_log x', 'x.idunik = a.idunik' . $strx, 'left');
        $builder->where('a.param',  $param)->where(['a.deleted_at' => null]);
        $builder->groupBy('a.id')->orderby('a.nama');
        return $builder->get()->getResult();
    }
    public function cekBerkas($param, $field, $nama, $idunik)
    {
        $builder = $this->db->table('m_berkas');
        $builder->where('param', $param)->where($field, $nama);
        $builder->where('idunik !=', $idunik)->where(['deleted_at' => null]);
        return $builder->get()->getResult();
    }
    public function getForm($menu, $param, $form, $perusahaan = '')
    {
        $builder = $this->db->table('m_berkas a');
        $builder->select('a.*, b.kelompok as kelompok, c.nama as perusahaan, x.id as xlog');
        $builder->where('a.param', $param);
        if ($perusahaan != '') $builder->where('a.perusahaan_id', $perusahaan);
        $builder->where(['a.deleted_at' => null]);
        $strx = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.usernama = "' . session()->usernama . '"' : '');
        $builder->join('m_select b', 'a.sub_param=b.nama', 'left');
        $builder->join('m_perusahaan c', 'a.perusahaan_id=c.id', 'left');
        $builder->join('user_log x', 'x.idunik = a.idunik' . $strx, 'left');
        $builder->groupBy('a.id')->orderby('b.nomor');
        return $builder->get()->getResult();
    }
    public function cekForm($param, $form, $idunik = '', $aktif = false, $perusahaan = false)
    {
        $builder = $this->db->table('m_berkas');
        $builder->where('param', $param)->where('sub_param', $form);
        $builder->where(['deleted_at' => null]);
        if ($idunik != '') $builder->where('idunik !=', $idunik);
        if ($aktif == true) $builder->where('substring(kondisi, 2, 1)', '1')->where('substring(kondisi, 3, 1)', '1');
        if ($perusahaan == true) $builder->where('perusahaan_id', $perusahaan);
        return $builder->get()->getResult();
    }



    // public function getGudang($menu, $pilihan, $aktif = false, $perusahaan = false, $wilayah = false, $divisi = false)
    // {
    //     // $query = $this->db->query("SELECT a.*,b.kode as perusahaan,c.nama as wilayah,d.nama as divisi 
    //     // FROM m_divisi a,m_perusahaan b,m_divisi c,m_divisi d where a.pilihan='gudang' and a.perusahaan_id=b.id
    //     // and a.wilayah_id=c.id and a.divisi_id=d.id and a.deleted_at is NULL order by a.nama");
    //     // return $query->getResult();
    //     $builder = $this->db->table('m_divisi a');
    //     $builder->select('a.*, b.kode as perusahaan, c.nama as wilayah, d.nama as divisi, x.id as xlog');
    //     $builder->where('a.pilihan',  $pilihan)->where(['a.deleted_at' => null]);
    //     if ($aktif == true) $builder->where('a.is_confirm', '1')->where('a.is_aktif', '1');
    //     if ($perusahaan == true) $builder->where('a.perusahaan_id', $perusahaan);
    //     if ($divisi == true) $builder->where('a.divisi_id', $divisi);
    //     if ($wilayah == true) $builder->where('a.wilayah_id', $wilayah);
    //     $strx = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.created_by = "' . session()->usernama . '"' : '');
    //     $builder->join('m_perusahaan b', 'b.id = a.perusahaan_id');
    //     $builder->join('m_divisi c', 'c.id = a.wilayah_id');
    //     $builder->join('m_divisi d', 'd.id = a.divisi_id');
    //     $builder->join('log_data x', 'x.idunik = a.idunik' . $strx, 'left');
    //     $builder->groupBy('a.id')->orderby('a.nama');
    //     return $builder->get()->getResult();
    // }


    // public function getPropinsi($menu, $aktif = false)
    // {
    //     $builder = $this->db->table('m_propinsi a');
    //     $builder->select('a.*, x.id as xlog');
    //     if ($aktif == true) $builder->where('a.is_confirm', '1')->where('a.is_aktif', '1');
    //     $strx = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.created_by = "' . session()->usernama . '"' : '');
    //     $builder->where(['a.deleted_at' => null]);
    //     $builder->join('log_data x', 'x.idunik = a.idunik' . $strx, 'left');
    //     $builder->groupBy('a.id')->orderBy('a.propinsi,a.kabupaten');
    //     return $builder->get()->getResult();
    // }
    // public function cekPropinsi($propinsi, $kabupaten, $idunik)
    // {
    //     $builder = $this->db->table('m_propinsi');
    //     $builder->where('propinsi', $propinsi)->where('kabupaten', $kabupaten);
    //     $builder->where('idunik !=', $idunik);
    //     return $builder->get()->getResult();
    // }
    // public function getKabupaten($propinsi)
    // {
    //     $builder = $this->db->table('m_propinsi');
    //     $builder->where('propinsi', $propinsi);
    //     $builder->where('is_confirm', '1')->where('is_aktif', '1')->where(['deleted_at' => null]);
    //     $builder->orderby('kabupaten');
    //     return $builder->get()->getResult();
    // }
    public function getBiaya($menu, $param, $kategori)
    {
        $builder = $this->db->table('m_biaya a');
        $builder->select('a.*, x.id as xlog');
        ($param == 'biaya langsung') ? $builder->where('a.kate_id', $kategori) : $builder->like('a.kode', $kategori, 'after');
        $builder->where('a.param', $param)->where(['a.deleted_at' => null]);
        $strx = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.usernama = "' . session()->usernama . '"' : '');
        $builder->join('user_log x', 'x.idunik = a.idunik' . $strx, 'left');
        $builder->groupBy('a.id')->orderby('a.kode');
        return $builder->get()->getResult();
    }
    public function distinctBiaya($param)
    {
        $builder = $this->db->table('m_biaya');
        $builder->select('kode, nama')->distinct();
        $builder->where('param',  $param)->where('level', '1')->where(['deleted_at' => null]);
        $builder->orderBy('kode');
        return $builder->get()->getResult();
    }
    public function loadBiaya($param, $level, $kategori, $isi, $awal = false)
    {
        $builder = $this->db->table('m_biaya');
        $builder->where('param', $param);
        if ($kategori != '') $builder->where('kate_id', $kategori);
        if ($awal == true) $builder->like('kode', $awal, 'after');
        $builder->where("(kode like \"%$isi%\" or nama like \"%$isi%\")");
        $builder->where('substring(kondisi, 2, 1)', '1')->where('substring(kondisi, 3, 1)', '1');
        $builder->where('level', $level)->where(['deleted_at' => null]);
        $builder->orderby('kode');
        $builder->limit(jllimit);
        return $builder->get()->getResult();
    }
    public function cekBiaya($kode, $kategori, $idunik)
    {
        $builder = $this->db->table('m_biaya');
        $builder->where('kode', $kode)->where('kate_id', $kategori);
        $builder->where('idunik !=', $idunik)->where(['deleted_at' => null]);
        return $builder->get()->getResult();
    }
    public function cekIndukbiaya($param, $induk, $level, $kategori)
    {
        $builder = $this->db->table('m_biaya');
        $builder->where('param', $param)->where('kode', $induk)->where('level', $level)->where('kate_id', $kategori);
        $builder->where('substring(kondisi, 2, 1)', '1')->where('substring(kondisi, 3, 1)', '1');
        $builder->where(['deleted_at' => null]);
        return $builder->get()->getResult();
    }
    // public function getIndukbiaya($pilihan, $biaya)
    // {
    //     if ($pilihan == 'akun') {
    //         $builder = $this->db->table('m_akun a');
    //         $builder->select('a.*, b.id as idlev3, c.id as idlev2, d.id as idlev1');
    //         $builder->join('m_akun b', 'a.induk_id=b.id', 'left');
    //         $builder->join('m_akun c', 'b.induk_id=c.id', 'left');
    //         $builder->join('m_akun d', 'c.induk_id=d.id', 'left');
    //     } else {
    //         $builder = $this->db->table('m_biaya a');
    //         if ($pilihan == 'bl') {
    //             $builder->select('a.*, c.id as idlev2, d.id as idlev1');
    //             $builder->join('m_biaya c', 'a.induk_id=c.id', 'left');
    //             $builder->join('m_biaya d', 'c.induk_id=d.id', 'left');
    //         } else { // biaya
    //             $builder->select('a.*, b.id as idlev3, c.id as idlev2, d.id as idlev1');
    //             $builder->join('m_biaya b', 'a.induk_id=b.id', 'left');
    //             $builder->join('m_biaya c', 'b.induk_id=c.id', 'left');
    //             $builder->join('m_biaya d', 'c.induk_id=d.id', 'left');
    //         }
    //     }
    //     $builder->where('a.id', $biaya);
    //     return $builder->get()->getResult();
    // }


    public function getAnggaran($menu, $level = '1', $idunik = false, $judul = false, $beban = false)
    {
        $builder = $this->db->table('m_anggaran a');
        $ordby = '';
        if ($level == '1') {
            $builder->select('a.*, b.nama as jenisbiaya, x.id as xlog')->where('a.levsatu', '1');
            $strx = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.usernama = "' . session()->usernama . '"' : '');
            $builder->join('m_biaya b', 'a.jenis = b.kode',  'left');
            $builder->join('user_log x', 'x.idunik = a.idunik' . $strx, 'left');
        } else {
            // if (strlen($idunik) == 32) {
            //     if ($tujuan == 'proyek')
            //         $builder->select('a.*, b.kode as kode, b.nama as deskripsi, b.level as level');
            //     else
            //         $builder->select('a.*, c.noakun as kode, c.nama as deskripsi, c.level as level');
            //     $builder->where('a.idunik', $idunik);
            //     $builder->join('m_biaya b', 'a.biaya_id=b.id', 'left');
            //     $builder->join('m_akun c', 'a.akun_id=c.id', 'left');
            //     $ordby = ',b.kode, c.noakun, a.id';
            // } else {
            //     $builder->where('a.pilihan', $pilihan)->where('a.tujuan', $tujuan);
            // }
        }
        $builder->where(['a.deleted_at' => null]);
        $builder->groupBy('a.id')->orderby("a.beban, a.judul $ordby");
        return $builder->get()->getResult();
    }
    public function cekAnggaran($judul, $idunik = false)
    {
        $builder = $this->db->table('m_anggaran');
        $builder->where('judul', $judul);
        if ($idunik == true) $builder->where('idunik', $idunik);
        $builder->where(['deleted_at' => null]);
        return $builder->get()->getResult();
    }

    // public function anggaranTotal($idunik, $induk, $tabel)
    // {
    //     $builder = $this->db->table('m_anggaran a');
    //     $builder->where('a.idunik', $idunik)->where(['a.deleted_at' => null]);
    //     $builder->select('sum(a.total) as subtotal');
    //     $builder->where('b.induk_id', $induk);
    //     $builder->groupBy('b.induk_id');
    //     ($tabel == 'akun') ? $builder->join('m_akun b', 'a.akun_id = b.id', 'left') : $builder->join('m_biaya b', 'a.biaya_id = b.id', 'left');
    //     return $builder->get()->getResult();
    // }

    // ____________________________________________________________________________________________________________________________

    // ____________________________________________________________________________________________________________________________    
    public function getCabang($menu, $aktif = false)
    {
        $builder = $this->db->table('m_cabang a');
        $builder->select('a.*, b.kode as perusahaan, c.nama as wilayah, d.nama as divisi, x.id as xlog');
        if ($aktif == true) $builder->where('substring(a.kondisi, 2, 1)', '1')->where('substring(a.kondisi, 3, 1)', '1');
        $strx = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.usernama = "' . session()->usernama . '"' : '');
        $builder->where(['a.deleted_at' => null]);
        $builder->join('m_perusahaan b', 'a.perusahaan_id=b.id', 'left');
        $builder->join('m_berkas c', 'a.wilayah_id=c.id', 'left');
        $builder->join('m_berkas d', 'a.divisi_id=d.id', 'left');
        $builder->join('user_log x', 'x.idunik = a.idunik' . $strx, 'left');
        $builder->groupBy('a.id')->orderby('kode');
        return $builder->get()->getResult();
    }
    public function loadCabang($isi, $perusahaan = false, $wilayah = false, $divisi = false)
    {
        $builder = $this->db->table('m_cabang a');
        $builder->select('a.*, b.kode as perusahaan, c.nama as wilayah, d.nama as divisi');
        $builder->where("(a.kode like \"%$isi%\" or a.nama like \"%$isi%\")");
        $builder->where('substring(a.kondisi, 2, 1)', '1')->where('substring(a.kondisi, 3, 1)', '1');
        $builder->where(['a.deleted_at' => null]);
        if ($perusahaan == true) $builder->where('a.perusahaan_id', $perusahaan);
        if ($wilayah == true) $builder->where('a.wilayah_id', $wilayah);
        if ($divisi == true) $builder->where('a.divisi_id', $divisi);
        $builder->join('m_perusahaan b', 'a.perusahaan_id=b.id', 'left');
        $builder->join('m_berkas c', 'a.wilayah_id=c.id', 'left');
        $builder->join('m_berkas d', 'a.divisi_id=d.id', 'left');
        $builder->orderby('a.kode');
        $builder->limit(jllimit);
        return $builder->get()->getResult();
    }
    public function getProyek($menu, $aktif = false, $perusahaan = false)
    {
        $builder = $this->db->table('m_proyek a');
        $builder->select('a.*, b.kode as perusahaan, c.nama as wilayah, x.id as xlog');
        if ($aktif == true) $builder->where('substring(a.kondisi, 2, 1)', '1')->where('substring(a.kondisi, 3, 1)', '1');
        if ($perusahaan == true) $builder->where('a.perusahaan_id', $perusahaan);
        $strx = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.usernama = "' . session()->usernama . '"' : '');
        $builder->where(['a.deleted_at' => null]);
        $builder->join('m_perusahaan b', 'a.perusahaan_id=b.id', 'left');
        $builder->join('m_berkas c', 'a.wilayah_id=c.id', 'left');
        $builder->join('user_log x', 'x.idunik = a.idunik' . $strx, 'left');
        $builder->groupBy('a.id')->orderby('a.kode');
        return $builder->get()->getResult();
    }
    public function loadProyek($isi, $perusahaan = false, $wilayah = false, $divisi = false)
    {
        $builder = $this->db->table('m_proyek');
        $builder->where("(kode like \"%$isi%\" or paket like \"%$isi%\")");
        $builder->where('substring(kondisi, 2, 1)', '1')->where('substring(kondisi, 3, 1)', '1');
        if ($perusahaan == true) $builder->where('perusahaan_id', $perusahaan);
        if ($wilayah == true) $builder->where('wilayah_id', $wilayah);
        if ($divisi == true) $builder->where('divisi_id', $divisi);
        $builder->orderby('kode');
        $builder->limit(jllimit);
        return $builder->get()->getResult();
    }
    public function getRuas($menu, $param, $aktif = false, $proyek = false, $cabang = false)
    {
        $builder = $this->db->table('m_ruas a');
        $builder->select('a.*, b.kode as kodeproyek, c.kode as kodecabang, d.kode as perusahaan, e.nama as wilayah, f.nama as divisi, x.id as xlog');
        $builder->where('a.param', $param)->where(['a.deleted_at' => null]);
        if ($aktif == true) $builder->where('substring(a.kondisi, 2, 1)', '1')->where('substring(a.kondisi, 3, 1)', '1');
        if ($proyek == true) $builder->where('a.proyek_id', $proyek);
        if ($cabang == true) $builder->where('a.cabang_id', $cabang);
        $strx = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.usernama = "' . session()->usernama . '"' : '');
        $builder->join('m_proyek b', 'a.proyek_id=b.id', 'left');
        $builder->join('m_cabang c', 'a.cabang_id=c.id', 'left');
        $builder->join('m_perusahaan d', 'b.perusahaan_id=d.id', 'left');
        $builder->join('m_berkas e', 'b.wilayah_id=e.id', 'left');
        $builder->join('m_berkas f', 'b.divisi_id=f.id', 'left');
        // $builder->join('m_ruas f', 'a.ruas_id=f.id', 'left');
        $builder->join('user_log x', 'x.idunik = a.idunik' . $strx, 'left');
        $builder->groupBy('a.id')->orderby('b.kode, a.kode');
        return $builder->get()->getResult();
    }
    public function cekRuas($param, $kode, $idunik, $proyek = false, $cabang = false, $ruas = false)
    {
        $builder = $this->db->table('m_ruas');
        $builder->where('param', $param);
        $builder->where('kode', $kode)->where('idunik !=', $idunik);
        if ($proyek == true) $builder->where('proyek_id', $proyek);
        if ($cabang == true) $builder->where('cabang_id', $cabang);
        if ($ruas == true) $builder->where('ruas_id', $ruas);
        return $builder->get()->getResult();
    }

    public function getAlat($menu, $aktif = false, $param = false, $perusahaan = false, $penerima = false)
    {
        $builder = $this->db->table('m_alat a');
        $builder->select('a.*, b.kode as perusahaan, c.nama as wilayah, d.nama as divisi, e.nama as namarekan, x.id as xlog');
        if ($param == true) ($param == 'multi') ? $builder->whereIn('a.param', ['alat', 'tool']) : $builder->where('a.param', $param);
        if ($aktif == true) $builder->where('substring(a.kondisi, 2, 1)', '1')->where('substring(a.kondisi, 3, 1)', '1');
        if ($perusahaan == true) $builder->where('a.perusahaan_id', $perusahaan);
        if ($param == 'rekan') $builder->where('a.rekan_id', $penerima);
        $strx = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.usernama = "' . session()->usernama . '"' : '');
        $builder->where(['a.deleted_at' => null]);
        $builder->join('m_perusahaan b', 'a.perusahaan_id=b.id', 'left');
        $builder->join('m_berkas c', 'a.wilayah_id=c.id', 'left');
        $builder->join('m_berkas d', 'a.divisi_id=d.id', 'left');
        $builder->join('m_penerima e', 'a.rekan_id=e.id', 'left');
        $builder->join('user_log x', 'x.idunik = a.idunik' . $strx, 'left');
        $builder->groupBy('a.id')->orderby('a.kode');
        return $builder->get()->getResult();
    }

    // public function loadAlat($isi, $pilih = false, $perusahaan, $wilayah, $divisi)
    // {
    //     $builder = $this->db->table('m_alat a');
    //     $builder->select('a.*, b.kode as kodekbli, b.nama as namakbli, c.kode as perusahaan, d.nama as wilayah, e.nama as divisi, f.nama as kategori');
    //     $builder->where("(a.kode like \"%$isi%\" or a.nama like \"%$isi%\" or a.nomor like \"%$isi%\")");
    //     if ($pilih == true) ($pilih == 'multi') ? $builder->whereIn('a.pilihan', ['pribadi', 'tool']) : $builder->where('a.pilihan', $pilih);
    //     $builder->where('a.is_confirm', '1')->where('a.is_aktif', '1')->where(['a.deleted_at' => null]);
    //     $builder->where('b.is_confirm', '1')->where('b.is_aktif', '1')->where('b.deleted_at', null);
    //     $builder->where('c.is_confirm', '1')->where('c.is_aktif', '1')->where('c.deleted_at', null);
    //     $builder->where('d.is_confirm', '1')->where('d.is_aktif', '1')->where('d.deleted_at', null);
    //     $builder->where('e.is_confirm', '1')->where('e.is_aktif', '1')->where('e.deleted_at', null);
    //     $builder->where('f.is_confirm', '1')->where('f.is_aktif', '1')->where('f.deleted_at', null);
    //     if ($perusahaan != '') $builder->where('a.perusahaan_id', $perusahaan);
    //     if ($wilayah != '') $builder->where('a.wilayah_id', $wilayah);
    //     if ($divisi != '') $builder->where('a.divisi_id', $divisi);
    //     $builder->join('m_kbli b', 'a.kbli_id=b.id', 'left');
    //     $builder->join('m_perusahaan c', 'a.perusahaan_id=c.id', 'left');
    //     $builder->join('m_divisi d', 'a.wilayah_id=d.id', 'left');
    //     $builder->join('m_divisi e', 'a.divisi_id=e.id', 'left');
    //     $builder->join('m_divisi f', 'a.kategori_id=f.id', 'left');
    //     $builder->orderby('a.kode');
    //     $builder->limit(jllimit);
    //     return $builder->get()->getResult();
    // }
    // // public function loadAlatincRekanan($isi, $bentuk, $kategori, $pilih = false)
    // // {
    // //     $builder = $this->db->table('m_alat a');
    // //     $builder->select('a.*,b.kode as perusahaan,c.nama as penerima');
    // //     $builder->where("(a.kode like \"%$isi%\" or a.nama like \"%$isi%\" or a.nomor like \"%$isi%\")");
    // //     $builder->where('a.bentuk', $bentuk)->where('a.kategori_id', $kategori);
    // //     $builder->where('a.is_confirm', '1')->where('a.is_aktif', '1')->where(['a.deleted_at' => null]);
    // //     $builder->join('m_perusahaan b', 'a.perusahaan_id=b.id', 'left');
    // //     $builder->join('m_penerima c', 'a.penerima_id=c.id', 'left');
    // //     $builder->orderby('a.kode');
    // //     $builder->limit(jllimit);
    // //     return $builder->get()->getResult();
    // // }
    public function getTanah($menu, $aktif = false, $perusahaan = false)
    {
        $builder = $this->db->table('m_tanah a');
        $builder->select('a.*, b.kode as perusahaan, c.nama as wilayah, d.nama as divisi, x.id as xlog');
        if ($aktif == true) $builder->where('substring(a.kondisi, 2, 1)', '1')->where('substring(a.kondisi, 3, 1)', '1');
        if ($perusahaan == true) $builder->where('a.perusahaan_id', $perusahaan);
        $strx = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.usernama = "' . session()->usernama . '"' : '');
        $builder->where(['a.deleted_at' => null]);
        $builder->join('m_perusahaan b', 'a.perusahaan_id=b.id', 'left');
        $builder->join('m_berkas c', 'a.wilayah_id=c.id', 'left');
        $builder->join('m_berkas d', 'a.divisi_id=d.id', 'left');
        $builder->join('user_log x', 'x.idunik = a.idunik' . $strx, 'left');
        $builder->groupBy('a.id')->orderby('a.kode');
        return $builder->get()->getResult();
    }
    // public function loadTanah($isi, $perusahaan, $wilayah, $divisi)
    // {
    //     $builder = $this->db->table('m_tanah a');
    //     $builder->select('a.*, b.kode as kodekbli, b.nama as namakbli, c.kode as perusahaan, d.nama as wilayah, e.nama as divisi');
    //     $builder->where("(a.kode like \"%$isi%\" or a.nama like \"%$isi%\")");
    //     $builder->where('a.is_confirm', '1')->where('a.is_aktif', '1')->where(['a.deleted_at' => null]);
    //     $builder->where('b.is_confirm', '1')->where('b.is_aktif', '1')->where('b.deleted_at', null);
    //     $builder->where('c.is_confirm', '1')->where('c.is_aktif', '1')->where('c.deleted_at', null);
    //     $builder->where('d.is_confirm', '1')->where('d.is_aktif', '1')->where('d.deleted_at', null);
    //     if ($perusahaan != '') $builder->where('a.perusahaan_id', $perusahaan);
    //     if ($wilayah != '') $builder->where('a.wilayah_id', $wilayah);
    //     if ($divisi != '') $builder->where('a.divisi_id', $divisi);
    //     $builder->join('m_kbli b', 'a.kbli_id=b.id', 'left');
    //     $builder->join('m_perusahaan c', 'a.perusahaan_id=c.id', 'left');
    //     $builder->join('m_divisi d', 'a.wilayah_id=d.id', 'left');
    //     $builder->join('m_divisi e', 'a.divisi_id=e.id', 'left');
    //     $builder->orderby('a.kode');
    //     $builder->limit(jllimit);
    //     return $builder->get()->getResult();
    // }
    // public function getInventaris($menu, $aktif, $perusahaan = false, $divisi = false)
    // {
    //     $builder = $this->db->table('m_inventaris a');
    //     $builder->select('a.*, b.kode as perusahaan, c.nama as wilayah, d.nama as divisi, e.nama as pegawai, x.id as xlog');
    //     if ($aktif != '') $builder->where('a.is_confirm', '1')->where('a.is_aktif', '1');
    //     if ($perusahaan == true) $builder->where('a.perusahaan_id', $perusahaan);
    //     if ($divisi == true) $builder->where('a.divisi_id', $divisi);
    //     $strx = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.created_by = "' . session()->usernama . '"' : '');
    //     $builder->where(['a.deleted_at' => null]);
    //     $builder->join('m_perusahaan b', 'b.id = a.perusahaan_id', 'left');
    //     $builder->join('m_divisi c', 'c.id = a.wilayah_id', 'left');
    //     $builder->join('m_divisi d', 'd.id = a.divisi_id', 'left');
    //     $builder->join('m_penerima e', 'e.id = a.pegawai_id', 'left');
    //     $builder->join('log_data x', 'x.idunik = a.idunik' . $strx, 'left');
    //     $builder->groupBy('a.id')->orderby('a.kode');
    //     return $builder->get()->getResult();
    // }

    // ____________________________________________________________________________________________________________________________
    public function getAkun($menu, $kategori)
    {
        $builder = $this->db->table('m_akun a');
        $builder->select('a.*, x.id as xlog');
        if ($kategori != '') $builder->where('a.kategori', $kategori);
        $strx = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.usernama = "' . session()->usernama . '"' : '');
        $builder->where(['a.deleted_at' => null]);
        // $builder->join('m_akun b', 'a.induk_id = b.id', 'left');
        $builder->join('user_log x', 'x.idunik = a.idunik' . $strx, 'left');
        $builder->groupBy('a.id')->orderby('a.kode');
        return $builder->get()->getResult();
    }

    public function loadAkun($isi, $awal)
    {
        $builder = $this->db->table('m_akun');
        $builder->like('kode', $awal, 'after');
        $builder->where("(kode like \"%$isi%\" or nama like \"%$isi%\")");
        $builder->where('level', '4')->where(['deleted_at' => null]);
        $builder->where('substring(kondisi, 2, 1)', '1')->where('substring(kondisi, 3, 1)', '1');
        $builder->orderby('kode');
        $builder->limit(jllimit);
        return $builder->get()->getResult();
    }
    public function cekAkun($noakun, $idunik, $level = false)
    {
        $builder = $this->db->table('m_akun');
        $builder->where('kode', $noakun);
        if ($level == true) {
            $builder->where('level', $level);
            $builder->where('substring(kondisi, 2, 1)', '1')->where('substring(kondisi, 3, 1)', '1');
        } else {
            $builder->where('idunik !=', $idunik);
        }
        $builder->where(['deleted_at' => null]);
        return $builder->get()->getResult();
    }
    public function getKelakun($menu, $asal, $aktif = false)
    {
        $builder = $this->db->table('m_kelakun a');
        $builder->select('a.*, b.kode as perusahaan, c.nama as divisi, x.id as xlog');
        $builder->where('a.asal', $asal)->where(['a.deleted_at' => null]);
        if ($aktif == true) $builder->where('substring(a.kondisi, 2, 1)', '1')->where('substring(a.kondisi, 3, 1)', '1');
        $strx = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.usernama = "' . session()->usernama . '"' : '');
        $builder->join('m_perusahaan b', 'a.perusahaan_id = b.id', 'left');
        $builder->join('m_berkas c', 'a.divisi_id = c.id', 'left');
        $builder->join('user_log x', 'x.idunik = a.idunik' . $strx, 'left');
        $builder->groupBy('a.id')->orderby('a.param, a.sub_param, a.nama');
        return $builder->get()->getResult();
    }
    public function cekKelakun($subparam, $nama, $idunik)
    {
        $builder = $this->db->table('m_kelakun');
        $builder->where('sub_param', $subparam)->where('nama', $nama);
        $builder->where('idunik !=', $idunik)->where(['deleted_at' => null]);
        return $builder->get()->getResult();
    }
    public function loadKelakun($param, $subparam, $asal = false)
    {
        $builder = $this->db->table('m_kelakun');
        $builder->where('param', $param);
        if ($subparam != '') $builder->where('sub_param', $subparam);
        if ($asal == true) $builder->where('asal', $asal);
        $builder->where('substring(kondisi, 2, 1)', '1')->where('substring(kondisi, 3, 1)', '1');
        $builder->where(['deleted_at' => null]);
        $builder->orderby('nama');
        return $builder->get()->getResult();
    }
    public function getKBLI($menu, $param, $aktif = false)
    {
        $builder = $this->db->table('m_kbli a');
        $builder->select('a.*, x.id as xlog');
        if ($aktif == true) $builder->where('substring(a.kondisi, 2, 1)', '1')->where('substring(a.kondisi, 3, 1)', '1');
        if ($param != '') $builder->where('a.param', $param);
        $strx = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.usernama = "' . session()->usernama . '"' : '');
        $builder->where(['a.deleted_at' => null]);
        $builder->join('user_log x', 'x.idunik = a.idunik' . $strx, 'left');
        $builder->groupBy('a.id')->orderby('a.nama');
        return $builder->get()->getResult();
    }
    public function cekKBLI($param, $kode, $idunik)
    {
        $builder = $this->db->table('m_kbli');
        $builder->where('param', $param)->where('kode', $kode);
        $builder->where('idunik !=', $idunik)->where(['deleted_at' => null]);
        return $builder->get()->getResult();
    }
    // public function loadKBLI($isi, $pilihan)
    // {
    //     $builder = $this->db->table('m_kbli');
    //     $builder->where("(kode like \"%$isi%\" or nama like \"%$isi%\")");
    //     $builder->where('pilihan', $pilihan);
    //     $builder->where('is_confirm', '1')->where('is_aktif', '1')->where(['deleted_at' => null]);
    //     $builder->orderby('kode');
    //     $builder->limit(jllimit);
    //     return $builder->get()->getResult();
    // }
    // public function distKBLI($pilihan)
    // {
    //     $builder = $this->db->table('m_kbli a');
    //     $builder->select('a.*, b.nilai as nilaipajak');
    //     $builder->where('a.pilihan', $pilihan);
    //     $builder->where(['a.deleted_at' => null]);
    //     $builder->join('def_akun b', 'a.pajak_id = b.id');
    //     $builder->orderBy('a.kode');
    //     return $builder->get()->getResult();
    // }

    // ____________________________________________________________________________________________________________________________
    public function getBarang($menu, $param = false, $kategori = false, $aktif = false, $serial = false)
    {
        $builder = $this->db->table('m_barang a');
        $builder->select('a.*, x.id as xlog');
        if ($param == true) $builder->where('a.param', $param);
        if ($kategori == true) $builder->where('a.kategori', $kategori);
        if ($aktif == true) $builder->where('substring(a.kondisi, 2, 1)', '1')->where('substring(a.kondisi, 3, 1)', '1');
        $strx = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.usernama = "' . session()->usernama . '"' : '');
        $builder->where(['a.deleted_at' => null]);
        $builder->join('user_log x', 'x.idunik = a.idunik' . $strx, 'left');
        $builder->groupBy('a.id')->orderby('a.param, a.kategori, a.kode');
        return $builder->get()->getResult();
    }
    // public function getSatuan($barang)
    // {
    //     $builder = $this->db->table('m_barang');
    //     return $builder->where('id', $barang)->get()->getResult();
    // }
    // public function getSerial($menu, $barang)
    // {
    //     $builder = $this->db->table('m_serial a');
    //     $builder->select('a.*, b.kode as kodebrg, b.nama as barang, c.kode as kodealat, c.nomor as nomoralat, c.nama as namaalat, x.id as xlog');
    //     if ($barang != '') $builder->where('a.barang_id', $barang);
    //     $strx = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.created_by = "' . session()->usernama . '"' : '');
    //     $builder->where(['a.deleted_at' => null]);
    //     $builder->join('m_barang b', 'a.barang_id=b.id', 'left');
    //     $builder->join('m_alat c', 'a.alat_id=c.id', 'left');
    //     $builder->join('log_data x', 'x.idunik = a.idunik' . $strx, 'left');
    //     $builder->groupBy('a.id')->orderby('b.kode,a.noseri');
    //     return $builder->get()->getResult();
    // }
    // public function loadBarang($isi, $pilihan, $sn)
    // {
    //     $builder = $this->db->table('m_barang');
    //     $builder->where("(kode like \"%$isi%\" or nama like \"%$isi%\")");
    //     if ($pilihan != '') $builder->like('pilihan', $pilihan);
    //     if ($sn == '1') $builder->where('use_serial', '1');
    //     $builder->where('is_confirm', '1')->where('is_aktif', '1')->where(['deleted_at' => null]);
    //     $builder->orderby('kode');
    //     $builder->limit(jllimit);
    //     return $builder->get()->getResult();
    // }
    // public function loadAtk($isi)
    // {
    //     $builder = $this->db->table('m_atk');
    //     $builder->where("(nama like \"%$isi%\")");
    //     $builder->where(['deleted_at' => null]);
    //     $builder->orderby('nama');
    //     $builder->limit(jllimit);
    //     return $builder->get()->getResult();
    // }
    // ____________________________________________________________________________________________________________________________
    public function getPenerima($menu, $pegawai, $aktif = false, $osm = false, $perusahaan = false, $kategori = false)
    {
        $builder = $this->db->table('m_penerima a');
        $builder->select('a.*, b.kode as perusahaan, c.nama as wilayah, d.nama as divisi, x.id as xlog');
        if ($aktif == true) $builder->where('substring(a.kondisi, 2, 1)', '1')->where('substring(a.kondisi, 3, 1)', '1');
        if ($perusahaan == true) $builder->where('a.perusahaan_id', $perusahaan);
        if ($kategori == true) $builder->where('a.kategori', $kategori);
        if ($pegawai == '1') $builder->where('substring(a.is_alias, 4, 1)', '1');
        if ($osm == '1') $builder->where('substring(a.is_alias, 5, 1)', '1');
        $strx = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.usernama = "' . session()->usernama . '"' : '');
        $builder->where(['a.deleted_at' => null]);
        $builder->join('m_perusahaan b', 'a.perusahaan_id=b.id', 'left');
        $builder->join('m_berkas c', 'a.wilayah_id=c.id', 'left');
        $builder->join('m_berkas d', 'a.divisi_id=d.id', 'left');
        $builder->join('user_log x', 'x.idunik = a.idunik' . $strx, 'left');
        $builder->groupBy('a.id')->orderby('a.kategori, a.kode');
        return $builder->get()->getResult();
    }
    public function loadPenerima($isi, $pelanggan, $suplier, $lain, $pegawai, $osm)
    {
        $builder = $this->db->table('m_penerima');
        $builder->where("(kode like \"%$isi%\" or nip like \"%$isi%\" or nama like \"%$isi%\")");
        $builder->where('substring(kondisi, 2, 1)', '1')->where('substring(kondisi, 3, 1)', '1');
        if ($osm == '1') $builder->Where('substring(is_alias, 5, 1)', '1');
        $builder->groupStart();
        if ($pelanggan === '1') $builder->orWhere('substring(is_alias, 1, 1)', '1');
        if ($suplier === '1') $builder->orWhere('substring(is_alias, 2, 1)', '1');
        if ($lain === '1') $builder->orWhere('substring(is_alias, 3, 1)', '1');
        if ($pegawai === '1') $builder->orWhere('substring(is_alias, 4, 1)', '1');
        $builder->groupEnd();
        $builder->orderby('kode');
        $builder->limit(jllimit);
        return $builder->get()->getResult();
    }
    // public function cekUserpegawai($userid, $idunik = false)
    // {
    //     $builder = $this->db->table('m_penerima');
    //     $builder->where('user_id', $userid);
    //     if ($idunik == true) $builder->where('idunik !=', $idunik);
    //     return $builder->get()->getResult();
    // }
    // public function getBiodata($userid, $atasan = false)
    // {
    //     $builder = $this->db->table('m_penerima a');
    //     $builder->select('a.*, b.kode as perusahaan, c.nama as wilayah, d.nama as divisi, e.nama as cabang, f.nama as atasan, g.nama as jabatan, h.nama as golongan, j.acc_setuju as level');
    //     ($atasan == true) ? $builder->where('a.atasan_id', $userid) : $builder->where('a.user_id', $userid);
    //     $builder->join('m_perusahaan b', 'a.perusahaan_id=b.id', 'left');
    //     $builder->join('m_divisi c', 'a.wilayah_id=c.id', 'left');
    //     $builder->join('m_divisi d', 'a.divisi_id=d.id', 'left');
    //     $builder->join('m_camp e', 'a.cabang_id=e.id', 'left');
    //     $builder->join('m_penerima f', 'a.atasan_id=f.id', 'left');
    //     $builder->join('m_divisi g', 'a.jabatan_id=g.id', 'left');
    //     $builder->join('m_divisi h', 'a.golongan_id=h.id', 'left');
    //     $builder->join('m_user j', 'a.user_id=j.id', 'left');
    //     return $builder->get()->getResult();
    // }
    // public function distPenerima()
    // {
    //     $builder = $this->db->table('m_select');
    //     $builder->select('nama')->distinct();
    //     $builder->where('param', 'kelakun')->where('kelompok', 'penerima');
    //     $builder->orderBy('nomor');
    //     return $builder->get()->getResult();
    // }

    // // ____________________________________________________________________________________________________________________________
    // public function getTanggal($tanggal)
    // {
    //     $builder = $this->db->table('m_kalender');
    //     $builder->where('tanggal', $tanggal)->where(['deleted_at' => null]);
    //     return $builder->get()->getResult();
    // }
    public function getKalender($tahun)
    {
        $builder = $this->db->table('m_kalender a');
        $builder->select('a.*, b.kode as user');
        $builder->where(['a.deleted_at' => null]);
        $builder->join('m_user b', 'a.save_by = b.id', 'left');
        if ($tahun != '') $builder->where('left(a.tanggal, 4)', $tahun);
        $builder->orderby('a.tanggal');
        return $builder->get()->getResult();
    }
}
