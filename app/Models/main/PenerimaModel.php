<?php

namespace App\Models\main;

use CodeIgniter\Model;

class PenerimaModel extends Model
{
    protected $table      = 'm_penerima';
    protected $allowedFields = [
        'idunik', 'kode', 'nip', 'nama', 'kategori', 'cabang_id', 'lokasi', 'kelamin', 'darah', 't4lahir', 'tgl_lahir', 'alamat',
        'kontak', 'email', 'ijasah', 'jurusan', 'st_ijasah', 'tgl_ijasah', 'jenis_sim', 'nosim', 'tgl_sim', 'st_ptkp', 'tgl_join',
        'st_pegawai', 'tgl_kontrakaw', 'tgl_kontrakak', 'pilih_keluar', 'tgl_keluar', 'alasan_keluar', 'jabatan_id', 'golongan_id',
        'user_id', 'atasan_id', 'asuransi', 'is_alias', 'kakun_pelanggan', 'kakun_suplier', 'kakun_lain', 'kakun_pegawai',
        'perusahaan_id', 'wilayah_id', 'divisi_id', 'gambar', 'catatan', 'kondisi', 'save_by', 'conf_by', 'aktif_by'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
