<?php

namespace App\Models\main;

use CodeIgniter\Model;

class InventarisModel extends Model
{
    protected $table      = 'm_inventaris';
    protected $allowedFields = [
        'idunik', 'kode', 'nama', 'kategori', 'lokasi', 'kakun_id', 'bukti', 'tgl_beli', 'ni_beli', 'ni_residu', 'mode_susut',
        'umur', 'sisa', 'ni_susut', 'perusahaan_id', 'wilayah_id', 'divisi_id', 'cabang_id', 'pegawai_id', 'gambar',
        'catatan', 'is_jual', 'kondisi', 'nolink', 'save_by', 'conf_by', 'aktif_by'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
